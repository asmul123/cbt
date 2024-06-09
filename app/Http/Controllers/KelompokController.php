<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\Ruangan;
use App\Models\Rombonganbelajar;
use App\Models\Tahunpelajaran;
use App\Models\User;
use App\Models\Anggotakelompok;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        $kelompoks = Kelompok::orderBy('tahunpelajaran_id', 'asc');
        if (request('tapel_id')) {
            $kelompoks->where('tahunpelajaran_id', request('tapel_id'));
        }
        if (request('search')) {
            $kelompoks->where('kelompok', 'like', '%' . request('search') . '%');
        }

        return view('administrator.kelompok', [
            'menu' => 'referensi',
            'smenu' => 'user',
            'kelompoks' => $kelompoks->paginate(10)->withQueryString(),
            'tapels' => Tahunpelajaran::all(),
            'ruangans' => Ruangan::all(),
            'rombels' => Rombonganbelajar::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $spreadsheet = IOFactory::load('assets/file/format_kelompok.xlsx');

        $worksheet = $spreadsheet->getActiveSheet();
        $tahunpelajarans = Tahunpelajaran::orderBy('tapel_code', 'asc')->get();
        $rombels = Rombonganbelajar::all();
        $ruangans = Ruangan::all();
        $i = 3;
        foreach($tahunpelajarans as $tahunpelajaran):    
            $worksheet->getCell('E'.$i)->setValue($tahunpelajaran->id);
            $worksheet->getCell('F'.$i)->setValue($tahunpelajaran->tahunpelajaran);
            $i++;
        endforeach;
        $i = 3;
        foreach($ruangans as $ruangan):    
            $worksheet->getCell('H'.$i)->setValue($ruangan->ruangan);
            $i++;
        endforeach;
        $i = 3;
        foreach($rombels as $rombel):    
            $worksheet->getCell('I'.$i)->setValue($rombel->rombongan_belajar);
            $i++;
        endforeach;

        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save("assets/file/format_kelompok_last.xlsx");
        return redirect("assets/file/format_kelompok_last.xlsx");
    }

    public function format()
    {
        $spreadsheet = IOFactory::load('assets/file/format_anggota_kelompok.xlsx');

        $worksheet = $spreadsheet->getActiveSheet();
        $tahunpelajarans = Tahunpelajaran::orderBy('tapel_code', 'asc')->get();
        $rombels = Rombonganbelajar::all();
        $ruangans = Ruangan::all();
        $i = 3;
        foreach($tahunpelajarans as $tahunpelajaran):    
            $worksheet->getCell('F'.$i)->setValue($tahunpelajaran->id);
            $worksheet->getCell('G'.$i)->setValue($tahunpelajaran->tahunpelajaran);
            $i++;
        endforeach;
        $i = 3;
        foreach($ruangans as $ruangan):    
            $worksheet->getCell('I'.$i)->setValue($ruangan->ruangan);
            $i++;
        endforeach;
        $i = 3;
        foreach($rombels as $rombel):    
            $worksheet->getCell('J'.$i)->setValue($rombel->rombongan_belajar);
            $i++;
        endforeach;

        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save("assets/file/format_anggota_kelompok_last.xlsx");
        return redirect("assets/file/format_anggota_kelompok_last.xlsx");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelompok $kelompok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelompok $kelompok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelompok $kelompok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelompok $kelompok)
    {
        //
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
                    $ruangan_id = Ruangan::where('ruangan', $data[1])->first()->id;
                    $rombel_id = Rombonganbelajar::where('rombongan_belajar', $data[0])->first()->id;
                    $dataisi = ([
                        'tahunpelajaran_id' => $data[2],
                        'ruangan_id' => $ruangan_id,
                        'rombonganbelajar_id' => $rombel_id,
                    ]);
                    $cekKelompok = Kelompok::where('tahunpelajaran_id', $data[2])
                                    ->where('ruangan_id',$ruangan_id)
                                    ->where('rombonganbelajar_id',$rombel_id)->first();
                    if($cekKelompok || $data[0]==""){
                        $gagal++;
                    } else {
                            Kelompok::create($dataisi);
                            $berhasil++;
                    }
                }
                $i++;
                
            }
            return redirect()->back()->with('success', $berhasil . ' Kelompok berhasil disimpan ' . $gagal . ' Kelompok gagal disimpan');
        }

        return redirect()->back()->with('failed', 'Silahkan Unggah Berkas!');
    }
    
    public function importanggota(Request $request)
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
                    $user_id = User::where('username', $data[0])->first()->id;
                    $ruangan_id = Ruangan::where('ruangan', $data[2])->first()->id;
                    $rombel_id = Rombonganbelajar::where('rombongan_belajar', $data[1])->first()->id;
                    $kelompok_id = Kelompok::where('ruangan_id', $ruangan_id)
                                            ->where('rombonganbelajar_id', $rombel_id)->first()->id;
                    $dataisi = ([
                        'tahunpelajaran_id' => $data[3],
                        'kelompok_id' => $kelompok_id,
                        'user_id' => $user_id
                    ]);
                    $cekAnggota = Anggotakelompok::where('tahunpelajaran_id', $data[3])
                                    ->where('kelompok_id',$kelompok_id)
                                    ->where('user_id',$user_id)->first();
                    if($cekAnggota || $data[0]==""){
                        $gagal++;
                    } else {
                            Anggotakelompok::create($dataisi);
                            $berhasil++;
                    }
                }
                $i++;
                
            }
            return redirect()->back()->with('success', $berhasil . ' Anggota kelompok berhasil disimpan ' . $gagal . ' Anggota kelompok gagal disimpan');
        }

        return redirect()->back()->with('failed', 'Silahkan Unggah Berkas!');
    }
}
