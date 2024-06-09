@extends('layouts.main')

@section('content')


<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Daftar Kelompok</h3>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                    <a href="#" class="btn icon icon-left btn-primary" data-toggle="modal" data-target="#tambah-rombel"><i data-feather="plus"></i> Tambah Ruangan</a>
                    <!--BorderLess Modal Modal -->
                    <div class="modal fade text-left modal-borderless" id="tambah-rombel" tabindex="-1" role="dialog" aria-labelledby="modalTambah" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Kelompok</h5>
                                    <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form action="{{ url('/') }}/kelompok" method="post">
                                    @csrf
                                <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="country-floating">Rombongan Belajar</label>
                                                    <select class="form-control" name="rombonganbelajar_id">
                                                        <option value="">Pilih Rombongan Belajar</option>
                                                        @foreach ($rombels as $rombel)
                                                        <option value="{{ $rombel->id }}">{{ $rombel->rombongan_belajar }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="country-floating">Ruangan</label>
                                                    <select class="form-control" name="ruangan_id">
                                                        <option value="">Pilih Ruangan</option>
                                                        @foreach ($ruangans as $ruangan)
                                                        <option value="{{ $ruangan->id }}">{{ $ruangan->ruangan }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="country-floating">Tahun Pejaran</label>
                                                    <select class="form-control" name="tahunpelajaran_id">
                                                        <option value="">Pilih Tahun Pelajaran</option>
                                                        @foreach ($tapels as $tapel)
                                                        <option value="{{ $tapel->id }}" {{ ($tapel->is_active == 1 ? 'selected' : false) }}>{{ $tapel->tahunpelajaran }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </diV>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-primary" data-dismiss="modal">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Close</span>
                                        </button>
                                        <input type="submit" class="btn btn-primary ml-1" value="Simpan">
                                            <i class="bx bx-check d-block d-sm-none"></i>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <a href="#" class="btn icon icon-left btn-success float-right" data-toggle="modal" data-target="#import-rombel"><i data-feather="upload"></i> Import Kelompok</a><br>
                <div class="modal fade text-left modal-borderless" id="import-rombel" tabindex="-1" role="dialog" aria-labelledby="modalimport" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Import Kelompok</h5>
                                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                                </button>
                            </div>
                            <form action="{{ url('/') }}/kelompok/import" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">File</label>
                                                <input type="file" id="first-name-column" class="form-control"  name="excel_file">
                                            </div>
                                            <a href="{{ url('/') }}/kelompok/create">Download Format</a>
                                        </div>
                                    </diV>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-primary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <input type="submit" class="btn btn-primary ml-1" value="Simpan">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn icon icon-left btn-success float-right" data-toggle="modal" data-target="#import-anggota"><i data-feather="upload"></i> Import Anggota Kelompok</a>
                <div class="modal fade text-left modal-borderless" id="import-anggota" tabindex="-1" role="dialog" aria-labelledby="modalimport" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Import Anggota Kelompok</h5>
                                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                                </button>
                            </div>
                            <form action="{{ url('/') }}/kelompok/importanggota" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">File</label>
                                                <input type="file" id="first-name-column" class="form-control"  name="excel_file">
                                            </div>
                                            <a href="{{ url('/') }}/kelompok/format">Download Format</a>
                                        </div>
                                    </diV>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-primary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <input type="submit" class="btn btn-primary ml-1" value="Simpan">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
                                <div class="col-md-3 col-3">
                                    <div class="form-group">
                                            <select class="form-control" onchange="this.form.submit()" name="tapel_id">
                                                <option value="">Filter Tahun Pelajaran</option>
                                                @foreach ($tapels as $tapel)
                                                <option value="{{ $tapel->id }}" {{ (request('tapel_id') == $tapel->id ? 'selected' : false) }}>{{ $tapel->tahunpelajaran }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6"></div>
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
                            <th>Tahun Pelajaran</th>
                            <th>Nama Ruangan</th>
                            <th>Nama Rombongan Belajar</th>
                            <th>Jumlah Anggota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelompoks as $kelompok)
                        <tr>
                            <td>{{ $kelompoks->firstItem() + $loop->index }}</td>
                            <td>{{ $kelompok->tahunpelajaran->tahunpelajaran }}</td>
                            <td>{{ $kelompok->ruangan->ruangan }}</td>
                            <td>{{ $kelompok->rombonganbelajar->rombongan_belajar }}</td>
                            <td>{{  App\Models\Anggotakelompok::where('kelompok_id', $kelompok->id)->count() }}</td>
                            <td>
                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                    <a href="{{ url('/') }}/kelompok/{{ $kelompok->id }}" class="badge icon bg-success"><i data-feather="list"></i></a>
                                    <a href="{{ url('/') }}/kelompok/{{ $kelompok->id }}/edit" class="badge icon bg-warning"><i data-feather="edit"></i></a>
                                    <form action="{{ url('/') }}/kelompok/{{ $kelompok->id }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button class="badge icon bg-danger border-0" onclick="return confirm('Yakin akan menghapus user ini?')"><i data-feather="trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                  <div class="row mt-3">
                    <div class="col-md-12 col-12">
                        {{ $kelompoks->links() }}
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection