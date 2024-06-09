<?php

namespace App\Http\Controllers;

use App\Models\Banksoal;
use App\Models\Soal;
use App\Models\Matapelajaran;
use Illuminate\Http\Request;

class BanksoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $banksoals = Banksoal::orderBy('id', 'asc');
        if (request('matapelajaran_id')) {
            $banksoals->where('matapelajaran_id', request('matapelajaran_id'));
        }
        if (request('search')) {
            $banksoals->where('kodesoal', 'like', '%' . request('search') . '%');
        }
        return view('administrator.banksoal', [
            'menu' => 'referensi',
            'smenu' => 'user',
            'tab' => 'banksoal',
            'mapels' => Matapelajaran::all(),
            'banksoals' => $banksoals->paginate(10)->withQueryString()
        ]);
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
            'matapelajaran_id' => 'required',
            'kodesoal' => 'required'
            ]);
            $validated['user_id'] = auth()->user()->id;
            $existingKodeSoal = Banksoal::where('kodesoal', $validated['kodesoal'])
                                            ->where('user_id', auth()->user()->id)->first();
            if ($existingKodeSoal) {
                return redirect()->back()->with('failed', 'Gagal, Kode Soal telah ada');
            } else {
                Banksoal::create($validated);
                return redirect()->back()->with('success', 'Berhasil menambahkan bank soal');
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(Banksoal $banksoal)
    {
        return view('administrator.soal', [
            'menu' => 'referensi',
            'smenu' => 'user',
            'banksoal' => $banksoal,
            'mapels' => Matapelajaran::all(),
            'soals' => Soal::where('banksoal_id', $banksoal->id)->paginate(10)->withQueryString(),
            'mapel' => Matapelajaran::where('id', $banksoal->matapelajaran_id)->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banksoal $banksoal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banksoal $banksoal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banksoal $banksoal)
    {
        Banksoal::destroy($banksoal->id);
        Soal::where('banksoal_id',$banksoal->id)->delete();
        return redirect()->back()->with('success', 'Soal berhasil dihapus');
    }
}
