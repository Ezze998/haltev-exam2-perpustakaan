<?php
$baseURL = "http://localhost/perpustakaan";
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helper.php';
requireLogin();


$buku = $conn->query('SELECT * FROM buku ORDER BY id_buku LIMIT 20')->fetch_all(MYSQLI_ASSOC);
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
            <h3>Daftar Buku</h3>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="create.php" class="btn btn-primary">+ Tambah Buku</a>

                <input type="text"
                    id="searchBuku"
                    class="form-control w-25"
                    placeholder="Cari buku...">
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Judul Buku</th>
                        <th scope="col">ISBN</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Total Copies</th>
                        <th scope="col">Available Copies</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomor = 1;
                    foreach ($buku as $key => $value): ?>
                        <tr>
                            <th scope="row"><?= $nomor++ ?></th>
                            <td><?= $value['judul'] ?></td>
                            <td><?= $value['isbn'] ?></td>
                            <td><?= $value['penulis'] ?></td>
                            <td><?= $value['total_copies'] ?></td>
                            <td><?= $value['available_copies'] ?></td>
                            <td><?= $value['created_at'] ?></td>
                            <td class="text-nowrap">
                                <div class="btn-group" role="group">
                                    <a href="edit.php?id_buku=<?= $value['id_buku'] ?>"
                                        class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <a href="delete.php?id_buku=<?= $value['id_buku'] ?>"
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