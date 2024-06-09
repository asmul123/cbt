<?php

namespace App\Http\Controllers;

use App\Models\Aksesuser;
use Illuminate\Http\Request;

class AksesuserController extends Controller
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
            'tahunpelajaran_id' => 'required',
            'hakakses_id' => 'required',
            'user_id' => 'required'
        ]);
        $gagal = 0;
        $berhasil = 0;
        $users_id = $request->user_id;
        $count = count($users_id);
		for ($i = 0; $i < $count; $i++) {
			$user_id = $users_id[$i];
            $existingHakAkses = Aksesuser::where('tahunpelajaran_id', $validated['tahunpelajaran_id'])
                                            ->where('user_id', $user_id)->first();
            $validated['user_id'] = $user_id;
            if ($existingHakAkses) {
                $gagal++;
            } else {
                Aksesuser::create($validated);
                $berhasil++;
            }
        }
        return redirect()->back()->with('success', 'Berhasil menambahkan '.$berhasil.' User dan '.$gagal.' User gagal ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aksesuser $aksesuser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aksesuser $aksesuser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aksesuser $aksesuser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aksesuser $aksesuser)
    {
        Aksesuser::destroy($aksesuser->id);
        return redirect()->back()->with('success', 'Akses user berhasil dihapus');
    }
}
