<?php

namespace App\Http\Controllers;


use App\Models\Penjadwalan;
use App\Models\Pengerjaan;
use App\Models\Anggotakelompok;
use App\Models\Jawabanuraian;
use App\Models\Soal;
use App\Models\Kelompok;
use App\Models\Rombonganbelajar;
use App\Models\Matapelajaran;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    public function index()
    {
        $rombels = Rombonganbelajar::all();
        $mapels = Matapelajaran::all();
        $anggotarombels = Anggotakelompok::whereRelation('kelompok','rombonganbelajar_id', request('rombel_id'));            
        $penjadwalans = "";
        if (request('rombel_id') and request('mapel_id')) {
            $penjadwalans = Penjadwalan::whereRelation('banksoal','matapelajaran_id', request('mapel_id'))
                            ->whereRelation('kelompok','rombonganbelajar_id', request('rombel_id'))->get();
        }

        return view('guru.detailpengerjaan', [
            'menu' => 'dashboard',
            'rombels' => $rombels,
            'mapels' => $mapels,
            'anggotarombels' => $anggotarombels->paginate(40)->withQueryString(),
            'penjadwalans' => $penjadwalans
        ]);
    }

    public function detail()
    {
        $pengerjaan = Pengerjaan::where('id', request('pengerjaan_id'))->first();
        $rombel_id = Anggotakelompok::where('user_id', $pengerjaan->user_id)->first()->kelompok->rombonganbelajar_id;
        $mapel_id = $pengerjaan->penjadwalan->banksoal->matapelajaran_id;
            return view('guru.detailkuis', [
                'menu' => 'pembelaksanaan',
                'smenu' => 'penjadwalan',
                'pengerjaan' => $pengerjaan,
                'rombel_id' => $rombel_id,
                'mapel_id' => $mapel_id,
                'penjadwalan' => Penjadwalan::where('id', $pengerjaan->penjadwalan_id)->first()
                ]);
    }

    public function simpan(Request $request)
    {
        $pengerjaan = Pengerjaan::where('id', $request->pengerjaan_id)->first();
        $betul = 0;
        $rekaman = $pengerjaan->rekaman;
        $rt = explode("(_#_)", $rekaman);
        $jml_pg = 0;
        for ($i = 1; $i < count($rt); $i++) {
            $hasil = explode("(-)", $rt[$i]);
            $soal = Soal::where('id', $hasil[0])->first();
            if($soal->jenissoal_id == 1){
                $jml_pg++;
                $kunci = $soal->kunci;
                if ($kunci == $hasil[1]) {
                    $betul++;
                }
            } else {
                $pengerjaanlama = Pengerjaan::where('id', $request->pengerjaan_id)->first();
                $rekaman_lama = $pengerjaanlama->rekaman;
                $rl = explode("(_#_)", $rekaman_lama);
                $new_ans = array(
                    $i => $hasil[0] . '(-)' . $request->{'bobot'.$hasil[0]}
                );
                $update = array_replace($rl, $new_ans);
                $rek = "";
                for ($j = 1; $j < count($update); $j++) {
                    $rek = $rek . "(_#_)" . $update[$j];
                }
                $data_ans = array(
                    'rekaman' => $rek
                );
                Pengerjaan::where('id',$request->pengerjaan_id)
                        ->update($data_ans);
            }
        }
        $bobot = 0;
        $poin = 0;
        $jawabans = Jawabanuraian::where('pengerjaan_id', $request->pengerjaan_id)->get();
        foreach($jawabans as $jawaban){
            $data = array(
                'bobot' => $request->{'bobot'.$jawaban->soal_id},
                'poin' => $request->{'nilai'.$jawaban->soal_id},
            );
            Jawabanuraian::where('soal_id', $jawaban->soal_id)
                ->where('pengerjaan_id', $request->pengerjaan_id)
                ->update($data);
            $bobot = $bobot+$request->{'bobot'.$jawaban->soal_id};
            $poin = $poin+$request->{'nilai'.$jawaban->soal_id};
        }
        $total_bobot = $jml_pg+$bobot;
        $total_poin = $betul+$poin;
        $nilai = $total_poin / $total_bobot * 100;
        $data_akhir = array(
            'nilai' => $nilai,
            'pemeriksa_id' => auth()->user()->id
        );
        Pengerjaan::where('id',$request->pengerjaan_id)
            ->update($data_akhir);            
            return redirect()->back()->with('success', 'Data Berhasil disimpan');
    }
}
