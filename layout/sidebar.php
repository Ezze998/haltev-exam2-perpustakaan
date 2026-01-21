<?php
$baseURL = "http://localhost/perpustakaan";

$currentURL = $_SERVER['REQUEST_URI'];

function isActive($path)
{
    global $currentURL;
    return strpos($currentURL, $path) !== false ? 'active' : '';
}
?>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h5>Perpustakaan</h5>
    </div>

    <div class="sidebar-user">
        <i class="fa fa-user-circle"></i>
        <div class="username"><?= htmlspecialchars($_SESSION['user_data']['username']) ?></div>
        <small><?= ucfirst($_SESSION['user_data']['role']) ?></small>
    </div>

    <ul class="sidebar-menu">
        <li>
            <a class="<?= isActive('/dashboard.php') ?>" href="<?= $baseURL ?>/dashboard.php">
                <i class="fa fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a class="<?= isActive('/buku') ?>" href="<?= $baseURL ?>/buku/index.php">
                <i class="fa fa-box"></i>
                <span>Kelola Buku</span>
            </a>
        </li>

        <li>
            <a class="<?= isActive('/anggota') ?>" href="<?= $baseURL ?>/anggota/index.php">
                <i class="fa fa-users"></i>
                <span>Kelola Keanggotaan</span>
            </a>
        </li>

        <li>
            <a class="<?= isActive('/staff') ?>" href="<?= $baseURL ?>/staff/index.php">
                <i class="fa fa-user-tie"></i>
                <span>Kelola Staff</span>
            </a>
        </li>

        <li>
            <a class="<?= isActive('/peminjaman') ?>" href="<?= $baseURL ?>/peminjaman/index.php">
                <i class="fa fa-book"></i>
                <span>Kelola Peminjaman</span>
            </a>
        </li>
        <li>
        <a href="<?= $baseURL ?>/auth/logout.php">
            <i class="fa fa-sign-out-alt"></i>
            <span style="color: red;">Logout</span>
        </a>
        </li>
    </ul>
</div>
