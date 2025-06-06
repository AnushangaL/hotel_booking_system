<?php
require_once '../../config/database.php';
require_once '../../includes/auth_check.php';
require_once '../../controllers/InventoryController.php';

$inventoryController = new InventoryController($pdo);

// Make sure the ID is present
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Try to delete and redirect
    if ($inventoryController-> deleteinventory($id)) {
        header("Location: inventory_list.php?success=deleted");
        exit();
    } else {
        echo "Failed to delete inventory item.";
    }
} else {
    header("Location: inventory_list.php");
    exit();
}
