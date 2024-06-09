@extends('layouts.main')

@section('content')


<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Daftar Jadwal</h3>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                    <a href="#" class="btn icon icon-left btn-primary" data-toggle="modal" data-target="#tambah-jadwal"><i data-feather="plus"></i> Tambah Jadwal</a>
                    <!--BorderLess Modal Modal -->
                    <div class="modal fade text-left modal-borderless" id="tambah-jadwal" tabindex="-1" role="dialog" aria-labelledby="modalTambah" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-full" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Jadwal</h5>
                                    <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form action="{{ url('/') }}/penjadwalan" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">Judul Tugas</label>
                                                    <input type="text" class="form-control" placeholder="Judul Tugas" name="judultugas" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="last-name-column">Deskripsi Tugas</label>
                                                    <textarea class="deskripsi" placeholder="Deskripsi Tugas"
                                                        name="deskripsitugas"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="last-name-column">Tugaskan Untuk Semua Tingkat<sub> (Abaikan jika penjadwalan sebagian)</sub> </label>
                                                    <select name="tingkat" class="choices form-select">
                                                        <option value="">Pilih Tingkat</option>
                                                        <option value="10">Tingkat 10</option>
                                                        <option value="11">Tingkat 11</option>
                                                        <option value="12">Tingkat 12</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="last-name-column">Tugaskan Untuk Ruang dan Kelas<sub> (Boleh pilih lebih dari satu)</sub> </label>
                                                    <select name="kelompok_id[]" class="choices form-select" multiple="multiple">
                                                        <option value="">Pilih Ruang dan Kelas</option>
                                                        @foreach($kelompoks as $kelompok)
                                                        <option value="{{ $kelompok->id }}">{{ $kelompok->ruangan->ruangan." - ".$kelompok->rombonganbelajar->rombongan_belajar }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="last-name-column">Pilih Soal</label>
                                                    <select name="banksoal_id" class="choices form-select">
                                                        <option value="">Pilih Soal</option>
                                                        @foreach($banksoals as $banksoal)
                                                        <option value="{{ $banksoal->id }}">{{ $banksoal->kodesoal." | ".$banksoal->matapelajaran->matapelajaran }} ({{  App\Models\Soal::where('banksoal_id', $banksoal->id)->count() }} soal)</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <div class='form-check'>
                                                    <div class="checkbox">
                                                        <label for="checkbox5">Acak Soal</label>
                                                        <input type="checkbox" name="acaksoal" class='form-check-input' value="1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <div class='form-check'>
                                                    <div class="checkbox">
                                                        <label for="checkbox5">Acak Jawaban</label>
                                                        <input type="checkbox" name="acakjawaban" class='form-check-input' value="1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="city-column">Durasi <sub>(kosongkan untuk menonaktifkan)</sub></label>
                                                    <input type="time" class="form-control" placeholder="Kosongkan untuk mematikan waktu" name="durasi">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="country-floating">Tanggal Mulai</label>
                                                    <div class="input-group">
                                                    <input type="date" class="form-control" name="tanggalmulai" placeholder="Tanggal Mulai">
                                                    <input type="time" class="form-control" name="waktumulai" placeholder="Waktu Mulai">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="company-column">Tanggal Penutupan</label>
                                                    <div class="input-group">
                                                        <input type="date" class="form-control" name="tanggalselesai" placeholder="Tanggal Penutupan">
                                                        <input type="time" class="form-control" name="waktuselesai" placeholder="Waktu Penutupan">
                                                    </div>
                                                       
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <div class='form-check'>
                                                    <div class="checkbox">
                                                        <label for="checkbox5">Aktifkan Token</label>
                                                        <input type="checkbox" name="token" class='form-check-input' value="1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <div class='form-check'>
                                                    <div class="checkbox">
                                                        <label for="checkbox5">Ijinkan Terlambat</label>
                                                        <input type="checkbox" name="terlambat" class='form-check-input' value="1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                <script type="text/javascript">                                    
                                    $(document).ready(function() {
                                        $('.deskripsi').summernote({
                                            placeholder: 'Tuliskan Deskripsi',
                                            tabsize: 1,
                                            height: 100
                                        });
                                    });
                                </script>
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
                                            <select class="choices form-select" onchange="this.form.submit()" name="kelompok_id">
                                                <option value="">Filter Rombongan Belajar</option>
                                                @foreach ($kelompoks as $kelompok)
                                                <option value="{{ $kelompok->id }}" {{ (request('kelompok_id') == $kelompok->id ? 'selected' : false) }}>{{ $kelompok->ruangan->ruangan." | ".$kelompok->rombonganbelajar->rombongan_belajar }}</option>
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
                            <th>Kode Soal</th>
                            <th>Mata Pelajaran</th>
                            <th>Ruang</th>
                            <th>Kelas</th>
                            <th>Durasi</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                            <th>Token</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjadwalans as $penjadwalan)
                        <tr>
                            <td>{{ $penjadwalans->firstItem() + $loop->index }}</td>
                            <td>{{ $penjadwalan->banksoal->kodesoal }}</td>
                            <td>{{ $penjadwalan->banksoal->matapelajaran->matapelajaran }}</td>
                            <td>{{ $penjadwalan->kelompok->ruangan->ruangan }}</td>
                            <td>{{ $penjadwalan->kelompok->rombonganbelajar->rombongan_belajar }}</td>
                            <td>{{ $penjadwalan->durasi }}</td>
                            <td>{{ $penjadwalan->waktumulai }}</td>
                            <td>{{ $penjadwalan->waktuselesai }}</td>
                            <td>{{ $penjadwalan->token }}</td>
                            <td>
                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                    <a href="{{ url('/') }}/penjadwalan/{{ $penjadwalan->id }}" class="badge icon bg-success"><i data-feather="list"></i></a>
                                    <a href="{{ url('/') }}/penjadwalan/{{ $penjadwalan->id }}/edit" class="badge icon bg-warning"><i data-feather="edit"></i></a>
                                    <form action="{{ url('/') }}/penjadwalan/{{ $penjadwalan->id }}" method="post">
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
                        {{ $penjadwalans->links() }}
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection