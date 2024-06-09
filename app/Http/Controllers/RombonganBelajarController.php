<?php

namespace App\Http\Controllers;

use App\Models\Rombonganbelajar;
use App\Models\Tahunpelajaran;
use App\Models\User;
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

        return view('administrator.rombel', [
            'menu' => 'referensi',
            'smenu' => 'user',
            'rombels' => $rombels->paginate(10)->withQueryString(),
            'tapels' => Tahunpelajaran::all()
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
        $i = 3;
        foreach($tahunpelajarans as $tahunpelajaran):    
            $worksheet->getCell('D'.$i)->setValue($tahunpelajaran->id);
            $worksheet->getCell('E'.$i)->setValue($tahunpelajaran->tahunpelajaran);
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
            'tahunpelajaran_id' => 'required'
        ]);
        $cekNama = Rombonganbelajar::where('tahunpelajaran_id', $validated['tahunpelajaran_id'])
                                    ->where('rombongan_belajar', $validated['rombongan_belajar'])->first();
        if($cekNama){            
            return redirect()->back()->with('failed', 'Gagal, Nama Kelas telah ada');
        } else {
            Rombonganbelajar::create($validated);
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

        return view('administrator.anggotarombel', [
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
                        'rombongan_belajar' => $data[0]
                    ]);
                    $cekNama = Rombonganbelajar::where('tahunpelajaran_id', $data[1])
                                    ->where('rombongan_belajar',$data[0])->first();
                    if($cekNama || $data[0]==""){
                        $gagal++;
                    } else {
                            Rombonganbelajar::create($dataisi);
                            $berhasil++;
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
        return view('administrator.rombeledit', [
            'menu' => 'referensi',
            'smenu' => 'user',
            'rombel' => $rombonganbelajar,
            'tapels' => Tahunpelajaran::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rombonganbelajar $rombonganbelajar)
    {
        $validated = $request->validate([
            'rombongan_belajar' => 'required',
            'tahunpelajaran_id' => 'required'
        ]);
        $cekNama = Rombonganbelajar::where('tahunpelajaran_id', $validated['tahunpelajaran_id'])
                                    ->where('rombongan_belajar', $validated['rombongan_belajar'])->first();
        if($validated['rombongan_belajar']!=$rombonganbelajar->rombongan_belajar and $cekNama){            
            return redirect(url('/rombonganbelajar'))->with('failed', 'Gagal, Nama Kelas telah ada');
        } else {
            Rombonganbelajar::where('id', $rombonganbelajar->id)
                            ->update($validated);
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
