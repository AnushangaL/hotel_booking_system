<?php
require_once '../../config/database.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM guests WHERE id = ?");
    $stmt->execute([$id]);
}
header('Location: list_guests.php');
exit;
