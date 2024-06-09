<?php

namespace App\Http\Controllers;

use App\Models\Anggotarombel;
use Illuminate\Http\Request;

class AnggotarombelController extends Controller
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
            'user_id' => 'required'
        ]);
        $validated['tahunpelajaran_id'] = $request->tahunpelajaran_id;
        $validated['rombonganbelajar_id'] = $request->rombonganbelajar_id;
        $gagal = 0;
        $berhasil = 0;
        $users_id = $request->user_id;
        $count = count($users_id);
		for ($i = 0; $i < $count; $i++) {
			$user_id = $users_id[$i];
            $existingAnggota = Anggotarombel::where('tahunpelajaran_id', $validated['tahunpelajaran_id'])
                                            ->where('user_id', $user_id)->first();
            $validated['user_id'] = $user_id;
            if ($existingAnggota) {
                $gagal++;
            } else {
                Anggotarombel::create($validated);
                $berhasil++;
            }
        }
        return redirect()->back()->with('success', 'Berhasil menambahkan '.$berhasil.' User dan '.$gagal.' User gagal ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anggotarombel $anggotarombel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggotarombel $anggotarombel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anggotarombel $anggotarombel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggotarombel $anggotarombel)
    {        
        Anggotarombel::destroy($anggotarombel->id);
        return redirect()->back()->with('success', 'Anggota Rombongan belajar berhasil dihapus');
    }
}
