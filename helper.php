<?php 
require_once __DIR__ . "/config.php";

$baseURL = "http://localhost/perpustakaan";

function requireLogin()
{
    if (
        !isset($_SESSION['user_data']) ||
        empty($_SESSION['user_data']['is_logged_in'])
    ) {
        header("Location: /perpustakaan/auth/login.php");
        exit;
    }
}

function requireAdmin()
{
    requireLogin();

    if ($_SESSION['user_data']['role'] !== 'admin') {
        header("Location: /perpustakaan/dashboard.php");
        exit;
    }
}

// Create, Edit, Delete Buku
function store_Buku(string $judul, int $isbn, string $penulis, int $total_copies) {
    global $conn;
    global $baseURL;
    $created_at = date("Y-m-d H:i:s");
     // Jalankan Logic database disini
    $stmt = $conn->prepare("INSERT INTO buku (judul, isbn, penulis, total_copies, available_copies, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$judul, $isbn, $penulis, $total_copies, $total_copies, $created_at]);

    // Optional: berikan pesan berhasil ke halaman
    $_SESSION['success'] = "Buku berhasil ditambahkan";

    // Jika tidak ada error, redirect ke halaman index.php
    header("Location:" . $baseURL . "/buku/index.php");
    exit();
}

function update_Buku(string $judul, int $isbn, string $penulis, int $total_copies, int $id_buku) 
{
    global $conn;
    global $baseURL;

     // Jalankan Logic database disini
    $stmt = $conn->prepare("UPDATE buku SET judul=?, isbn=?, penulis=?, total_copies=? WHERE id_buku=?");
    $stmt->execute([$judul, $isbn, $penulis, $total_copies, $id_buku]);

    // Optional: berikan pesan berhasil ke halaman
    $_SESSION['success'] = "Edit pada buku berhasil";

    // Jika tidak ada error, redirect ke halaman index.php
    header("Location:" . $baseURL . "/buku/index.php");
    exit();
}

function delete_Buku(int $id_buku) {
    global $conn;
    global $baseURL;

    $stmt = $conn->prepare("DELETE FROM buku WHERE id_buku = ?");
    $stmt->execute([$id_buku]);

    // Optional: berikan pesan berhasil ke halaman
    $_SESSION['success'] = "Delete data buku berhasil";

    // Jika tidak ada error, redirect ke halaman index.php
    header("Location:" . $baseURL . "/buku/index.php");
    exit();
}

// Create, Edit, Delete Anggota
function store_Anggota(string $nama_lengkap, string $telepon, string $alamat) {
    global $conn;
    global $baseURL;
    $created_at = date("Y-m-d H:i:s");
     // Jalankan Logic database disini
    $stmt = $conn->prepare("INSERT INTO anggota (nama_lengkap, telepon, alamat, created_at) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nama_lengkap, $telepon, $alamat, $created_at]);

    // Optional: berikan pesan berhasil ke halaman
    $_SESSION['success'] = "Anggota berhasil ditambahkan";

    // Jika tidak ada error, redirect ke halaman index.php
    header("Location:" . $baseURL . "/anggota/index.php");
    exit();
}


function update_Anggota(string $nama_lengkap, string $telepon, string $alamat, int $id_anggota)
{
    global $conn;
    global $baseURL;

    // Jalankan logic database di sini
    $stmt = $conn->prepare("UPDATE anggota SET nama_lengkap = ?, telepon = ?, alamat = ? WHERE id_anggota = ?");
    $stmt->execute([$nama_lengkap, $telepon, $alamat, $id_anggota]);

    // Optional: pesan sukses
    $_SESSION['success'] = "Edit data anggota berhasil";

    // Redirect ke index anggota
    header("Location:" . $baseURL . "/anggota/index.php");
    exit();
}

function delete_Anggota(int $id_anggota) {
    global $conn;
    global $baseURL;

    $stmt = $conn->prepare("DELETE FROM anggota WHERE id_anggota = ?");
    $stmt->execute([$id_anggota]);

    // Optional: berikan pesan berhasil ke halaman
    $_SESSION['success'] = "Delete data anggota berhasil";

    // Jika tidak ada error, redirect ke halaman index.php
    header("Location:" . $baseURL . "/anggota/index.php");
    exit();
}

// User
function store_user($username, $password, $nama_lengkap, $role)
{
    global $conn, $baseURL;

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $conn->query("
        INSERT INTO user (username, password, nama_lengkap, role)
        VALUES (
            '$username',
            '$password_hash',
            '$nama_lengkap',
            '$role'
        )
    ");

    $_SESSION['success'] = "User berhasil ditambahkan";
    header("Location: $baseURL/staff/index.php");
    exit;
}

function update_user($id_user, $username, $password, $nama_lengkap, $role)
{
    global $conn, $baseURL;

    if (!empty($password)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $conn->query("
            UPDATE user SET
                username = '$username',
                password = '$hash',
                nama_lengkap = '$nama_lengkap',
                role = '$role'
            WHERE id_user = $id_user
        ");
    } else {
        $conn->query("
            UPDATE user SET
                username = '$username',
                nama_lengkap = '$nama_lengkap',
                role = '$role'
            WHERE id_user = $id_user
        ");
    }

    $_SESSION['success'] = "User berhasil diperbarui";
    header("Location: $baseURL/staff/index.php");
    exit;
}

function delete_user($id_user)
{
    global $conn, $baseURL;

    // Extra safety check
    if (
        !isset($_SESSION['user_data']['role']) ||
        $_SESSION['user_data']['role'] !== 'admin'
    ) {
        header("Location: $baseURL/user/index.php");
        exit;
    }

    $conn->query("DELETE FROM user WHERE id_user = $id_user");

    $_SESSION['success'] = "User berhasil dihapus";
    header("Location: $baseURL/staff/index.php");
    exit;
}
