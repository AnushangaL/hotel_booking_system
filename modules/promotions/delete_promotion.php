<?php
require_once '../../config/db.php';
require_once '../../auth/auth_check.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM promotions WHERE id = ?");
$stmt->execute([$id]);
header("Location: promotion_list.php?deleted=1");
