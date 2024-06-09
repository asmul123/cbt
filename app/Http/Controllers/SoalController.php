<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'soal' => 'required',
            'banksoal_id' => 'required',
            'jenissoal_id' => 'required'
            ]);
            
            $jawaban = "";
            for ($i = 'A'; $i <= 'F'; $i++) {
                if($request->{'jawaban'.$i} != ""){
                $jawaban = $jawaban . $i . "[_#_]" . $request->{'jawaban'.$i} . "[#_#]";
                }
            }
            $validated['kunci'] = $request->kunci;
            $validated['jawaban'] = $jawaban;
                Soal::create($validated);
                return redirect()->back()->with('success', 'Berhasil menambahkan soal');
            
    }

    /**
     * Display the specified resource.
     */
    public function show(Soal $soal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Soal $soal)
    {        
        return view('administrator.soaledit', [
            'menu' => 'referensi',
            'smenu' => 'user',
            'soal' => $soal
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Soal $soal)
    {
        $validated = $request->validate([
            'soal' => 'required'
            ]);
            $jawaban = "";
            for ($i = 'A'; $i <= 'F'; $i++) {
                if($request->{'jawaban'.$i} != ""){
                $jawaban = $jawaban . $i . "[_#_]" . $request->{'jawaban'.$i} . "[#_#]";
                }
            }
            $validated['jawaban'] = $jawaban;
            $validated['kunci'] = $request->kunci;
                Soal::where('id', $soal->id)
                    ->update($validated);
                return redirect(url('banksoal/'.$soal->banksoal_id))->with('success', 'Berhasil mengubah soal');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Soal $soal)
    {
        Soal::destroy($soal->id);
        return redirect()->back()->with('success', 'Soal berhasil dihapus');
    }
}
