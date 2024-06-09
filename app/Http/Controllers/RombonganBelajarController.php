<?php

namespace App\Http\Controllers;

use App\Models\Rombonganbelajar;
use App\Models\Tahunpelajaran;
use App\Models\User;
use App\Models\Aksesuser;
use App\Models\Anggotarombel;
use App\Models\Kurikulum;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;

class RombonganBelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rombels = Rombonganbelajar::orderBy('tahunpelajaran_id', 'asc')->orderBy('rombongan_belajar', 'asc');
        if (request('tapel_id')) {
            $rombels->where('tahunpelajaran_id', request('tapel_id'));
        }
        if (request('search')) {
            $rombels->where('rombongan_belajar', 'like', '%' . request('search') . '%');
        }


        return view('rombel', [
            'menu' => 'referensi',
            'smenu' => 'user',
            'rombels' => $rombels->paginate(10)->withQueryString(),
            'tapels' => Tahunpelajaran::all(),
            'kurikulums' => Kurikulum::all(),
            'users' => User::where('role_id','2')->orderBy('name', 'asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $spreadsheet = IOFactory::load('assets/file/format_rombel.xlsx');

        $worksheet = $spreadsheet->getActiveSheet();
        $tahunpelajarans = Tahunpelajaran::orderBy('tapel_code', 'asc')->get();
        $walikelass = User::where('role_id', 2)->orderBy('name','asc')->get();
        $kurikulums = Kurikulum::all();
        $i = 3;
        foreach($tahunpelajarans as $tahunpelajaran):    
            $worksheet->getCell('F'.$i)->setValue($tahunpelajaran->id);
            $worksheet->getCell('G'.$i)->setValue($tahunpelajaran->tahunpelajaran);
            $i++;
        endforeach;

        $i = 3;
        foreach($walikelass as $walikelas):    
            $worksheet->getCell('I'.$i)->setValue($walikelas->id);
            $worksheet->getCell('J'.$i)->setValue($walikelas->name);
            $i++;
        endforeach;

        $i = 3;
        foreach($kurikulums as $kurikulum):    
            $worksheet->getCell('L'.$i)->setValue($kurikulum->id);
            $worksheet->getCell('M'.$i)->setValue($kurikulum->kurikulum);
            $i++;
        endforeach;
        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save("assets/file/format_rombel_last.xlsx");
        return redirect("assets/file/format_rombel_last.xlsx");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rombongan_belajar' => 'required',
            'tahunpelajaran_id' => 'required',
            'kurikulum_id' => 'required'
        ]);
        $cekNama = Rombonganbelajar::where('tahunpelajaran_id', $validated['tahunpelajaran_id'])
                                    ->where('rombongan_belajar', $validated['rombongan_belajar'])->first();
        if($cekNama){            
            return redirect()->back()->with('failed', 'Gagal, Nama Kelas telah ada');
        } else {
            if($request->user_id!=""){
                $cekWalas = Rombonganbelajar::where('tahunpelajaran_id', $validated['tahunpelajaran_id'])
                                            ->where('user_id',$request->user_id)->first();
                if ($cekWalas) {            
                    return redirect()->back()->with('failed', 'Gagal, Guru tersebut telah ditugaskan pada Kelas lain');
                } else {
                    $cekAksesWalas = Aksesuser::where('tahunpelajaran_id', $validated['tahunpelajaran_id'])
                                ->where('user_id',$request->user_id)->first();
                    if(!$cekAksesWalas){
                        $dataakses = ([
                            'tahunpelajaran_id' => $validated['tahunpelajaran_id'],
                            'hakakses_id' => 3,
                            'user_id' => $request->user_id
                            // Tambahkan kolom lain sesuai kebutuhan
                        ]);
                        Aksesuser::create($dataakses);
                    }
                    $validated['user_id'] = $request->user_id;
                    Rombonganbelajar::create($validated);
                }
            } else {
            $validated['user_id'] = $request->user_id;
            Rombonganbelajar::create($validated);
            }
        return redirect()->back()->with('success', 'Rombongan belajar berhasil disimpan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Rombonganbelajar $rombonganbelajar)
    {
        $anggotarombels = Anggotarombel::where('rombonganbelajar_id', $rombonganbelajar->id);
        if (request('search')) {
            $anggotarombels->whereRelation('user','name', 'like', '%'. request('search').'%' );
        }

        return view('anggotarombel', [
            'menu' => 'referensi',
            'smenu' => 'user',
            'users' => User::where('role_id', 3)->get(),
            'rombonganbelajar' => $rombonganbelajar,
            'anggotarombels' => $anggotarombels->paginate(10)->withQueryString()
        ]);
    }

    public function import(Request $request)
    {
        if ($request->hasFile('excel_file')) {
            $path = $request->file('excel_file')->getRealPath();

            $spreadsheet = IOFactory::load($path);
            $sheet = $spreadsheet->getActiveSheet();
            $berhasil = 0;
            $gagal = 0;
            $i=1;
            foreach ($sheet->getRowIterator() as $row) {
                if($i!=1){
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false); // Loop semua sel

                    // Mengambil nilai dari setiap sel dalam baris
                    $data = [];
                    foreach ($cellIterator as $cell) {
                        $data[] = $cell->getValue();
                    }
                    // Simpan data ke dalam database menggunakan model
                    $dataisi = ([
                        'tahunpelajaran_id' => $data[1],
                        'rombongan_belajar' => $data[0],
                        'user_id' => $data[2],
                        'kurikulum_id' => $data[3]
                        // Tambahkan kolom lain sesuai kebutuhan
                    ]);
                    $cekNama = Rombonganbelajar::where('tahunpelajaran_id', $data[1])
                                    ->where('rombongan_belajar',$data[0])->first();
                    if($cekNama || $data[0]==""){
                        $gagal++;
                    } else {
                        if($data[2]!=""){
                            $cekWalas = Rombonganbelajar::where('tahunpelajaran_id', $data[0])
                                        ->where('user_id',$data['2'])->first();
                            if ($cekWalas) {
                                $gagal++;
                            } else {
                                $cekAksesWalas = Aksesuser::where('tahunpelajaran_id', $data[0])
                                ->where('user_id',$data['2'])->first();
                                if(!$cekAksesWalas){
                                    $dataakses = ([
                                        'tahunpelajaran_id' => $data[1],
                                        'hakakses_id' => 3,
                                        'user_id' => $data[2]
                                        // Tambahkan kolom lain sesuai kebutuhan
                                    ]);
                                    Aksesuser::create($dataakses);
                                }
                                Rombonganbelajar::create($dataisi);
                                $berhasil++;
                            }
                        } else {
                            Rombonganbelajar::create($dataisi);
                            $berhasil++;
                        }
                    }
                }
                $i++;
                
            }
            return redirect()->back()->with('success', $berhasil . ' User berhasil disimpan ' . $gagal . ' User gagal disimpan');
        }

        return redirect()->back()->with('failed', 'Silahkan Unggah Berkas!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rombonganbelajar $rombonganbelajar)
    {
        return view('rombeledit', [
            'menu' => 'referensi',
            'smenu' => 'user',
            'rombel' => $rombonganbelajar,
            'users' => User::where('role_id','2')->orderBy('name', 'asc')->get(),
            'tapels' => Tahunpelajaran::all(),
            'kurikulums' => Kurikulum::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rombonganbelajar $rombonganbelajar)
    {
        $validated = $request->validate([
            'rombongan_belajar' => 'required',
            'tahunpelajaran_id' => 'required',
            'kurikulum_id' => 'required'
        ]);
        $cekNama = Rombonganbelajar::where('tahunpelajaran_id', $validated['tahunpelajaran_id'])
                                    ->where('rombongan_belajar', $validated['rombongan_belajar'])->first();
        if($validated['rombongan_belajar']!=$rombonganbelajar->rombongan_belajar and $cekNama){            
            return redirect(url('/rombonganbelajar'))->with('failed', 'Gagal, Nama Kelas telah ada');
        } else {
            if($request->user_id!=""){
                $cekWalas = Rombonganbelajar::where('tahunpelajaran_id', $validated['tahunpelajaran_id'])
                                            ->where('rombongan_belajar','!=', $rombonganbelajar->rombongan_belajar)
                                            ->where('user_id',$request->user_id)->first();
                if ($cekWalas) {            
                    return redirect(url('/rombonganbelajar'))->with('failed', 'Gagal, Guru tersebut telah ditugaskan pada Kelas lain');
                } else {
                    $cekAksesWalas = Aksesuser::where('tahunpelajaran_id', $validated['tahunpelajaran_id'])
                                ->where('user_id',$request->user_id)->first();
                    if(!$cekAksesWalas){
                        $dataakses = ([
                            'tahunpelajaran_id' => $validated['tahunpelajaran_id'],
                            'hakakses_id' => 3,
                            'user_id' => $request->user_id
                            // Tambahkan kolom lain sesuai kebutuhan
                        ]);
                        Aksesuser::create($dataakses);
                    }
                    $validated['user_id'] = $request->user_id;
                    Rombonganbelajar::where('id', $rombonganbelajar->id)
                                    ->update($validated);
                }
            } else {
            $validated['user_id'] = $request->user_id;
            Rombonganbelajar::where('id', $rombonganbelajar->id)
                            ->update($validated);
            }
        return redirect('/rombonganbelajar')->with('success', 'Rombongan belajar berhasil diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rombonganbelajar $rombonganbelajar)
    {
        Rombonganbelajar::destroy($rombonganbelajar->id);
        return redirect()->back()->with('success', 'Rombongan belajar berhasil dihapus');
    }
}
