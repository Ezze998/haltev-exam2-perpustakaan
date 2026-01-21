<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helper.php';

// Protect page (admin only)
requireLogin();
requireAdmin();

// Get ID
$id_user = $_GET['id_user'] ?? null;
if (!$id_user) {
    header("Location: index.php");
    exit;
}

// Get user data
$result = $conn->query("SELECT * FROM user WHERE id_user = $id_user");
$user = $result->fetch_assoc();

if (!$user) {
    die("User tidak ditemukan");
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    update_user(
        $id_user,
        $_POST['username'],
        $_POST['password'] ?? '',
        $_POST['nama_lengkap'],
        $_POST['role']
    );
    exit;
}
?>


<div class="dashboard-wrapper">

    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <div class="main">
        <?php require_once __DIR__ . '/../layout/header.php'; ?>

        <main class="container p-4">
            <form method="post">

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text"
                        name="username"
                        class="form-control"
                        value="<?= htmlspecialchars($user['username']) ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password (kosongkan jika tidak diganti)</label>
                    <input type="password"
                        name="password"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text"
                        name="nama_lengkap"
                        class="form-control"
                        value="<?= htmlspecialchars($user['nama_lengkap']) ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control">
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>
                            Admin
                        </option>
                        <option value="staff" <?= $user['role'] == 'staff' ? 'selected' : '' ?>>
                            Staff
                        </option>
                    </select>
                </div>

                <button class="btn btn-primary" type="submit">Save</button>
                <a href="<?= $baseURL ?>/staff/index.php" class="btn btn-secondary">Cancel</a>

            </form>
        </main>

        <?php require_once __DIR__ . '/../layout/footer.php'; ?>