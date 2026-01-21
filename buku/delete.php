<?php 
require_once __DIR__ . '/../config.php';

$id_buku = $_GET['id_buku'];

$stmt = $conn->prepare("DELETE FROM buku WHERE id_buku = ?");
$stmt->bind_param("i", $id_buku);
$stmt->execute();

header("Location: index.php");
exit;
?>