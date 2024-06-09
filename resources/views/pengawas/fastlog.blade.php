<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAFTAR PENGAWAS RUANGAN</title>
    
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    
<link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
</head>
<body>
<div class="main-content container-fluid">
    <section class="section">
        <div class="card">
            <div class="card-header">
                Daftar Ruangan
            </div>
            <div class="card-body">
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Nama Ruang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ruangans as $ruangan)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $ruangan->ruangan }}</td>                            
                            <td>
                                @php
                                    $user = preg_replace("/[^a-zA-Z0-9]/", "", $ruangan->ruangan);
                                @endphp
                                <a href="{{ url('fastlog?username='.$user.'&password=Cimanuk309A') }}" class="badge bg-success">Masuk</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

<script src="assets/js/feather-icons/feather.min.js"></script>
<script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="assets/js/app.js"></script>

<script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
<script src="assets/js/vendors.js"></script>

<script src="assets/js/main.js"></script>
</body>
</html>