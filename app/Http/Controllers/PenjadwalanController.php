<?php

namespace App\Http\Controllers;

use App\Models\Penjadwalan;
use App\Models\Pengerjaan;
use App\Models\Kelompok;
use App\Models\Banksoal;
use App\Models\Soal;
use App\Models\Jawabanuraian;
use App\Models\Rombonganbelajar;
use App\Models\Anggotakelompok;
use Illuminate\Http\Request;

class PenjadwalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjadwalans = Penjadwalan::orderBy('kelompok_id', 'asc');
        if (request('kelompok_id')) {
            $penjadwalans->where('kelompok_id', request('kelompok_id'));
        }
        if (request('search')) {
            $penjadwalans->where('judultugas', 'like', '%' . request('search') . '%');
        }

        return view('administrator.penjadwalan', [
            'menu' => 'pelaksanaan',
            'smenu' => 'penjadwalan',
            'penjadwalans' => $penjadwalans->paginate(10)->withQueryString(),
            'banksoals' => Banksoal::all(),
            'kelompoks' => Kelompok::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
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
                return redirect(url('/penjadwalan/'.request('id_tugas')))->with('success', 'Token berhasil diubah');
            } else {
                return redirect(url('/penjadwalan/'.request('id_tugas')))->with('failed', 'Data tugas tidak ditemukan');                
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
                return redirect(url('/penjadwalan/'.request('id_tugas')))->with('success', 'Token berhasil dihapus');
            } else {
                return redirect(url('/penjadwalan/'.request('id_tugas')))->with('failed', 'Data tugas tidak ditemukan');                
            }            
        }  
        else if (request('act')=='detail'){
            $pengerjaan = Pengerjaan::where('id', request('pengerjaan_id'))->first();
            return view('administrator.detailkuis', [
                'menu' => 'pembelaksanaan',
                'smenu' => 'penjadwalan',
                'pengerjaan' => $pengerjaan,
                'penjadwalan' => Penjadwalan::where('id', $pengerjaan->penjadwalan_id)->first()
                ]);
            
        }
        else if (request('act')=='reset'){
            Pengerjaan::destroy(request('pengerjaan_id'));
            Jawabanuraian::where('pengerjaan_id',request('pengerjaan_id'))->delete();
            return redirect()->back()->with('success', 'Pekerjaan berhasil dihapus/diatur ulang');
        }
        else if (request('act')=='selesai'){
            $data = array(
                'status' => '2'
            );
            Pengerjaan::where('id',request('pengerjaan_id'))->update($data);
            return redirect()->back()->with('success', 'Pekerjaan berhasil diselesaikan');
        }
        else if (request('act')=='blokir'){
            $data = array(
                'status' => '3'
            );
            Pengerjaan::where('id',request('pengerjaan_id'))->update($data);
            return redirect()->back()->with('success', 'Pekerjaan berhasil diblokir');
        }
        else {
            return redirect(url('penjadwalan/'.request('id_tugas')))->with('failed', 'Aksi tidak ditemukan');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judultugas' => 'required'
        ]);
        $validated['user_id'] = auth()->user()->id;
        $validated['deskripsitugas'] = $request->deskripsitugas;
        $validated['banksoal_id'] = $request->banksoal_id;
        ($request->acaksoal == "" ?
                    $acaksoal = '0' : $acaksoal = $request->acaksoal
                );
        $validated['acaksoal'] = $acaksoal;
        ($request->acakjawaban == "" ?
            $acakjawaban = '0' : $acakjawaban = $request->acakjawaban
        );
        $validated['acakjawaban'] = $acakjawaban;
        ($request->durasi == "" ?
            $durasi = '00:00:00' : $durasi = $request->durasi
        );
        $validated['durasi'] = $durasi;
        
        $validated['waktumulai'] = $request->tanggalmulai." ".$request->waktumulai;
        $validated['waktuselesai'] = $request->tanggalselesai." ".$request->waktuselesai;
        ($request->terlambat == "" ?
            $terlambat = '0' : $terlambat = $request->terlambat
        );
        $validated['terlambat'] = $terlambat;
        $gagal = 0;
        $berhasil = 0;
        if($request->tingkat){
            $rombels = Rombonganbelajar::where('tingkat', $request->tingkat)->get();
            foreach($rombels as $rombel){
                $kelompoks = Kelompok::where('rombonganbelajar_id', $rombel->id)->get();
                foreach($kelompoks as $kelompok){
                    $validated['kelompok_id'] = $kelompok->id;
                    if($request->token == 1){
                        $validated['token'] = substr(str_shuffle(str_repeat($x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(6 / strlen($x)))), 1, 6);
                    }
                    Penjadwalan::create($validated);
                    $berhasil++;
                }
            }
        } else {
            $kelompoks_id = $request->kelompok_id;
            $count = count($kelompoks_id);
            for ($i = 0; $i < $count; $i++) {
                $validated['kelompok_id'] = $kelompoks_id[$i];
                if($request->token == 1){
                    $validated['token'] = substr(str_shuffle(str_repeat($x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(6 / strlen($x)))), 1, 6);
                }
                    Penjadwalan::create($validated);
                    $berhasil++;
            }
        }
        return redirect(url('penjadwalan'))->with('success', 'Berhasil menambahkan '.$berhasil.' Jadwal');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjadwalan $penjadwalan)
    {
        if(auth()->user()->role_id == 3){
            if(session()->has('pengerjaan')){
                // session()->forget('penugasan');
                return redirect('pengerjaan/'.session('pengerjaan'));
            } else {
                $cekpengerjaan = Pengerjaan::where('penjadwalan_id', $penjadwalan->id)->where('user_id', auth()->user()->id)->first();
                // dd($cekpengerjaan);
                if($penjadwalan->waktuselesai < date('Y-m-d H:i:s') && $penjadwalan->terlambat == 0 && !$cekpengerjaan){
                    return view('pesertadidik.statustugas', [
                        'menu' => 'dashboard',
                        'status' => 'ditutup',
                        'penjadwalan' => $penjadwalan
                    ]);
                } 
                else if($cekpengerjaan && $cekpengerjaan->status != "1"){
                    if($cekpengerjaan->status == "2"){
                        return view('pesertadidik.statustugas', [
                            'menu' => 'dashboard',
                            'status' => 'selesai',
                            'penjadwalan' => $penjadwalan,
                            'pengerjaan' => Pengerjaan::where('penjadwalan_id', $penjadwalan->id)->where('user_id', auth()->user()->id)->first()
                        ]);
                    } else if($cekpengerjaan->status == "3"){
                        return view('pesertadidik.statustugas', [
                            'menu' => 'dashboard',
                            'status' => 'blokir',
                            'penjadwalan' => $penjadwalan,
                            'pengerjaan' => Pengerjaan::where('penjadwalan_id', $penjadwalan->id)->where('user_id', auth()->user()->id)->first()
                        ]);
                    }
                } else if($penjadwalan->token != NULL){
                    return view('pesertadidik.inputtoken', [
                        'menu' => 'dashboard',
                        'penjadwalan' => $penjadwalan
                    ]);
                } else {
                    $validated['penjadwalan_id'] = $penjadwalan->id;
                    session(['pengerjaan' => $cekpengerjaan->id]);
                        if($penjadwalan->acaksoal == '1'){
                        $datasoal = Soal::where('banksoal_id', $penjadwalan->banksoal_id)
                                    ->orderBy('jenissoal_id', 'asc')
                                    ->inRandomOrder()->get();
                        } else {
                        $datasoal = Soal::where('banksoal_id', $penjadwalan->banksoal_id)
                                        ->get();
                        }
                        if($datasoal->count() != 0){
                            $rekaman = "";
                            foreach ($datasoal as $ds) {
                                $rekaman = $rekaman . "(_#_)" . $ds->id . "(-)0";
                            }
                        }
                        $validated['rekaman'] = $rekaman;
                    $validated['status'] = "1";
                    $validated['user_id'] = auth()->user()->id;                
                    if($cekpengerjaan){
                        // echo "sudah ada pengerjaan";
                        return redirect(url('pengerjaan/'.$cekpengerjaan->id));
                    } else {
                        Pengerjaan::create($validated);
                        // echo "belum ada pengerjaan";
                        $cekpengerjaan = Pengerjaan::where('penjadwalan_id', $penjadwalan->id)->where('user_id', auth()->user()->id)->first();
                        return redirect(url('pengerjaan/'.$cekpengerjaan->id));
    
                    }
                }
            }
        } else {
            $anggotarombels = Anggotakelompok::where('kelompok_id', $penjadwalan->kelompok_id);
            if (request('search')) {
                $anggotarombels->whereRelation('user','name', 'like', '%'. request('search').'%' );
            }
            return view('administrator.detailjadwal', [
                'menu' => 'pelaksanaan',
                'smenu' => 'penjadwalan',
                'penjadwalan' => $penjadwalan,
                'anggotarombels' => $anggotarombels->paginate(10)->withQueryString()
                ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjadwalan $penjadwalan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjadwalan $penjadwalan)
    {
        if($penjadwalan->token == $request->token){
            $validated['penjadwalan_id'] = $penjadwalan->id;
            if($penjadwalan->acaksoal == '1'){
                $datasoal = Soal::where('banksoal_id', $penjadwalan->banksoal_id)
                ->orderBy('jenissoal_id', 'asc')
                ->inRandomOrder()->get();
            } else {
                $datasoal = Soal::where('banksoal_id', $penjadwalan->banksoal_id)
                ->get();
            }
            if($datasoal->count() != 0){
                $rekaman = "";
                foreach ($datasoal as $ds) {
                    $rekaman = $rekaman . "(_#_)" . $ds->id . "(-)0";
                }
            }
            $validated['rekaman'] = $rekaman;
            $validated['status'] = "1";
            $validated['user_id'] = auth()->user()->id;
            $cekpengerjaan = Pengerjaan::where('penjadwalan_id', $penjadwalan->id)->where('user_id', auth()->user()->id)->first();
            if(!$cekpengerjaan){
                Pengerjaan::create($validated);
                $cekpengerjaan = Pengerjaan::where('penjadwalan_id', $penjadwalan->id)->where('user_id', auth()->user()->id)->first();
            }
            session(['pengerjaan' => $cekpengerjaan->id]);
            return redirect(url('pengerjaan/'.$cekpengerjaan->id));
        } else {
            return redirect()->back()->with('failed', 'Token Salah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjadwalan $penjadwalan)
    {
        //
    }
}
