@extends('layouts.quiz')

@section('content')


<div class="main-content container-fluid">
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">                                
                                Soal No : <button class="btn btn-outline-primary">{{ $nosoal }}</button>
                            </div>
                            <div class="col-6 d-flex flex-row-reverse">
                                <button type="button" class="btn btn-outline-primary" id="timer"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @php
        $es = explode('(_#_)', $pengerjaan->rekaman);
        $akhir = count($es);
        $ia = explode('(-)', $es[$nosoal]);
        $jmluraian = count($ia);
        $soal = App\Models\Soal::where('id', $ia[0])->first();
        $jw = explode('[#_#]', $soal->jawaban);
    @endphp    
    <form action="{{ url('pengerjaan') }}" method="POST">
        @csrf
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">                        
                        <input type="hidden" name="soal" value="{{ $ia[0] }}">
                        <input type="hidden" name="nosoal" value="{{ $nosoal }}">
                        <h4 class="card-title">{!! $soal->soal !!}</h4>
                    </div>
                    <div class="card-body">
                        @if($soal->jenissoal_id == 1)
                        @php                
                        $jmlop = count($jw);
                        for ($i = 0; $i < $jmlop; $i++) {
                            if($jw[$i]!=""){
                                $isiop = explode("[_#_]", $jw[$i]);
                        @endphp
                        <div class="form-check form-check-success">
                            <input class="form-check-input" type="radio" name="opsi" value="{{ $isiop[0] }}" {{ ($isiop[0] == $ia[1]) ? "checked" : false }}>
                            <label class="form-check-label" for="Success">
                                {!! $isiop[1] !!}
                            </label>
                        </div>
                        @php                        
                            }
                        } 
                        @endphp
                        @elseif($soal->jenissoal_id == 2)
                            @php
                                $jawaban = App\Models\Jawabanuraian::where('pengerjaan_id', $pengerjaan->id)->where('soal_id', $ia[0])->first();
                                if($jawaban){
                                    $jawaban = $jawaban->jawaban;
                                } else {
                                    $jawaban = "";
                                }
                            @endphp
                            <input type="text" class="form-control" name="opsi" value="{{ $jawaban }}">
                        @else
                        @php
                                $jawaban = App\Models\Jawabanuraian::where('pengerjaan_id', $pengerjaan->id)->where('soal_id', $ia[0])->first();
                                if($jawaban){
                                    $jawaban = $jawaban->jawaban;
                                } else {
                                    $jawaban = "";
                                }
                            @endphp
                            <textarea name="opsi" class="uraian">{!! $jawaban !!}</textarea>
                                                           
                            <script type="text/javascript">                                    
                                $(document).ready(function() {
                                    $('.uraian').summernote({
                                        placeholder: 'Tuliskan Jawaban anda',
                                        tabsize: 1,
                                        height: 100
                                    });
                                });
                            </script>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn icon icon-left btn-primary" value="{{ $nosoal-1 }}" name="no" {{ ($nosoal==1) ? "disabled" : false }}><i data-feather="arrow-left"></i> Sebelumnya</button>
                            </div>
                            <div class="col-6 d-flex flex-row-reverse">
                                @if($nosoal==(count($es)-1))
                                <button type="submit" class="btn icon icon-right btn-danger" value="akhir" name="no" onclick="return confirm('Yakin akan mengakhiri kuis ini?')">Akhiri <i data-feather="check-square"></i></button>
                                @else
                                <button type="submit" class="btn icon icon-right btn-primary" value="{{ $nosoal+1 }}" name="no">Selanjutnya <i data-feather="arrow-right"></i></button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <button type="button" class="btn icon icon-left btn-success" data-toggle="modal"
                        data-target="#exampleModalCenter"><i data-feather="grid"></i> Daftar Soal</button>
                    <!-- Vertically Centered modal Modal -->
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Daftar Soal</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table width="100%" cellpadding="4" cellspacing="4">
                                        <tr>
                                            @php
                                            for ($i = 1; $i < count($es); $i++) {
                                                $cia = explode('(-)', $es[$i]);
                                                $btn = "light";
                                                if ($nosoal == $i) {
                                                    $btn = "info";
                                                } else if ($cia[1] != 0) {
                                                    $btn = "success";
                                                }
                                            @endphp
                                                <td>
                                                    <button type="submit" name="no" value="<?= $i ?>" class="btn btn-<?= $btn ?> btn-xs btn-block"><?= $i ?></button>
                                                </td>
                                                @php
                                                if ($i % 5 == 0) {
                                                    echo "</tr><tr>";
                                                }
                                            } 
                                            @endphp
                                        </tr>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Tutup</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </form>
</div>
<script>
    // Set the date we're counting down to
    var countDownDate = new Date("{{ $waktuselesai->format('M d, Y H:i:s') }}").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("timer").innerHTML = ('00' + hours).slice(-2) + ":" +
            ('00' + minutes).slice(-2) + ":" + ('00' + seconds).slice(-2);

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("timer").innerHTML = "00:00:00";
            window.location.href = "{{ url('pengerjaan/'.$pengerjaan->id.'?no=akhir') }}";
        }
    }, 1000);
</script>
<script>
    
    // Ketika tab kehilangan fokus
     document.addEventListener("visibilitychange", function () {
       if (document.hidden) {
         alert('Anda terdeteksi meninggalkan halaman, anda akan di blokir apabila melakukannya lagi');
       }
     });

    // Bisa juga deteksi ketika jendela kehilangan fokus
     window.addEventListener("blur", () => {
         alert('Anda terdeteksi meninggalkan halaman, anda akan di blokir apabila melakukannya lagi');
     });

    // Nonaktifkan klik kanan
    document.addEventListener('contextmenu', function (e) {
      e.preventDefault();
    });

    // Nonaktifkan copy, paste, dan cut
    document.addEventListener('copy', function (e) {
      e.preventDefault();
    });

    document.addEventListener('paste', function (e) {
      e.preventDefault();
    });

    document.addEventListener('cut', function (e) {
      e.preventDefault();
    });

    // let initialHeight = window.innerHeight;
    // let initialWidth = window.innerWidth;

    // window.addEventListener("resize", () => {
    // let currentHeight = window.innerHeight;
    // let currentWidth = window.innerWidth;

    // let heightDiff = Math.abs(currentHeight - initialHeight);
    // let widthDiff = Math.abs(currentWidth - initialWidth);

    // if (heightDiff > 100 || widthDiff > 100) {
    //     alert('Anda terdeteksi melakukan split screen, anda akan di blokir apabila melakukannya lagi');
    // }
    // });
</script>
@endsection