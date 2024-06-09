@extends('layouts.main')

@section('content')


<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Akun</h3>
        <p class="text-subtitle text-muted">Edit Akun</p>
    </div>
    <section class="section">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Akun Saya</h4>
                </div>
                
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-light-success color-warning">{{ session('success') }}</div>
                    @endif
                    @if (session('failed'))
                    <div class="alert alert-light-danger color-warning">{{ session('failed') }}</div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-light-danger color-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ url('/') }}/akun" method="post">
                        @csrf
                    <div class="row">                        
                        <div class="col-md-12">
                            
                            <div class="form-group">
                                <label for="basicInput">Kata Sandi Saat ini</label>
                                <input type="password" name="current_password" class="form-control" id="basicInput" placeholder="Kata sandi saat ini">
                            </div>
                            <div class="form-group">
                                <label for="basicInput">Kata Sandi Baru</label>
                                <input type="password" name="password" class="form-control" id="basicInput" placeholder="Kata Sandi Baru">
                            </div>
                            <div class="form-group">
                                <label for="basicInput">Konfirmasi Kata Sandi</label>
                                <input type="password" name="password_confirmation" class="form-control" id="basicInput" placeholder="Konfirmasi Kata Sandi Baru">
                            </div>
                        </div>
                        <div class="clearfix">
                            <button class="btn btn-primary float-right">Simpan</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </section>
</div>

    
@endsection