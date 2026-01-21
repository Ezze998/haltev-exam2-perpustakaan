<?php
require_once __DIR__ . '/../helper.php';
require_once __DIR__ . '/../config.php';

// Get dulu buku_id dari $_GET
$id_buku = $_GET['id_buku'];

// Ambil data prduk yang akan diedit
$stmt = $conn->prepare("SELECT * FROM buku WHERE id_buku = ?");
$stmt->execute([$id_buku]);
$buku = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil semua data dari form
    $judul = $_POST['judul'];
    $isbn = $_POST['isbn'];
    $penulis = $_POST['penulis'];
    $total_copies = $_POST['total_copies'];

    update_Buku($judul, $isbn, $penulis, $total_copies, $id_buku);
    exit();
}

?>

<div class="dashboard-wrapper">

    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <div class="main">
        <?php require_once __DIR__ . '/../layout/header.php'; ?>

        <main class="container p-4">
            <form action="" method="post">
                <div>
                    <label for="judul" class="form-label">Judul Buku</label>
                    <input type="text" name="judul" class="form-control"
                        value="<?= htmlspecialchars($buku['judul']); ?>">
                </div>

                <div>
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" name="isbn" class="form-control"
                        value="<?= htmlspecialchars($buku['isbn']); ?>">
                </div>

                <div>
                    <label for="penulis" class="form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control"
                        value="<?= htmlspecialchars($buku['penulis']); ?>">

                </div>

                <div>
                    <label for="total_copies" class="form-label">Total Copies</label>
                    <input type="text" name="total_copies" class="form-control"
                        value="<?= htmlspecialchars($buku['total_copies']); ?>">
                </div>

                <button class="btn btn-primary" type="submit">save</button>
            </form>
        </main>



        <?php
        require_once __DIR__ . '/../layout/footer.php';
