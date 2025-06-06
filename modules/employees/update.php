<?php
require_once '../config/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $role = $_POST['role'];
  $email = $_POST['email'];
  $stmt = $pdo->prepare("UPDATE employees SET name = ?, role = ?, email = ? WHERE id = ?");
  $stmt->execute([$name, $role, $email, $id]);
  header("Location: index.php");
  exit();
}
?>