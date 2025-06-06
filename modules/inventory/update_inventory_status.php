<?php
require_once '../../config/database.php';
require_once '../../includes/auth_check.php';

// Only allow manager roles
$allowed_roles = ['kitchen_manager', 'transport_manager', 'cleaning_manager'];
if (!in_array($_SESSION['role'], $allowed_roles)) {
    die('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['status'])) {
    $inventoryId = $_POST['id'];
    $newStatus = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE assigned_inventory SET status = :status WHERE id = :id");
    $stmt->execute([
        ':status' => $newStatus,
        ':id' => $inventoryId
    ]);

    header("Location: view_assigned_inventory.php?updated=1");
    exit();
} else {
    // Invalid request
    header("Location: view_assigned_inventory.php?error=1");
    exit();
}
