<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Aksesuser;
use App\Models\Tahunpelajaran;
use App\Models\Rombonganbelajar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tahunaktif = Tahunpelajaran::where('is_active', '1')->first();
        $jumlahakses = Aksesuser::where('tahunpelajaran_id',$tahunaktif->id);
        $jumlahrombel = Rombonganbelajar::where('tahunpelajaran_id',$tahunaktif->id);
        return view('administrator.dashboard', [
            'menu' => 'dashboard',
            'jumlahadmin' => User::where('role_id','1')->count(),
            'jumlahguru' => User::where('role_id','2')->count(),
            'jumlahsiswa' => User::where('role_id','3')->count(),
            'jumlahtu' => User::where('role_id','4')->count(),
            'jumlahkepsek' => $jumlahakses->where('hakakses_id','1')->count(),
            'jumlahkuri' => $jumlahakses->where('hakakses_id','2')->count(),
            'jumlahwali' => $jumlahakses->where('hakakses_id','3')->count(),
            'jumlahkaprog' => $jumlahakses->where('hakakses_id','4')->count(),
            'jumlahrombel' => $jumlahrombel->count(),
            'smenu' => ''
        ]);
    }
}
