@extends('layouts.main')

@section('content')


<div class="main-content container-fluid">
    <!-- list group with contextual & horizontal start -->
    <section id="list-group-contextual">
        <div class="row match-height">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">                           
                            @if (session('success'))
                            <div class="alert alert-light-success color-warning">{{ session('success') }}</div>
                            @endif
                            
                            @if (session('failed'))
                            <div class="alert alert-light-danger color-warning">{{ session('failed') }}</div>
                            @endif
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="card-header">
                                <h1 class="card-title pl-1">
                                    Daftar Pekerjaan
                                </h1>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    @if (session('success'))
                                    <div class="alert alert-light-success color-warning">{{ session('success') }}</div>
                                    @endif
                                    
                                    @if (session('failed'))
                                    <div class="alert alert-light-danger color-warning">{{ session('failed') }}</div>
                                    @endif
                                    <div class="table-responsive">
                                        <form action="{{ url('pengerjaan/'.$pengerjaan->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                        <table class="table table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Soal</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $betul = 0;
                                                $rt = explode("(_#_)", $pengerjaan->rekaman);
                                                $jml_soal = count($rt) - 1;
                                                for ($i = 1; $i < count($rt); $i++) {
                                                    $ia = explode('(-)', $rt[$i]);
                                                    $jmluraian = count($ia);
                                                    $soal = App\Models\Soal::where('id', $ia[0])->first();
                                                    $jw = explode('[#_#]', $soal->jawaban);
                                                    @endphp
                                                    <tr>
                                                        <td class="align-top">{{ $i }}</td>
                                                        <td>
                                                            Soal :<br>
                                                    {!! $soal->soal !!}<hr>                                                    
                                                    <ol type="A">
                                                        @php
                                                        $op = explode("[#_#]", $soal->jawaban);                                                        
                                                        $jmlop = count($op);
                                                        for ($j = 0; $j < $jmlop; $j++) {
                                                            if($op[$j]!=""){
                                                                $isiop = explode("[_#_]", $op[$j]);
                                                                echo "<li>" . $isiop[1];
                                                                echo "</li>";
                                                            }
                                                        }
                                                        if($ia[1]==0){
                                                            $jawaban = "Tidak Menjawab";
                                                        } else {
                                                            $jawaban = $ia[1];
                                                        }
                                                        @endphp
                                                    </ol>
                                                    @if($soal->jenissoal_id != 1)
                                                        @php
                                                        $cekjawaban = App\Models\Jawabanuraian::where('pengerjaan_id', $pengerjaan->id)->where('soal_id', $ia[0])->first();
                                                        if($cekjawaban){
                                                            $jawaban = $cekjawaban->jawaban;
                                                        } else {
                                                            $jawaban = "Tidak Menjawab";
                                                        }
                                                        @endphp
                                                    @endif
                                                    Jawaban : {!! $jawaban !!}<br>
                                                    {{ 'Kunci : '.$soal->kunci }}
                                                </td>
                                                <td>
                                                    @if($soal->jenissoal_id != 1)
                                                    Bobot Nilai : <input type="text" class="form-control" name="bobot{{ $ia[0] }}" size="8">
                                                    @else                                                    
                                                    @php
                                                    if ($soal->kunci == $ia[1]) {
                                                        $betul++;
                                                        echo "<button class='badge icon bg-success border-0'>Jawaban Benar</button>";
                                                    } else {
                                                        echo "<button class='badge icon bg-danger border-0'>Jawaban Salah</button>";
                                                    }
                                                    @endphp
                                                    @endif                                               
                                                </td>
                                            </tr>
                                            @php
                                                }
                                            @endphp
                                            <tr>
                                                <td colspan="3">
                                                        @method('put')
                                                    Jumlah Benar : {{ $betul }}<br>
                                                    Nilai Saat ini : {{ number_format($pengerjaan->nilai,2) }}<br>
                                                    Ubah Nilai : <input type="text" class="form-control" name="nilai" autofocus required size="8">
                                                    <button type="submit" class="badge bg-primary border-0">Simpan</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                
            </div>
        </div>
    </section>
    <!-- list group with contextual & horizontal ends -->

@endsection