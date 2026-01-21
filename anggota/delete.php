<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helper.php';

$id_anggota = $_GET['id_anggota'];

$stmt = $conn->prepare("DELETE FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id_anggota);
$stmt->execute();

header("Location: index.php");
exit;
?>