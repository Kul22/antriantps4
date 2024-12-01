<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Antrian</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <style>
        .alert-floating {
            position: fixed;
            top: 30px;
            right: 20px;
            z-index: 1050; /* Agar alert muncul di atas elemen lain */
            transition: opacity 0.5s ease-in;
            opacity: 1;
            display: block;
        }

        .alert-floating.hide {
            opacity: 0;
            visibility: hidden;
            transition: opacity 1.5s ease-out;
        }

    </style>

</head>
<body>
    <div class="container mt-4">
    <div class="container-fluid">
            <div class="row">
                <img src="https://www.kpu.go.id/img/logo-kpu.png" alt="kpu" class="col-sm-2" style="max-height:60px; width:auto">
                <div class="col-sm-10" ><h4>KELOMPOK PENYELENGGARA PEGUMUTAN SUARA <br/>
                TPS 004 DESA RINGINHARJO</h4>
                </div>
            
            </div>
        </div>
