<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - SMKS YPPT GARUT</title>
    
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
    <div id="main">
            @include('layouts.side')
            @yield('content')
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-left">
                        <p>{{ date('Y') }} &copy; SMKS YPPT GARUT</p>
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

    <script src="{{ url('/') }}/assets/js/main.js"></script>

</body>
</html>
