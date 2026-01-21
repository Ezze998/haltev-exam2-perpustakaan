<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helper.php';

requireLogin();

// safety check
if (
    !isset($_SESSION['user_data']['id_user']) ||
    !in_array($_SESSION['user_data']['role'], ['staff', 'admin'])
) {
    die('Akses ditolak. Hanya staff yang boleh meminjamkan buku.');
}

$id_staff   = $_SESSION['user_data']['id_user'];
$id_anggota = $_POST['id_anggota'] ?? null;
$id_buku    = $_POST['id_buku'] ?? null;

if (!$id_anggota || !$id_buku) {
    $_SESSION['error'] = "Data peminjaman tidak lengkap";
    header("Location: ../dashboard.php");
    exit;
}

// cara supaya anggota tidak meminjam 2 buku yang sama
$cek = $conn->prepare("
    SELECT id_peminjaman 
    FROM peminjaman 
    WHERE id_anggota = ? 
      AND id_buku = ?
      AND status_kembali = 'dipinjam'
");
$cek->bind_param("ii", $id_anggota, $id_buku);
$cek->execute();
$cek->store_result();

if ($cek->num_rows > 0) {
    $_SESSION['error'] = "Anggota ini masih meminjam buku yang sama!";
    header("Location: ../dashboard.php");
    exit;
}

// cek stok
$stok = $conn->prepare("
    SELECT available_copies 
    FROM buku 
    WHERE id_buku = ?
");
$stok->bind_param("i", $id_buku);
$stok->execute();
$result = $stok->get_result()->fetch_assoc();

if ($result['available_copies'] <= 0) {
    $_SESSION['error'] = "Stok buku habis!";
    header("Location: ../dashboard.php");
    exit;
}

// insert peminjaman
$tgl_pinjam  = date('Y-m-d');
$tgl_tenggat = date('Y-m-d', strtotime('+7 days'));

$insert = $conn->prepare("
    INSERT INTO peminjaman 
    (id_buku, id_anggota, id_staff, tanggal_pinjam, tanggal_tenggat, status_kembali)
    VALUES (?, ?, ?, ?, ?, 'dipinjam')
");
$insert->bind_param(
    "iiiss",
    $id_buku,
    $id_anggota,
    $id_staff,
    $tgl_pinjam,
    $tgl_tenggat
);
$insert->execute();

// kurangi stok buku
$update = $conn->prepare("
    UPDATE buku 
    SET available_copies = available_copies - 1 
    WHERE id_buku = ?
");
$update->bind_param("i", $id_buku);
$update->execute();

$_SESSION['success'] = "Buku berhasil dipinjam!";
header("Location: ../dashboard.php");
exit;
