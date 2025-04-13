<?php

namespace App\Http\Controllers;

use App\Models\Penjadwalan;
use App\Models\Pengerjaan;
use App\Models\Anggotakelompok;
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

    public function show(Request $request)
    {        
            $penjadwalan=Penjadwalan::where('id', $request->penjadwalan_id)->first();
            $anggotarombels = Anggotakelompok::where('kelompok_id', $penjadwalan->kelompok_id);
            if (request('search')) {
                $anggotarombels->whereRelation('user','name', 'like', '%'. request('search').'%' );
            }
            return view('pengawas.detailpengerjaan', [
                'menu' => 'dashboard',
                'penjadwalan' => $penjadwalan,
                'anggotarombels' => $anggotarombels->paginate(10)->withQueryString()
                ]);
    }

    public function create()
    {
        if(request('act')=='release'){
            $cekPenjadwalan = Penjadwalan::where('id', request('id_tugas'))->where('user_id', auth()->user()->id)
                                        ->first();
            if($cekPenjadwalan){            
                $token = substr(str_shuffle(str_repeat($x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(6 / strlen($x)))), 1, 6);
                $data = array(
                    'token' => $token
                );
                Penjadwalan::where('id',request('id_tugas'))->update($data);
                return redirect(url('pengawasan/'.request('id_tugas')))->with('success', 'Token berhasil diubah');
            } else {
                return redirect(url('pengawasan/'.request('id_tugas')))->with('failed', 'Data tugas tidak ditemukan');                
            }
        }
        else if(request('act')=='hapus'){
            $cekPenjadwalan = Penjadwalan::where('id', request('id_tugas'))->where('user_id', auth()->user()->id)
                                        ->first();
            if($cekPenjadwalan){      
                $data = array(
                    'token' => NULL
                );
                Penjadwalan::where('id',request('id_tugas'))->update($data);
                return redirect(url('pengawasan/'.request('id_tugas')))->with('success', 'Token berhasil dihapus');
            } else {
                return redirect(url('pengawasan/'.request('id_tugas')))->with('failed', 'Data tugas tidak ditemukan');                
            }            
        }
        else if (request('act')=='reset'){
            $data = array(
                'status' => '1'
            );
            Pengerjaan::where('id',request('pengerjaan_id'))->update($data);
            return redirect()->back()->with('success', 'Pekerjaan berhasil direset');
        }
        else if (request('act')=='selesai'){
            $data = array(
                'status' => '2'
            );
            Pengerjaan::where('id',request('pengerjaan_id'))->update($data);
            return redirect()->back()->with('success', 'Pekerjaan berhasil diselesaikan');
        }
        else if (request('act')=='blokir'){
            if(Pengerjaan::where('id',request('pengerjaan_id'))->first()->status == 3){
                $data = array(
                    'status' => '1'
                );
            } else {
                $data = array(
                    'status' => '3'
                );
            }
            Pengerjaan::where('id',request('pengerjaan_id'))->update($data);
            return redirect()->back()->with('success', 'Status blokir berhasil diubah');
        }
        else {
            return redirect(url('penjadwalan/'.request('id_tugas')))->with('failed', 'Aksi tidak ditemukan');
        }
    }

}
