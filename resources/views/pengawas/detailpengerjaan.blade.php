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
                                <h1 class="card-title pl-1">
                                    Daftar Tugas Peserta Didik                                
                                    <hr>
                                </h1>
                                    Judul Tugas : {{ $penjadwalan->judultugas }}
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
                                        <form>
                                            <div class="row justify-content-end">
                                                    <div class="col-md-9 col-9">
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <button class="btn btn-sm btn-outline-dark">
                                                                Token : {{ ($penjadwalan->token == NULL) ? 'Tidak Aktif' : $penjadwalan->token }}
                                                            </button>
                                                            <a href="{{ url('pengawasanshow?act=release&id_tugas='.$penjadwalan->id) }}" class="btn btn-sm btn-warning">
                                                                <i data-feather="refresh-cw"></i>
                                                            </a>
                                                            <a href="{{ url('pengawasanshow?act=hapus&id_tugas='.$penjadwalan->id) }}" class="btn btn-sm btn-danger">
                                                                <i data-feather="trash"></i>
                                                            </a> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control"  name="search" placeholder="Cari" value="{{ request('search') }}">
                                                        </div>
                                                    </div>
                                            </div>
                                        </form>
                                      <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Peserta Didik</th>
                                                <th>Status Pengerjaan</th>
                                                <th>Meninggalkan Halaman</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($anggotarombels as $anggotarombel)
                                            <tr>
                                                <td class="align-top">{{ $anggotarombels->firstItem() + $loop->index }}</td>
                                                <td>{{ $anggotarombel->user->name }}</td>
                                                <td>
                                                    @php
                                                    $pengerjaan = App\Models\Pengerjaan::where('user_id', $anggotarombel->user->id)->where('penjadwalan_id', $penjadwalan->id)->first();
                                                    if($pengerjaan){
                                                        if ($pengerjaan->status == '1'){
                                                            echo "<span class='badge bg-primary'>Sedang Dikerjakan</span>";
                                                        } else if ($pengerjaan->status == '2'){
                                                            echo "<span class='badge bg-success'>Selesai</span>";
                                                        } else if ($pengerjaan->status == '3'){
                                                            echo "<span class='badge bg-danger'>Diblokir</span>";
                                                            }
                                                        $minimize_count = $pengerjaan->minimize_count;
                                                    } else {
                                                        $minimize_count = 0;
                                                        echo "<span class='badge bg-warning'>Belum Mengerjakan</span>";
                                                    }
                                                    @endphp
                                                </td>
                                                <td>{{ $minimize_count }}</td>
                                                <td>
                                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                    @if($pengerjaan)
                                                        @if($pengerjaan->status == '2')
                                                        <a href="{{ url('/') }}/pengawasancreate?act=reset&pengerjaan_id={{ $pengerjaan->id }}" class="badge icon bg-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Pekerjaan Siswa"><i data-feather="rotate-ccw"></i></a>
                                                        @elseif($pengerjaan->status == '3')
                                                        <a href="{{ url('/') }}/pengawasancreate?act=blokir&pengerjaan_id={{ $pengerjaan->id }}" class="badge icon bg-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Buka Blokir Siswa"><i data-feather="check-circle"></i></a>
                                                        @elseif ($pengerjaan->status == '1')
                                                        <a href="{{ url('/') }}/pengawasancreate?act=selesai&pengerjaan_id={{ $pengerjaan->id }}" class="badge icon bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Submit Pekerjaan Siswa"><i data-feather="check-square"></i></a>
                                                        <a href="{{ url('/') }}/pengawasancreate?act=blokir&pengerjaan_id={{ $pengerjaan->id }}" class="badge icon bg-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Blokir Siswa"><i data-feather="slash"></i></a>
                                                        @endif
                                                        <script>
                                                            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                                                            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                                            return new bootstrap.Tooltip(tooltipTriggerEl)
                                                            })
                                                        </script>
                                                    @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                      </table>
                                      <div class="row mt-3">
                                        <div class="col-md-12 col-12">
                                            {{ $anggotarombels->links() }}
                                        </div>
                                      </div>
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