<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helper.php';
requireLogin();

$id_peminjaman = $_GET['id'] ?? null;

if (!$id_peminjaman) {
    header('Location: index.php');
    exit;
}

/* Ambil data peminjaman */
$data = $conn->prepare("
    SELECT id_buku 
    FROM peminjaman 
    WHERE id_peminjaman = ?
");
$data->bind_param("i", $id_peminjaman);
$data->execute();
$peminjaman = $data->get_result()->fetch_assoc();

if (!$peminjaman) {
    header('Location: index.php');
    exit;
}

/* Update status peminjaman */
$conn->query("
    UPDATE peminjaman 
    SET 
        status_kembali = 'dikembalikan',
        tanggal_kembali = CURDATE()
    WHERE id_peminjaman = $id_peminjaman
");

/* Tambah stok buku */
$conn->query("
    UPDATE buku 
    SET available_copies = available_copies + 1
    WHERE id_buku = {$peminjaman['id_buku']}
");

$_SESSION['success'] = "Buku berhasil dikembalikan!";
header("Location: index.php");
exit;
?>