<?php
require_once '../config/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $role = $_POST['role'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $stmt = $pdo->prepare("INSERT INTO employees (name, role, email, password) VALUES (?, ?, ?, ?)");
  $stmt->execute([$name, $role, $email, $password]);
  header("Location: index.php");
  exit();
}
?>