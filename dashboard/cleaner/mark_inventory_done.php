<?php
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../config/db.php';
require_once '../../auth/auth_check.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid inventory ID.');window.history.back();</script>";
    exit;
}

$inventoryId = $_GET['id'];
$userId = $_SESSION['user_id'];
$userRole = $_SESSION['role'];

// Determine department from role
$department = '';
switch ($userRole) {
    case 'cleaner':
        $department = 'cleaning';
        break;
    case 'driver':
        $department = 'transport';
        break;
    case 'kitchen_staff':
        $department = 'kitchen';
        break;
    default:
        die("Unauthorized access.");
}

// Check if this inventory belongs to this user
$stmt = $pdo->prepare("SELECT * FROM inventories WHERE id = ? AND assigned_to = ? AND department = ?");
$stmt->execute([$inventoryId, $userId, $department]);
$task = $stmt->fetch();

if (!$task) {
    echo "<script>alert('You are not authorized to mark this inventory.');window.history.back();</script>";
    exit;
}

// Update status to done
$update = $pdo->prepare("UPDATE inventories SET status = 'done' WHERE id = ?");
$update->execute([$inventoryId]);

echo "<script>alert('Inventory marked as done.');window.location.href='inventory_list.php';</script>";
?>
