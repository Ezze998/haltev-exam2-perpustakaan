<?php
require_once __DIR__ . '/../helper.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    store_User(
        $_POST['username'],
        $_POST['password'],
        $_POST['nama_lengkap'],
        $_POST['role']
    );
    exit();
}
?>

<div class="dashboard-wrapper">

    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <div class="main">
        <?php require_once __DIR__ . '/../layout/header.php'; ?>

        <main class="container p-4">
            <h4 class="mb-4">Tambah Data Staff</h4>

            <form method="post">

                <!-- Nama Staff -->
                <div class="mb-3">
                    <label class="form-label">Nama Staff</label>
                    <input type="text"
                           name="nama_lengkap"
                           class="form-control"
                           required>
                </div>

                <!-- Username & Password -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Username</label>
                        <input type="text"
                               name="username"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               required>
                    </div>
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">
                        Save
                    </button>
                </div>

            </form>
        </main>

        <?php require_once __DIR__ . '/../layout/footer.php'; ?>