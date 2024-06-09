<?php

namespace App\Http\Controllers;

use App\Models\Penjadwalan;
use App\Models\Ruangan;
use App\Models\Kelompok;
use Illuminate\Http\Request;

class PengawasanController extends Controller
{
    public function index()
    {
        $ruangan_id = Ruangan::where('user_id', auth()->user()->id)->first()->id;
        $kelompoks = Kelompok::where('ruangan_id', $ruangan_id)->get();
        $penjadwalans = Penjadwalan::where('banksoal_id', '!= 0')->orderBy('waktumulai', 'asc');
        if (request('kelompok_id')) {
            $penjadwalans->where('kelompok_id', request('kelompok_id'));
        } else{
            foreach($kelompoks as $kelompok){
                $penjadwalans->orWhere('kelompok_id', $kelompok->id);
            }
        }
        if (request('search')) {
            $penjadwalans->where('judultugas', 'like', '%' . request('search') . '%');
        }

        return view('pengawas.penjadwalan', [
            'menu' => 'dashboard',
            'penjadwalans' => $penjadwalans->paginate(10)->withQueryString(),
            'kelompoks' => $kelompoks
        ]);
    }

}
