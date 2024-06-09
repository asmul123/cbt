@extends('layouts.main')

@section('content')


<div class="main-content container-fluid">
    <!-- list group with contextual & horizontal start -->
    <section id="list-group-contextual">
        <div class="row match-height">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="card-header">                           
                                @if (session('success'))
                                <div class="alert alert-light-success color-warning">{{ session('success') }}</div>
                                @endif
                                
                                @if (session('failed'))
                                <div class="alert alert-light-danger color-warning">{{ session('failed') }}</div>
                                @endif
                                <h1 class="card-title pl-1">Daftar Jadwal</h1>
                                @if ($penjadwalans->count()==0)
                                    <p class="card-text text-ellipsis">
                                        Belum ada jadwal saat ini !
                                    </p>
                                @endif
                            </div>
                            @foreach($penjadwalans as $penjadwalan)
                            <div class="card border border-light">
                                <div class="card-header">
                                    <span class="collapsed collapse-title">Tanggal Penjadwalan : {{ $penjadwalan->waktumulai }}</span>
                                    <br>
                                    <sup>Oleh : {{ $penjadwalan->user->name }}</sup>
                                </div>
                                <div class="card-body">
                                    <div class="card border border-light">
                                            <div class="card-header">
                                                <h3>{{ $penjadwalan->judultugas }}</h3>
                                                <sup>Jatuh Tempo pada : {{ $penjadwalan->waktuselesai }}</sup><br>
                                                @php
                                                $pengerjaan = App\Models\Pengerjaan::where('user_id', auth()->user()->id)->where('penjadwalan_id', $penjadwalan->id)->first();
                                                    if($pengerjaan){
                                                        if ($pengerjaan->status == '1'){
                                                            echo "<span class='badge bg-primary'>Status Pengerjaan : Sedang Dikerjakan</span>";
                                                        } else if ($pengerjaan->status == '2'){
                                                            echo "<span class='badge bg-success'>Status Pengerjaan : Selesai</span>";
                                                        } else if ($pengerjaan->status == '3'){
                                                            echo "<span class='badge bg-danger'>Status Pengerjaan : Diblokir</span>";
                                                        }
                                                    } else if($penjadwalan->waktuselesai < date('Y-m-d H:i:s')){
                                                        echo "<span class='badge bg-danger'>Status Pengerjaan : Tugas Ditutup</span>";
                                                    } else {
                                                        echo "<span class='badge bg-warning'>Status Pengerjaan : Belum Mengerjakan</span>";
                                                    }
                                                @endphp                                                
                                            </div>
                                            <div class="card-body">
                                                <a href="{{ url('/penjadwalan/'.$penjadwalan->id) }}" class="btn btn-outline-primary">Lihat Tugas</a>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                
            </div>
        </div>
    </section>
@endsection