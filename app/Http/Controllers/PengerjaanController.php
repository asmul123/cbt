<?php

namespace App\Http\Controllers;

use App\Models\Pengerjaan;
use App\Models\Penjadwalan;
use App\Models\Anggotakelompok;
use App\Models\Soal;
use App\Models\Jawabanuraian;
use Illuminate\Http\Request;

class PengerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $now = date('Y-m-d H:i:s');
        $kelompok_id = Anggotakelompok::where('user_id',auth()->user()->id)->first()->kelompok_id;
        // dd($kelompok_id);
            return view('pesertadidik.daftarjadwal', [
                'menu' => 'dashboard',
                'penjadwalans' => Penjadwalan::where('kelompok_id', $kelompok_id)->where('waktumulai', '<=', $now)->orderBy('waktumulai', 'desc')->get()
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
        $pengerjaan = Pengerjaan::where('id',session('pengerjaan'))->first();
        if($pengerjaan->status == 3){
            echo "
            <script>
                alert(\"Anda telah di blokir dari pengerjaan quiz ini, silahkan hubungi pengawas/proktor anda!\")
            </script>
            ";
            session()->forget('pengerjaan');
            return redirect('/');
        }
        if($request->no == ""){
            $no = 1;
        } else {
            $no = $request->no;
        }
        if ($request->nosoal && $request->opsi && $request->soal){
            $jenissoal = Soal::where('id', $request->soal)->first()->jenissoal_id;
            $rekaman_lama = $pengerjaan->rekaman;
            $rl = explode("(_#_)", $rekaman_lama);
            if($jenissoal != 1){
                    $cekjawaban = Jawabanuraian::where('pengerjaan_id', session('pengerjaan'))
                                                ->where('soal_id', $request->soal)->first();
                    $datajawaban['jawaban'] = $request->opsi;
                    if($cekjawaban){
                        Jawabanuraian::where('pengerjaan_id', session('pengerjaan'))
                        ->where('soal_id', $request->soal)->update($datajawaban);
                    } else {
                        $datajawaban['pengerjaan_id'] = session('pengerjaan');
                        $datajawaban['soal_id'] = $request->soal;
                        Jawabanuraian::create($datajawaban);
                    }
                    $new_ans = array(
                        $request->nosoal => $request->soal . '(-)1'
                    );
                    $update = array_replace($rl, $new_ans);
            } else {
                $new_ans = array(
                    $request->nosoal => $request->soal . '(-)' . $request->opsi
                );
                $update = array_replace($rl, $new_ans);
            }
            $rek = "";
            for ($i = 1; $i < count($update); $i++) {
                $rek = $rek . "(_#_)" . $update[$i];
            }
            $data_ans = array(
                'rekaman' => $rek
            );
            Pengerjaan::where('id',$pengerjaan->id)
                    ->update($data_ans);
            $pengerjaan = Pengerjaan::where('id', $pengerjaan->id)->first();
        }
        if(session('pengerjaan') == $pengerjaan->id){
            if($request->no == "akhir"){
                // if($request->opsi){
                //     $rek = $rek;
                // } else {
                //     $rek = $pengerjaan->rekaman;
                // }
                // $betul = 0;
                // $rt = explode("(_#_)", $rek);
                // $jml_soal = count($rt) - 1;
                // for ($i = 1; $i < count($rt); $i++) {
                //     $hasil = explode("(-)", $rt[$i]);
                //     $kunci = Soal::where('id', $hasil[0])->first()->kunci;
                //     if ($kunci == $hasil[1]) {
                //         $betul++;
                //     }
                // }
                // $nilai = $betul / $jml_soal * 100;
                $nilai = 0;
                $data_akhir = array(
                    'nilai' => $nilai,
                    'status' => '2'
                );
                Pengerjaan::where('id',$pengerjaan->id)
                    ->update($data_akhir);
                session()->forget('pengerjaan');
                return redirect('/');
            }
            $penjadwalan = Penjadwalan::where('id', $pengerjaan->penjadwalan_id)->first();
            $dr = explode(":", $penjadwalan->durasi);
            $finish_at = new \DateTime($penjadwalan->waktuselesai);
            $datetime = new \DateTime($pengerjaan->created_at);
            $datetime->add(new \DateInterval('PT' . $dr[0] . 'H' . $dr[1] . 'M'));
            if ($finish_at < $datetime) {
                $waktuselesai = $finish_at;
            } else {
                $waktuselesai = $datetime;
            }
            return view('pesertadidik.pengerjaankuis', [
                'menu' => 'dashboard',
                'nosoal' => $no,
                'waktuselesai' => $waktuselesai,
                'pengerjaan' => $pengerjaan
            ]);
        } else if (session()->has('pengerjaan')){
            return redirect('pengerjaan/'.session('pengerjaan'));
        } else {
            // dd(session('pengerjaan'));
            return redirect()->back()->with('failed', 'Mohon Input token terlebihdahulu');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Pengerjaan $pengerjaan)
    {
        if($pengerjaan->status == 3){
            echo "
            <script>
                alert(\"Anda telah di blokir dari pengerjaan quiz ini, silahkan hubungi pengawas/proktor anda!\")
            </script>
            ";
            session()->forget('pengerjaan');
            return redirect('/');
        }
            if($request->no == ""){
                $no = 1;
            } else {
                $no = $request->no;
            }
            if ($request->nosoal && $request->opsi && $request->soal){
                $jenissoal = Soal::where('id', $request->soal)->first()->jenissoal_id;
                $rekaman_lama = $pengerjaan->rekaman;
                $rl = explode("(_#_)", $rekaman_lama);
                $new_ans = array(
                    $request->nosoal => $request->soal . '(-)' . $request->opsi
                );
                $update = array_replace($rl, $new_ans);
                $rek = "";
                for ($i = 1; $i < count($update); $i++) {
                    $rek = $rek . "(_#_)" . $update[$i];
                }
                $data_ans = array(
                    'rekaman' => $rek
                );
                Pengerjaan::where('id',$pengerjaan->id)
                        ->update($data_ans);
                $pengerjaan = Pengerjaan::where('id', $pengerjaan->id)->first();
            }
            if(session('pengerjaan') == $pengerjaan->id){
                if($request->no == "akhir"){
                    // if($request->opsi){
                    //     $rek = $rek;
                    // } else {
                    //     $rek = $pengerjaan->rekaman;
                    // }
                    // $betul = 0;
                    // $rt = explode("(_#_)", $rek);
                    // $jml_soal = count($rt) - 1;
                    // for ($i = 1; $i < count($rt); $i++) {
                    //     $hasil = explode("(-)", $rt[$i]);
                    //     $kunci = Soal::where('id', $hasil[0])->first()->kunci;
                    //     if ($kunci == $hasil[1]) {
                    //         $betul++;
                    //     }
                    // }
                    $nilai = 0;
                    // $nilai = $betul / $jml_soal * 100;
                    $data_akhir = array(
                        'nilai' => $nilai,
                        'status' => '2'
                    );
                    Pengerjaan::where('id',$pengerjaan->id)
                        ->update($data_akhir);
                    session()->forget('pengerjaan');
                    return redirect('/');
                }
                $penjadwalan = Penjadwalan::where('id', $pengerjaan->penjadwalan_id)->first();
			    $dr = explode(":", $penjadwalan->durasi);
                $finish_at = new \DateTime($penjadwalan->waktuselesai);
                $datetime = new \DateTime($pengerjaan->created_at);
                $datetime->add(new \DateInterval('PT' . $dr[0] . 'H' . $dr[1] . 'M'));
                if ($finish_at < $datetime) {
                    $waktuselesai = $finish_at;
                } else {
                    $waktuselesai = $datetime;
                }
                return view('pesertadidik.pengerjaankuis', [
                    'menu' => 'dashboard',
                    'nosoal' => $no,
                    'waktuselesai' => $waktuselesai,
                    'pengerjaan' => $pengerjaan
                ]);
            } else if (session()->has('pengerjaan')){
                return redirect('pengerjaan/'.session('pengerjaan'));
            } else {
                // dd(session('pengerjaan'));
                return redirect()->back()->with('failed', 'Mohon Input token terlebihdahulu');
            }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengerjaan $pengerjaan)
    {
        $mc = $pengerjaan->minimize_count+1;
        $data = array(
            'minimize_count' => $mc
        );
        Pengerjaan::where('id',$pengerjaan->id)
            ->update($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengerjaan $pengerjaan)
    {
        $data = array(
            'nilai' => $request->nilai
        );
        Pengerjaan::where('id',$pengerjaan->id)
            ->update($data);
        return redirect('/penugasan/create?act=detail&pengerjaan_id='.$pengerjaan->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengerjaan $pengerjaan)
    {
        //
    }
}
