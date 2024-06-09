@extends('layouts.main')

@section('content')

<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Edit Rombongan Belajar</h3>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                Ubah Rombongan Belajar
            </div>
            <div class="card-body">
                <form action="{{ url('/') }}/rombonganbelajar/{{ $rombel->id }}" method="post">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="first-name-column">Name</label>
                                <input type="text" id="first-name-column" class="form-control"  name="rombongan_belajar" value="{{ $rombel->rombongan_belajar }}">
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="country-floating">Tahun Pejaran</label>
                                <select class="form-control" name="tahunpelajaran_id">
                                    <option value="">Pilih Tahun Pelajaran</option>
                                    @foreach ($tapels as $tapel)
                                    <option value="{{ $tapel->id }}" {{ ($tapel->id == $rombel->tahunpelajaran_id ? 'selected' : false) }}>{{ $tapel->tahunpelajaran }}</option>
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