@extends('layouts.main')

@section('content')


<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Dashboard</h3>
        <p class="text-subtitle text-muted">Rekapitulasi Aplikasi</p>
    </div>
    <section id="card-caps">
        <div class="row">
            <div class="col-xl-3 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <img class="card-img img-fluid" src="{{ url('assets/images/background/auth.jpg') }}" alt="Card image">
                        <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
                            <div class="overlay-content">
                                <h4 class="card-title mb-50">{{ $jumlahsiswa }}</h4>
                                <p class="card-text text-ellipsis">
                                    Peserta didik aktif
                                </p>
                            </div>
                            <div class="overlay-status">
                                <a href="#" class="btn btn-outline-white btn-sm">Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <img class="card-img img-fluid" src="{{ url('assets/images/background/auth.jpg') }}" alt="Card image">
                        <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
                            <div class="overlay-content">
                                <h4 class="card-title mb-50">{{ $jumlahguru }}</h4>
                                <p class="card-text text-ellipsis">
                                    Tenaga pendidik
                                </p>
                            </div>
                            <div class="overlay-status">
                                <a href="#" class="btn btn-outline-white btn-sm">Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <img class="card-img img-fluid" src="{{ url('assets/images/background/auth.jpg') }}" alt="Card image">
                        <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
                            <div class="overlay-content">
                                <h4 class="card-title mb-50">{{ $jumlahtu }}</h4>
                                <p class="card-text text-ellipsis">
                                    Tenaga Kependidikan
                                </p>
                            </div>
                            <div class="overlay-status">
                                <a href="#" class="btn btn-outline-white btn-sm">Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <img class="card-img img-fluid" src="{{ url('assets/images/background/auth.jpg') }}" alt="Card image">
                        <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
                            <div class="overlay-content">
                                <h4 class="card-title mb-50">{{ $jumlahrombel }}</h4>
                                <p class="card-text text-ellipsis">
                                    Rombongan Belajar
                                </p>
                            </div>
                            <div class="overlay-status">
                                <a href="#" class="btn btn-outline-white btn-sm">Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <img class="card-img img-fluid" src="{{ url('assets/images/background/auth.jpg') }}" alt="Card image">
                        <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
                            <div class="overlay-content">
                                <h4 class="card-title mb-50">{{ $jumlahkepsek }}</h4>
                                <p class="card-text text-ellipsis">
                                    Kepala Sekolah
                                </p>
                            </div>
                            <div class="overlay-status">
                                <a href="#" class="btn btn-outline-white btn-sm">Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <img class="card-img img-fluid" src="{{ url('assets/images/background/auth.jpg') }}" alt="Card image">
                        <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
                            <div class="overlay-content">
                                <h4 class="card-title mb-50">{{ $jumlahkuri }}</h4>
                                <p class="card-text text-ellipsis">
                                    Waka Kurikulum
                                </p>
                            </div>
                            <div class="overlay-status">
                                <a href="#" class="btn btn-outline-white btn-sm">Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <img class="card-img img-fluid" src="{{ url('assets/images/background/auth.jpg') }}" alt="Card image">
                        <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
                            <div class="overlay-content">
                                <h4 class="card-title mb-50">{{ $jumlahkaprog }}</h4>
                                <p class="card-text text-ellipsis">
                                    Kaprodi
                                </p>
                            </div>
                            <div class="overlay-status">
                                <a href="#" class="btn btn-outline-white btn-sm">Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <img class="card-img img-fluid" src="{{ url('assets/images/background/auth.jpg') }}" alt="Card image">
                        <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
                            <div class="overlay-content">
                                <h4 class="card-title mb-50">{{ $jumlahwali }}</h4>
                                <p class="card-text text-ellipsis">
                                    Wali Kelas
                                </p>
                            </div>
                            <div class="overlay-status">
                                <a href="#" class="btn btn-outline-white btn-sm">Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

    
@endsection