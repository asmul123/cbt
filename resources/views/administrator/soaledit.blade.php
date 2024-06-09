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
            <form action="{{ url('/soal/'.$soal->id) }}" method="post">                
            @method('put')
                                                        @csrf
                                                    <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12 col-12">
                                                                    <div class="card collapse-icon accordion-icon-rotate">
                                                                        <div class="card-header">                                                                            
                                                                            <div class="form-group">
                                                                                <label for="first-name-column">Soal</label>
                                                                                <textarea class="soal" name="soal" class="form-control">{{ $soal->soal }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        @if($soal->jenissoal_id != '3')
                                                                        <div class="card-content">
                                                                            <div class="card-body">
                                                                                @if($soal->jenissoal_id == '1')
                                                                                <div class="accordion" id="cardAccordion">
                                                                                    @php
                                                                                        $op = explode("[#_#]", $soal->jawaban);
                                                                                        $jmlop = count($op)-1;
                                                                                        $abj = "A";
                                                                                        for ($i = 0; $i < 5; $i++) {
                                                                                    @endphp
                                                                                    <div class="card">
                                                                                        <div class="card-header" id="heading{{ $abj }}" data-toggle="collapse" data-target="#collapse{{ $abj }}"
                                                                                            aria-expanded="false" aria-controls="collapse{{ $abj }}" role="button">
                                                                                                    <span class="collapsed collapse-title">
                                                                                                        <div class="row  justify-content-end">
                                                                                                            <div class="col-lg-10">Pilihan {{ $abj }}</div>
                                                                                                            <div class="col-lg-2">
                                                                                                                <label>
                                                                                                                    Jadikan Kunci :
                                                                                                                </label>
                                                                                                                <input class="form-check-input" type="radio" name="kunci" value="{{ $abj }}" {{ ($abj == $soal->kunci ? 'checked' : false) }}> 
                                                                                                            </div>
                                                                                                        </div>
                                                                                        </div>
                                                                                        <div id="collapse{{ $abj }}" class="collapse pt-1" aria-labelledby="heading{{ $abj }}"
                                                                                            data-parent="#cardAccordion">
                                                                                            <div class="card-body">                                                                                                                                                                            
                                                                                                <div class="form-group">
                                                                                                    <textarea class="jawaban" name="jawaban{{ $abj }}" class="form-control">
                                                                                            @php
                                                                                                if($jmlop > $i){
                                                                                                $isiop = explode("[_#_]", $op[$i]);
                                                                                                echo $isiop[1];
                                                                                                }
                                                                                            @endphp
                                                                                            </textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>                                                                                    
                                                                                    @php
                                                                                                $abj++;
                                                                                        } 
                                                                                    @endphp
                                                                                </div>
                                                                                @elseif($soal->jenissoal_id=='2')
                                                                                <label for="first-name-column">Kunci Jawaban</label>
                                                                                <input type="text" name="kunci" class="form-control" value="{{ $soal->kunci }}">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                
                                                            </diV>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{ url('banksoal/'.$soal->banksoal_id) }}" class="btn btn-light-primary">
                                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                                <span class="d-none d-sm-block">Kembali</span>
                                                            </a>
                                                            <input type="submit" class="btn btn-primary ml-1" value="Simpan">
                                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                        </div>
                                                    </form>                                                        
                                                    <script type="text/javascript">
                                                        $(document).ready(function() {
                                                            $('.soal').summernote({
                                                                placeholder: 'Tuliskan Soal',
                                                                tabsize: 1,
                                                                height: 100
                                                            });
                                                        });
                                                        
                                                        $(document).ready(function() {
                                                            $('.jawaban').summernote({
                                                                placeholder: 'Tuliskan Pilihan',
                                                                tabsize: 1,
                                                                height: 50
                                                            });
                                                        });
                                                    </script>
            </div>
        </div>
    </section>
</div>
@endsection