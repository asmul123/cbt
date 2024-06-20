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
                                <form>
                                    <div class="row justify-content-end">
                                            <div class="col-md-12 col-6">
                                                <div class="form-group">
                                                    <select class="choices form-select" name="rombel_id">
                                                        <option value="">Pilih Rombongan Belajar</option>
                                                        @foreach ($rombels as $rombel)
                                                        <option value="{{ $rombel->id }}" {{ (request('rombel_id') == $rombel->id ? 'selected' : false) }}>{{ $rombel->rombongan_belajar }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-6">
                                                <div class="form-group">
                                                    <select class="choices form-select" name="mapel_id">
                                                        <option value="">Pilih Mata Pelajaran</option>
                                                        @foreach ($mapels as $mapel)
                                                        <option value="{{ $mapel->id }}" {{ (request('mapel_id') == $mapel->id ? 'selected' : false) }}>{{ $mapel->matapelajaran }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                                </form>
                            </div>
                            @if($penjadwalans)
                            <div class="card-header">
                                <h1 class="card-title pl-1">
                                    Daftar Pengerjaan Peserta Didik                                
                                    <hr>
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
                                      <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Peserta Didik</th>
                                                <th>Status Pengerjaan</th>
                                                <th>Status Pemeriksaan</th>
                                                <th>Nilai</th>
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
                                                    $penj = 1;
                                                    foreach($penjadwalans as $penjadwalan){
                                                        ${'penjadwalan'.$penj} = $penjadwalan->id;
                                                        $penj++;
                                                    }
                                                        $pengerjaan = App\Models\Pengerjaan::where('user_id', $anggotarombel->user->id)->where('penjadwalan_id', $penjadwalan1)->orWhere('user_id', $anggotarombel->user->id)->where('penjadwalan_id', $penjadwalan2)->first();
                                                        if($pengerjaan){
                                                            if ($pengerjaan->status == '1'){
                                                                echo "<span class='badge bg-primary'>Sedang Dikerjakan</span>";
                                                            } else if ($pengerjaan->status == '2'){
                                                                echo "<span class='badge bg-success'>Selesai</span>";
                                                            } else if ($pengerjaan->status == '3'){
                                                                echo "<span class='badge bg-danger'>Diblokir</span>";
                                                                }
                                                        } else {
                                                            echo "<span class='badge bg-warning'>Belum Mengerjakan</span>";
                                                        }
                                                    @endphp
                                                </td>
                                                <td>
                                                    @if($pengerjaan->pemeriksa_id != 0)
                                                    <span class='badge bg-success'>Diperiksa oleh : {{ App\Models\User::where('id', $pengerjaan->pemeriksa_id)->first()->name }}</span>
                                                    @else
                                                    <span class='badge bg-warning'>Belum Diperiksa</span>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($pengerjaan->nilai,2) }}</td>
                                                <td><a href="{{ url('/') }}/pemeriksaan-detail?pengerjaan_id={{ $pengerjaan->id }}" class="badge icon bg-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Periksa Pekerjaan Siswa"><i data-feather="list"></i> Periksa</a></td>
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
                            @endif
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