<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Antrian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script>function goFullscreen() {
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) { // Firefox
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) { // Chrome, Safari, Opera
            document.documentElement.webkitRequestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) { // IE/Edge
            document.documentElement.msRequestFullscreen();
        }
    }
    </script>
	<style>
		html, body {
            height: 100%; /* Pastikan elemen html dan body memenuhi 100% tinggi layar */
            margin: 0;    /* Hapus margin default */
            padding: 0;   /* Hapus padding default */
            }

        .badge-position {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 10px 15px;
            background-color: #007bff; /* Warna biru untuk badge */
            color: white;
            font-weight: bold;
            border-radius: 50px;
        }

        .fullscreen {
            width: 100%;
            height: 100vh;  /* 100% dari tinggi layar */
            display: flex;
            justify-content: center;
            align-items: center;  /* Untuk menyejajarkan elemen di tengah layar */
            background-color: #7f868f;  /* Ganti dengan warna latar belakang sesuai kebutuhan */
        }

        /* CSS untuk tampilan kupon */
        .card {
            border: 1px solid #007bff; /* Border biru untuk kesan kupon */
            border-radius: 15px; /* Sudut yang melengkung */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Efek shadow */
            padding: 20px;
            background-color: #f8f9fa; /* Warna latar belakang yang cerah */
            margin-bottom: 20px;
        }

        .card-body {
            text-align: center; /* Rata tengah teks */
            font-family: 'Arial', sans-serif; /* Ganti font ke font yang lebih jelas */
        }

        .card-title {
            font-size: 1.25rem; /* Ukuran font lebih besar */
            color: #007bff; /* Warna biru untuk judul */
            font-weight: bold;
        }

        .card-text {
            font-size: 1.2rem; /* Ukuran font nama lebih besar */
            margin-top: 10px;
            font-weight: bold;
        }

        .card-subtitle {
            color: #6c757d; /* Warna abu-abu untuk subjudul */
            font-size: 1rem;
        }

        .container {
            padding-top: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        
     
    </style>
</head>
<body>
	<div class="fullscreen">
    <div class="container mt-5">
        <div class="container-fluid">
            <div class="row">
                <img src="https://www.kpu.go.id/img/logo-kpu.png" alt="kpu" class="col-sm-2" style="max-height:60px; width:auto">
                <div class="col-sm-10" ><h4>KELOMPOK PENYELENGGARA PEGUMUTAN SUARA <br/>
                TPS 004 DESA RINGINHARJO</h4>
                </div>
            
            </div>
        </div>
        <h2>Daftar Antrian</h2>

        <div class="alert alert-info">
            <strong>Info:</strong> <?= $info_mencoblos ?>
        </div>
        <div class="container-fluid mb-3">
            <h4>Kehadiran</h4>

            <!-- Progress Bar untuk Laki-laki -->
                <div class="progress mb-3">
                    <div id="maleProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        Laki-Laki
                    </div>
                </div>
                <div class="progress">
                    <div id="femaleProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        Perempuan
                    </div>
                </div>

        </div>

        <!-- Daftar Antrian dalam Bentuk Card -->
        <div class="row" id="antrianCards">
            <!-- Card akan dimasukkan di sini melalui AJAX -->
        </div>
    </div>
	

</div>
<button onclick="goFullscreen()">full</button>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function updateAntrian() {
        $.ajax({
            url: "<?= site_url('antrian/get_antrian_data'); ?>", // URL ke kontroler
            type: "GET",
            dataType: "json",
            success: function(data) {
                // Kosongkan div row sebelum memasukkan card baru
                var row = $('#antrianCards');
                row.empty();

                // Loop untuk menampilkan data dalam bentuk card
                $.each(data.antrian, function(index, item) {
                    var card = `
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <span class="badge bg-primary badge-position">${index + 1}</span>
                                    </h6>
                                    <h3 class="card-text">${item.nama}</h3>
                                    <h5 class="card-subtitle mb-2 text-muted">${item.jenis_kelamin}</h5>
                                    <h5 class="card-subtitle mb-2 text-muted">No DPT: ${item.id_dpt}</h5>
                                </div>
                            </div>
                        </div>`;
                    row.append(card);
                });

                // Update progress bar
                const maleChosen = data.progress.maleChosen || 0;
                const femaleChosen = data.progress.femaleChosen || 0;
                const totalMale = data.progress.totalMale || 1; // Hindari pembagian dengan nol
                const totalFemale = data.progress.totalFemale || 1;

                const maleProgress = (maleChosen / totalMale) * 100;
                const femaleProgress = (femaleChosen / totalFemale) * 100;

                $('#maleProgressBar')
                    .css('width', maleProgress + '%')
                    .attr('aria-valuenow', maleProgress)
                    .text(`Laki-laki ` + maleChosen + ` (${Math.round(maleProgress)}%)`);

                $('#femaleProgressBar')
                    .css('width', femaleProgress + '%')
                    .attr('aria-valuenow', femaleProgress)
                    .text(`Perempuan ` + femaleChosen + ` (${Math.round(femaleProgress)}%)`);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }

    // Update card setiap 5 detik
    setInterval(updateAntrian, 5000);

    // Panggil fungsi updateAntrian saat pertama kali halaman dimuat
    $(document).ready(function() {
        updateAntrian();
    });
</script>

</body>
</html>
