<?php
require_once __DIR__ . '/../helper.php';
require_once __DIR__ . '/../config.php';
requireLogin();

// Ambil id_anggota dari URL
$id_anggota = $_GET['id_anggota'];

// Ambil data anggota yang akan diedit
$stmt = $conn->prepare("SELECT * FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id_anggota);
$stmt->execute();
$anggota = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];

    update_Anggota($nama_lengkap, $telepon, $alamat, $id_anggota);
    exit();
}
?>

<div class="dashboard-wrapper">

    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <div class="main">
        <?php require_once __DIR__ . '/../layout/header.php'; ?>

        <main class="container p-4">
            <form action="" method="post">

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control"
                        value="<?= htmlspecialchars($anggota['nama_lengkap']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-control"
                        value="<?= htmlspecialchars($anggota['telepon']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control"
                        value="<?= htmlspecialchars($anggota['alamat']); ?>" required>
                </div>

                <button class="btn btn-primary" type="submit">Save</button>
                <a href="<?= $baseURL ?>/anggota/index.php" class="btn btn-secondary">Cancel</a>

            </form>
        </main>

        <?php require_once __DIR__ . '/../layout/footer.php'; ?>
