<?php
$baseURL = "http://localhost/perpustakaan";
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helper.php';

requireLogin();

$anggota = $conn->query('SELECT * FROM anggota ORDER BY id_anggota LIMIT 20')->fetch_all(MYSQLI_ASSOC);
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
    <link rel="stylesheet" href="../dashboard.css">
</head>

<div class="dashboard-wrapper">

    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <div class="main">
        <?php require_once __DIR__ . '/../layout/header.php'; ?>

        <section class="table-section">
            <h3>Daftar Anggota</h3>
            <a href="create.php" class="btn btn-primary">+ Tambah Anggota</a>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Nama Anggota</th>
                        <th scope="col">Telepon</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomor = 1;
                    foreach ($anggota as $key => $value): ?>
                        <tr>
                            <th scope="row"><?= $nomor++ ?></th>
                            <td><?= $value['nama_lengkap'] ?></td>
                            <td><?= $value['telepon'] ?></td>
                            <td><?= $value['alamat'] ?></td>
                            <td>
                                <?php if ($value['status'] === 'aktif'): ?>
                                    <a href="status.php?id_anggota=<?= $value['id_anggota'] ?>&status=aktif"
                                        class="badge bg-success text-decoration-none"
                                        onclick="return confirm('Nonaktifkan anggota ini?')">
                                        Aktif
                                    </a>
                                <?php else: ?>
                                    <a href="status.php?id_anggota=<?= $value['id_anggota'] ?>&status=nonaktif"
                                        class="badge bg-danger text-decoration-none"
                                        onclick="return confirm('Aktifkan anggota ini?')">
                                        Non Aktif
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td><?= $value['created_at'] ?></td>
                            <td class="text-nowrap">
                                <div class="btn-group" role="group">
                                    <a href="edit.php?id_anggota=<?= $value['id_anggota'] ?>"
                                        class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <a href="delete.php?id_anggota=<?= $value['id_anggota'] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirmDelete()">
                                        Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <?php require_once __DIR__ . '/../layout/footer.php'; ?>
    </div>
</div>