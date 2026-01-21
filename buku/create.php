<?php
require_once __DIR__ . '/../helper.php';
require_once __DIR__ . '/../config.php';
requireLogin();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil semua data dari form
    $judul = $_POST['judul'];
    $isbn = $_POST['isbn'];
    $penulis = $_POST['penulis'];
    $total_copies = $_POST['total_copies'];

    store_Buku($judul, $isbn, $penulis, $total_copies);
    exit();
}
?>

<div class="dashboard-wrapper">

    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <div class="main">
        <?php require_once __DIR__ . '/../layout/header.php'; ?>

        <form action="" method="post">
            <div>
                <label for="judul" class="form-label">Judul Buku</label>
                <input type="text" name="judul" class="form-control">
            </div>

            <div>
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" name="isbn" class="form-control">
            </div>

            <div>
                <label for="penulis" class="form-label">Penulis</label>
                <input type="text" name="penulis" class="form-control">
            </div>

            <div>
                <label for="total_copies" class="form-label">Total Copies</label>
                <input type="text" name="total_copies" class="form-control">
            </div>

            <button class="btn btn-primary" type="submit">save</button>
        </form>



        <?php
        require_once __DIR__ . '/../layout/footer.php';
