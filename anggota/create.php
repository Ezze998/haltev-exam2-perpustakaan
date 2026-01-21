<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helper.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    store_Anggota(
        $_POST['nama_lengkap'],
        $_POST['telepon'],
        $_POST['alamat']
    );
    exit();
}
?>

<div class="dashboard-wrapper">

    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <div class="main">
        <?php require_once __DIR__ . '/../layout/header.php'; ?>

        <form action="" method="post">
            <input type="hidden" name="status" value="aktif">

            <div>
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control">
            </div>

            <div>
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" name="telepon" class="form-control">
            </div>

            <div>
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control">
            </div>

            <button class="btn btn-primary" type="submit">save</button>
        </form>



        <?php
        require_once __DIR__ . '/../layout/footer.php';
