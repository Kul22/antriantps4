
<div class="row mt-5">

<script>
        $(document).ready(function() {
            $("#nama").autocomplete({
                source: function(request, response) { 
                    console.log("Request term: ", request.term);

                    $.ajax({
                        url: "<?= site_url('dpt/autocomplete') ?>", // URL untuk request
                        type: "GET",
                        dataType: "json",
                        data: {
                            term: request.term  // Kirimkan kata kunci pencarian
                        },
                        success: function(data) {
                            response(data); // Kirimkan hasil data ke autocomplete
                        },
                        error: function(xhr, status, error) {
                            console.log("Error: " + error);  // Debug jika ada error
                        }
                    });
                },
                minLength: 2,  // Autocomplete dimulai setelah 2 karakter
                select: function(event, ui) {
                    // Saat item dipilih, masukkan data ke input
                    $("#nama").val(ui.item.value); // Masukkan nama ke input
                    $("#id_dpt").val(ui.item.id);  // Masukkan ID ke hidden field
                    return false;
                }
            });

            $(".alert").fadeOut(3000);

            

        });

        

    </script>
<!-- Form Pilih Nama -->
<div class="row mb-4 col-md-6">
<div class="col-12">
        <h4 class="mb-4">Daftar Hadir</h4>
    </div>
    <div class="mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="<?= site_url('antrian/hadir') ?>" method="post">
                <div class="mb-3">
                    <label for="nama" class="form-label">Pilih Nama</label>
                    <input type="text" id="nama" class="form-control" placeholder="Masukkan nama">
                    <input type="hidden" id="id_dpt" name="id_dpt"> <!-- ID disimpan di sini -->
                </div>
                <div id="notification"></div>
                <button type="submit" id="submit_hadir" class="btn btn-primary">Hadir</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="row col-md-6">
    <h4>Progress Pemilih</h4>

    <!-- Progress Bar untuk Laki-laki -->
    <div class="progress">
        <div 
            class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
            role="progressbar" 
            style="width: <?= round(($maleChosen / $totalMale) * 100) ?>%;" 
            aria-valuenow="<?= $maleChosen ?>" 
            aria-valuemin="0" 
            aria-valuemax="<?= $totalMale ?>">
            Laki-laki: <?= $maleChosen ?>(
            <?= round(($maleChosen / $totalMale) * 100) ?>%)
        </div>
    </div>

    <!-- Progress Bar untuk Perempuan -->
    <div class="progress">
        <div 
            class="progress-bar progress-bar-striped progress-bar-animated bg-danger" 
            role="progressbar" 
            style="width: <?= round(($femaleChosen / $totalFemale) * 100) ?>%;" 
            aria-valuenow="<?= $femaleChosen ?>" 
            aria-valuemin="0" 
            aria-valuemax="<?= $totalFemale ?>">
            Perempuan: <?= $femaleChosen ?>(
            <?= round(($femaleChosen / $totalFemale) * 100) ?>%)
        </div>
    </div>
</div>
<?php if ($this->session->flashdata('message')): ?>
    <div class="sm-6">
    <div class="alert <?= $this->session->flashdata('alert_type'); ?> alert-floating">
        <?= $this->session->flashdata('message'); ?>
    </div>
    </div>
<?php endif; ?>
</div>
<!-- Tabel Daftar Antrian -->
<div class="row">
    <div class="col-md-8 mx-auto">
        <h4 class="text-center mb-4">Daftar Antrian</h4>
        <?php if (!empty($antrian)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">No DPT</th>
                        <th scope="col">Nama</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($antrian as $item): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $item['id_dpt'] ?></td>
                            <td><?= $item['nama'] ?></td>
                            <td class="text-center">
                                <a href="<?= site_url('antrian/selesai/'.$item['id']) ?>" class="btn btn-success btn-sm">
                                    Oke &#x2714;
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info text-center">
                Tidak ada antrian saat ini.
            </div>
        <?php endif; ?>
    </div>
</div>

