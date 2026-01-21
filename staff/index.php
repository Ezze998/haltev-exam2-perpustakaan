<?php
$baseURL = "http://localhost/perpustakaan";
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helper.php';

// var_dump($_SESSION);

requireLogin();

$user = $conn->query('SELECT * FROM user ORDER BY id_user')->fetch_all(MYSQLI_ASSOC);
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
            <h3>Daftar Staff</h3>
            <?php if ($_SESSION['user_data']['role'] === 'admin'): ?>
                <a href="create.php" class="btn btn-primary">+ Tambah Staff</a>
            <?php endif; ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Username</th>
                        <th scope="col">Role</th>
                        <th scope="col">Created</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($user as $value): ?>
                        <tr>
                            <td><?= $value['id_user'] ?></td>
                            <td><?= $value['nama_lengkap'] ?></td>
                            <td><?= $value['username'] ?></td>
                            <td><?= ucfirst($value['role']) ?></td>
                            <td><?= $value['created_at'] ?></td>
                            <td>
                                <a href="edit.php?id_user=<?= $value['id_user'] ?>"
                                    class="btn btn-warning btn-sm" onclick="return confirm('Hanya admin')">
                                    Edit
                                </a>

                                <?php if (
                                    isset($_SESSION['user_data']['role']) &&
                                    $_SESSION['user_data']['role'] === 'admin' &&
                                    $_SESSION['user_data']['id_user'] != $value['id_user']
                                ): ?>
                                    <a href="delete.php?id_user=<?= $value['id_user'] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus user ini?')">
                                        Hapus
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <?php require_once __DIR__ . '/../layout/footer.php'; ?>
    </div>
</div>