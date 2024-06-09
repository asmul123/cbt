<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - SMKN 1 GARUT</title>
    
    <link rel="stylesheet" href="{{ url('/') }}/assets/vendors/choices.js/choices.min.css" />
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/bootstrap.css">
    
    <link rel="stylesheet" href="{{ url('/') }}/assets/vendors/chartjs/Chart.min.css">

    <link rel="stylesheet" href="{{ url('/') }}/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/app.css">
    <link rel="shortcut icon" href="{{ url('/') }}/assets/images/favicon.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- include summernote css/js -->
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" />

    <!-- place this script before closing body tag -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
</head>
<body>
    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
    <div class="sidebar-header">
        <img src="{{ url('/') }}/assets/images/banner.svg" alt="" srcset="">
    </div>
    @php
    $tapelaktifmenu = App\Models\Tahunpelajaran::where('is_active', '1')->first()->id;
    $aksesusermenu = App\Models\Aksesuser::where('user_id',auth()->user()->id)->where('tahunpelajaran_id', $tapelaktifmenu)->first();
    @endphp
    <div class="sidebar-menu">
        <ul class="menu">
            <li class='sidebar-title'>Main Menu</li>
                <li class="sidebar-item {{ ($menu === 'dashboard') ? 'active' : '' }}">
                    <a href="{{ url('/') }}/" class='sidebar-link'>
                        <i data-feather="home" width="20"></i> 
                        <span>Dashboard</span>
                    </a>
                </li>
                @if (auth()->user()->role->id == 1)
                <li class="sidebar-item  has-sub {{ ($menu === 'pengaturan') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="tool" width="20"></i> 
                        <span>Pengaturan</span>
                    </a>                    
                    <ul class="submenu {{ ($smenu === 'tahunpelajaran') ? 'active' : '' }}">                        
                        <li>
                            <a href="{{ url('/') }}/tahunpelajaran">Tahun Pelajaran</a>
                        </li>
                        <li>
                            <a href="{{ url('/') }}/hakakses">Hak Akses</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item  has-sub {{ ($menu === 'referensi') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="list" width="20"></i> 
                        <span>Referensi</span>
                    </a>                    
                    <ul class="submenu {{ ($smenu === 'user') ? 'active' : '' }}">                        
                        <li>
                            <a href="{{ url('/users') }}">Data Pengguna</a>
                        </li>
                        <li>
                            <a href="{{ url('/rombonganbelajar') }}">Data Rombongan Belajar</a>
                        </li>
                        <li>
                            <a href="{{ url('/ruang') }}">Data Ruangan</a>
                        </li>
                        <li>
                            <a href="{{ url('/kelompok') }}">Data Kelompok Ruang Rombel</a>
                        </li>
                        <li>
                            <a href="{{ url('/banksoal') }}/">Bank Soal</a>
                        </li>
                    </ul>
                </li>
                @elseif(auth()->user()->role->id == 2)
                    @if($aksesusermenu and $aksesusermenu->hakakses_id == 1)
                        <li class="sidebar-item {{ ($menu === 'administrasi') ? 'active' : '' }}">
                            <a href="{{ url('/dokumenkurikulum') }}" class='sidebar-link'>
                                <i data-feather="archive" width="20"></i> 
                                <span>Administrasi Guru</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ ($menu === 'kaprodi') ? 'active' : '' }}">
                            <a href="{{ url('/administrasikaprodi') }}" class='sidebar-link'>
                                <i data-feather="archive" width="20"></i> 
                                <span>Administrasi Kaprodi</span>
                            </a>
                        </li>
                    @else
                    <li class="sidebar-item {{ ($menu === 'pembelajaran') ? 'active' : '' }}">
                        <a href="{{ url('/') }}/pembelajaran" class='sidebar-link'>
                            <i data-feather="book-open" width="20"></i> 
                            <span>Pembelajaran</span>
                        </a>
                    </li>                    
                    @endif
                    @if($aksesusermenu and $aksesusermenu->hakakses_id == 4)
                    <li class="sidebar-item {{ ($menu === 'administrasi') ? 'active' : '' }}">
                        <a href="{{ url('/administrasikaprodi/create') }}" class='sidebar-link'>
                            <i data-feather="archive" width="20"></i> 
                            <span>Administrasi Kaprodi</span>
                        </a>
                    </li>
                    @elseif($aksesusermenu and $aksesusermenu->hakakses_id == 2)
                    <li class="sidebar-item {{ ($menu === 'administrasi') ? 'active' : '' }}">
                        <a href="{{ url('/dokumenkurikulum') }}" class='sidebar-link'>
                            <i data-feather="archive" width="20"></i> 
                            <span>Administrasi Guru</span>
                        </a>
                    </li>
                    @endif
                @elseif(auth()->user()->role->id == 3)
                <li class="sidebar-item {{ ($menu === 'pembelajaran') ? 'active' : '' }}">
                    <a href="{{ url('/') }}/pembelajaranpd" class='sidebar-link'>
                        <i data-feather="book-open" width="20"></i> 
                        <span>Pembelajaran</span>
                    </a>
                </li>
                @endif
                <li class="sidebar-item">
                    <form action="{{ url('/') }}/logout" method="POST" id="form-logout">
                        @csrf
                        <a href="javascript:;" onclick="parentNode.submit();" class="sidebar-link">
                            <i data-feather="log-out" width="20"></i> 
                            <span>Keluar</span>
                        </a>
                        </form>
                    </li>
                </ul>
            </div>
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>
    <div id="main">
            @include('layouts.side')
            @yield('content')
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-left">
                        <p>{{ date('Y') }} &copy; SMKN 1 GARUT</p>
                    </div>
                    <div class="float-right">
                        <p>Crafted with <span class='text-danger'><i data-feather="heart"></i></span> by <a href="#">PPLG</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ url('/') }}/assets/js/feather-icons/feather.min.js"></script>
    <script src="{{ url('/') }}/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="{{ url('/') }}/assets/js/app.js"></script>
    
    <script src="{{ url('/') }}/assets/vendors/chartjs/Chart.min.js"></script>
    <script src="{{ url('/') }}/assets/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="{{ url('/') }}/assets/js/pages/dashboard.js"></script>

    
    <!-- Include Choices JavaScript -->
    <script src="{{ url('/') }}/assets/vendors/choices.js/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="{{ url('/') }}/assets/js/main.js"></script>
    

</body>
</html>
