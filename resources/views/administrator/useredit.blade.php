@extends('layouts.main')

@section('content')

<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Edit Pengguna</h3>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                Ubah data pengguna
            </div>
            <div class="card-body">
                <form action="{{ url('/') }}/users/{{ $user->id }}" method="post">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="first-name-column">Name</label>
                                <input type="text" id="first-name-column" class="form-control @error('name') is-invalid @enderror"  name="name" value="{{ $user->name }}">
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
                                <input type="text" id="username-column" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}">
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
                                    <option value="{{ $role->id }}" {{ ($user->role_id === $role->id ? 'selected' : false) }}>{{ $role->role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <input type="submit" class="btn btn-primary ml-1" value="Simpan">
                        </div>
                    </diV>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection