@extends('layouts.main')

@section('content')


<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Daftar Jadwal</h3>
    </div>
    <section class="section">
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
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Waktu Mulai</th>
                            <th>Token</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjadwalans as $penjadwalan)
                        <tr>
                            <td>{{ $penjadwalans->firstItem() + $loop->index }}</td>
                            <td>{{ $penjadwalan->banksoal->matapelajaran->matapelajaran }}</td>
                            <td>{{ $penjadwalan->kelompok->rombonganbelajar->rombongan_belajar }}</td>
                            <td>{{ $penjadwalan->waktumulai }}</td>
                            <td>{{ $penjadwalan->token }}</td>
                            <td>
                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                    <a href="{{ url('/') }}/penjadwalan/{{ $penjadwalan->id }}" class="badge icon bg-success"><i data-feather="list"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                  <div class="row mt-3">
                    <div class="col-md-12 col-12">
                        {{ $penjadwalans->links() }}
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection