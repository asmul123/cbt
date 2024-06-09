<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\Tahunpelajaran;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ruangans = Ruangan::orderBy('tahunpelajaran_id', 'asc')->orderBy('ruangan', 'asc');
        if (request('tapel_id')) {
            $ruangans->where('tahunpelajaran_id', request('tapel_id'));
        }
        if (request('search')) {
            $ruangans->where('ruangan', 'like', '%' . request('search') . '%');
        }

        return view('administrator.ruangan', [
            'menu' => 'referensi',
            'smenu' => 'user',
            'ruangans' => $ruangans->paginate(10)->withQueryString(),
            'tapels' => Tahunpelajaran::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $spreadsheet = IOFactory::load('assets/file/format_ruangan.xlsx');

        $worksheet = $spreadsheet->getActiveSheet();
        $tahunpelajarans = Tahunpelajaran::orderBy('tapel_code', 'asc')->get();
        $i = 3;
        foreach($tahunpelajarans as $tahunpelajaran):    
            $worksheet->getCell('D'.$i)->setValue($tahunpelajaran->id);
            $worksheet->getCell('E'.$i)->setValue($tahunpelajaran->tahunpelajaran);
            $i++;
        endforeach;

        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save("assets/file/format_ruangan_last.xlsx");
        return redirect("assets/file/format_ruangan_last.xlsx");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ruangan' => 'required',
            'tahunpelajaran_id' => 'required'
        ]);
        $cekNama = Ruangan::where('tahunpelajaran_id', $validated['tahunpelajaran_id'])
                                    ->where('ruangan', $validated['ruangan'])->first();
        if($cekNama){            
            return redirect()->back()->with('failed', 'Gagal, Nama Ruangan telah ada');
        } else {
            Ruangan::create($validated);
            return redirect()->back()->with('success', 'Ruangan berhasil disimpan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ruangan $ruangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ruangan $ruangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ruangan $ruangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ruangan $ruangan)
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
                    $dataisi = ([
                        'tahunpelajaran_id' => $data[1],
                        'ruangan' => $data[0]
                    ]);
                    $cekNama = Ruangan::where('tahunpelajaran_id', $data[1])
                                    ->where('ruangan',$data[0])->first();
                    if($cekNama || $data[0]==""){
                        $gagal++;
                    } else {
                            Ruangan::create($dataisi);
                            $berhasil++;
                    }
                }
                $i++;
                
            }
            return redirect()->back()->with('success', $berhasil . ' Ruangan berhasil disimpan ' . $gagal . ' Ruangan gagal disimpan');
        }

        return redirect()->back()->with('failed', 'Silahkan Unggah Berkas!');
    }

}
