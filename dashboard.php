<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helper.php';
requireLogin();

/* ===== CARD DATA ===== */

// Jumlah buku
$total_buku = $conn->query("SELECT COUNT(*) total FROM buku")
    ->fetch_assoc()['total'];

// Buku sedang dipinjam
$aktif_pinjam = $conn->query("
    SELECT COUNT(*) total 
    FROM peminjaman 
    WHERE status_kembali = 'dipinjam'
")->fetch_assoc()['total'];

// Jumlah anggota aktif
$total_anggota = $conn->query("
    SELECT COUNT(*) total 
    FROM anggota 
    WHERE status = 'aktif'
")->fetch_assoc()['total'];

// Buku terlambat
$terlambat = $conn->query("
    SELECT COUNT(*) total
    FROM peminjaman
    WHERE status_kembali = 'dipinjam'
    AND tanggal_tenggat < CURDATE()
")->fetch_assoc()['total'];

/* ===== DATA FORM ===== */

// anggota
$anggota = $conn->query("
    SELECT id_anggota, nama_lengkap 
    FROM anggota 
    WHERE status = 'aktif'
")->fetch_all(MYSQLI_ASSOC);

// buku (yang masih tersedia)
$buku = $conn->query("
    SELECT id_buku, judul 
    FROM buku 
    WHERE available_copies > 0
")->fetch_all(MYSQLI_ASSOC);

/* ===== PEMINJAMAN TERBARU ===== */
$peminjaman = $conn->query("
    SELECT 
        p.id_peminjaman,
        a.nama_lengkap,
        b.judul,
        p.tanggal_pinjam,
        p.tanggal_tenggat,
        p.status_kembali
    FROM peminjaman p
    JOIN anggota a ON p.id_anggota = a.id_anggota
    JOIN buku b ON p.id_buku = b.id_buku
    ORDER BY p.id_peminjaman DESC
    LIMIT 5
")->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">

<head>
    <title>Perpustakaan</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="dashboard.css">
</head>

<div class="dashboard-wrapper">

    <?php require_once __DIR__ . '/layout/sidebar.php'; ?>

    <div class="main">
        <?php require_once __DIR__ . '/layout/header.php'; ?>

        <section class="cards">
            <div class="card green">
                <p>Jumlah Buku</p>
                <h2><?= $total_buku ?></h2>
            </div>

            <div class="card green">
                <p>Buku Sedang Dipinjam</p>
                <h2><?= $aktif_pinjam ?></h2>
            </div>

            <div class="card green">
                <p>Jumlah Anggota Aktif</p>
                <h2><?= $total_anggota ?></h2>
            </div>

            <div class="card <?= $terlambat > 0 ? 'red' : 'green' ?>">
                <p>Buku Terlambat</p>
                <h2><?= $terlambat ?></h2>
            </div>
        </section>



        <!-- PINJAM BUKU -->

        <section class="form-section">
            <h3>Pinjamkan Buku</h3>

            <form action="peminjaman/pinjam.php" method="post">

                <label>Anggota Perpus</label>
                <select name="id_anggota" class="form-control" required>
                    <option value="">-- Pilih Anggota --</option>
                    <?php foreach ($anggota as $a): ?>
                        <option value="<?= $a['id_anggota'] ?>">
                            <?= $a['nama_lengkap'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Buku yang Ingin Dipinjam</label>
                <select name="id_buku" class="form-control" required>
                    <option value="">-- Pilih Buku --</option>
                    <?php foreach ($buku as $b): ?>
                        <option value="<?= $b['id_buku'] ?>">
                            <?= $b['judul'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button class="btn btn-primary mt-2">Pinjamkan</button>
            </form>

        </section>

        <section class="table-section">
            <h3>Peminjaman Terbaru</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tenggat</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($peminjaman) == 0): ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada peminjaman</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($peminjaman as $i => $p): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= $p['nama_lengkap'] ?></td>
                                <td><?= $p['judul'] ?></td>
                                <td><?= $p['tanggal_pinjam'] ?></td>
                                <td><?= $p['tanggal_tenggat'] ?></td>
                                <td>
                                    <span class="badge bg-<?= $p['status_kembali'] == 'dipinjam' ? 'warning' : 'success' ?>">
                                        <?= $p['status_kembali'] ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <?php require_once __DIR__ . '/layout/footer.php'; ?>
    </div>

</div>