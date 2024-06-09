@extends('layouts.main')

@section('content')

<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Daftar Pengguna</h3>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="#" class="btn icon icon-left btn-primary" data-toggle="modal" data-target="#tambah-pengguna"><i data-feather="plus"></i> Tambah Pengguna</a>
                <!--BorderLess Modal Modal -->
                    <div class="modal fade text-left modal-borderless" id="tambah-pengguna" tabindex="-1" role="dialog" aria-labelledby="modalTambah" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Pengguna</h5>
                                    <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form action="{{ url('/') }}/users" method="post">
                                    @csrf
                                <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">Name</label>
                                                    <input type="text" id="first-name-column" class="form-control @error('name') is-invalid @enderror"  name="name">
                                                </div>
                                                @error('name') 
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="username-column">Nama Pengguna</label>
                                                    <input type="text" id="username-column" class="form-control @error('username') is-invalid @enderror" name="username">
                                                </div>
                                                @error('username') 
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="country-floating">Kata Sandi</label>
                                                    <input type="password" id="country-floating" class="form-control @error('password') is-invalid @enderror" name="password">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="country-floating">Konfirmasi Kata Sandi</label>
                                                    <input type="password" id="country-floating" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="country-floating">Jenis Pengguna</label>
                                                    <select class="form-control @error('role_id') is-invalid @enderror" name="role_id">
                                                        <option value="">Pilih Jenis Pengguna</option>
                                                        @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->role }}</option>
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
                <a href="#" class="btn icon icon-left btn-success float-right" data-toggle="modal" data-target="#import-pengguna"><i data-feather="upload"></i> Import Pengguna</a>
                <div class="modal fade text-left modal-borderless" id="import-pengguna" tabindex="-1" role="dialog" aria-labelledby="modalimport" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Import Pengguna</h5>
                                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                                </button>
                            </div>
                            <form action="{{ url('/') }}/users/import" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">File</label>
                                                <input type="file" id="first-name-column" class="form-control"  name="excel_file">
                                            </div>
                                            <a href="assets/file/format_user.xlsx">Download Format</a>
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
                                            <select class="form-control" onchange="this.form.submit()" name="role_id">
                                                <option value="">Filter Pengguna</option>
                                                @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ (request('role_id') == $role->id ? 'selected' : false) }}>{{ $role->role }}</option>
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
                            <th>Name</th>
                            <th>Nama Pengguna</th>
                            <th>Jenis Pengguna</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->role->role }}</td>
                            <td>
                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                    <a href="{{ url('/') }}/users/{{ $user->id }}/edit" class="badge icon bg-warning"><i data-feather="edit"></i></a>
                                    <form action="{{ url('/') }}/users/{{ $user->id }}" method="post">
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
                        {{ $users->links() }}
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection