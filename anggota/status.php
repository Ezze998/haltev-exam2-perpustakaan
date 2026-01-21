<?php
require_once __DIR__ . '/../config.php';

$id = $_GET['id_anggota'];
$status = $_GET['status'];

$newStatus = ($status === 'aktif') ? 'nonaktif' : 'aktif';

$stmt = $conn->prepare("UPDATE anggota SET status=? WHERE id_anggota=?");
$stmt->bind_param("si", $newStatus, $id);
$stmt->execute();

header("Location: index.php");
exit;
