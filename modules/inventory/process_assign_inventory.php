<?php
require_once '../../config/database.php';
require_once '../../includes/auth_check.php';
require_once '../../controllers/InventoryController.php';

$inventoryController = new InventoryController($pdo);

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemName     = $_POST['name'] ?? '';
    $quantity     = $_POST['quantity'] ?? 0;
    $assignedTo   = $_POST['assigned_to'] ?? null;
    $assignedBy   = $_SESSION['user_id'];
    $department   = $_SESSION['role']; // kitchen_manager, cleaning_manager, etc.

    if (!empty($itemName) && $quantity > 0) {
        $success = $inventoryController->assignInventory($itemName, $quantity, $assignedTo, $assignedBy, $department);
        
        if ($success) {
            header('Location: inventory_list.php?success=1');
            exit;
        } else {
            header('Location: assign_inventory.php?error=1');
            exit;
        }
    } else {
        header('Location: assign_inventory.php?error=invalid');
        exit;
    }
} else {
    // Not allowed
    header('Location: inventory_list.php');
    exit;
}
