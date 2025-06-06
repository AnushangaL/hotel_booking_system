<?php
require_once '../../config/database.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM rooms WHERE id = ?");
$stmt->execute([$id]);

header("Location: list_rooms.php");
exit();
?>
