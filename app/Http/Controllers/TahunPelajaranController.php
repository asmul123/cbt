<?php

namespace App\Http\Controllers;

use App\Models\Tahunpelajaran;
use Illuminate\Http\Request;

class TahunPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tapels = TahunPelajaran::orderBy('tapel_code', 'asc');

        return view('tapel', [
            'menu' => 'pengaturan',
            'smenu' => 'tahunpelajaran',
            'tapels' => $tapels->paginate(10)
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
            'year' => 'required|numeric'
        ]);
        $tapel_code = $request->year . $request->semester;

        $existingTapel = Tahunpelajaran::where('tapel_code', $tapel_code)->first();

        if ($existingTapel) {
            return redirect()->back()->with('failed', 'Gagal, Tahun Pelajaran sudah ada');
        } else {
            if ($request->semester == 1) {
                $nextyear = $request->year + 1;
                $tahunpelajaran = $request->year . "-" . $nextyear . " Ganjil";
            } else {
                $nextyear = $request->year + 1;
                $tahunpelajaran = $request->year . "-" . $nextyear . " Genap";
            }
            ($request->is_active === 1 ? $is_active = 1 : $is_active = 0);
            $data = ([
                'tapel_code' => $tapel_code,
                'tahunpelajaran' => $tahunpelajaran,
                'is_active' => $is_active
            ]);
            Tahunpelajaran::create($data);
            return redirect()->back()->with('success', 'User berhasil disimpan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tahunpelajaran $tahunpelajaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tahunpelajaran $tahunpelajaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tahunpelajaran $tahunpelajaran)
    {
        $data_active = ([
            'is_active' => 1
        ]);
        Tahunpelajaran::where('id', $tahunpelajaran->id)
            ->update($data_active);
        $data_deactive = ([
            'is_active' => 0
        ]);

        Tahunpelajaran::whereNot('id', $tahunpelajaran->id)
            ->update($data_deactive);
        return redirect(url('/tahunpelajaran'))->with('success', 'User berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tahunpelajaran $tahunpelajaran)
    {
        Tahunpelajaran::destroy($tahunpelajaran->id);
        return redirect()->back()->with('success', 'Tahun Pelajaran berhasil dihapus');
    }
}
