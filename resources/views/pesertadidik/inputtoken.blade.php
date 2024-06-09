@extends('layouts.main')

@section('content')


<div class="main-content container-fluid">
    <!-- list group with contextual & horizontal start -->
    <section id="list-group-contextual">
        <div class="row match-height">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                            @if (session('failed'))
                            <div class="alert alert-light-danger color-warning">{{ session('failed') }}</div>
                            @endif
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="card border border-light">
                                <div class="card-header">
                                    <h1 class="card-title pl-1">Konfirmasi Ujian</h1>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form" method="post" action="{{ url('penjadwalan/'.$penjadwalan->id) }}">
                                            @method('put')
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="panel-body">
                                                        <table width="100%" cellpadding="2" cellspasing="2">
                                                            <tr>
                                                                <td>Mata Pelajaran</td>
                                                                <td>:</td>
                                                                <td><?= $penjadwalan->banksoal->matapelajaran->matapelajaran ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Durasi</td>
                                                                <td>:</td>
                                                                <td><?= $penjadwalan->durasi ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Token</td>
                                                                <td>:</td>
                                                                <td>
                                                                    <input type="text" name="token" autofocus required size="8">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                </div>
                                                <div class="col-12 d-flex mt-3">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Mulai</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>                           
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection