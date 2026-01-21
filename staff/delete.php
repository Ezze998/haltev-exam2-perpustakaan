<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helper.php';

requireAdmin();

$id_user = $_GET['id_user'];

$stmt = $conn->prepare("DELETE FROM user WHERE id_user = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();

header("Location: index.php");
exit;
?>