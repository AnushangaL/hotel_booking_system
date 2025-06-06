<?php
require_once '../../config/database.php';
require_once '../../includes/auth_check.php';
require_once '../../controllers/InventoryController.php';
require_once '../../controllers/' . $_SESSION['role'] . '/InventoryController.php';

$inventoryController = new InventoryController($pdo);

// Check if ID is set
if (!isset($_GET['id'])) {
    header("Location: inventory_list.php");
    exit();
}

$id = $_GET['id'];
$item = $inventoryController->getInventoryById($id);

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $assigned_to = $_POST['assigned_to'];

    if ($inventoryController->updateInventory($id, $name, $quantity, $assigned_to)) {
        header("Location: inventory_list.php?success=updated");
        exit();
    } else {
        $error = "Failed to update inventory.";
    }
}
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>
<?php include '../../includes/sidebars/<?= $_SESSION['$role'] ?>_sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Inventory</h1>
    </section>

    <section class="content">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Item Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($item['name']) ?>" required>
            </div>
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" class="form-control" value="<?= $item['quantity'] ?>" required>
            </div>
            <div class="form-group">
                <label>Assign to Employee (Employee ID)</label>
                <input type="text" name="assigned_to" class="form-control" value="<?= $item['assigned_to'] ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Inventory</button>
        </form>
    </section>
</div>

<?php include '../../includes/footer.php'; ?>
