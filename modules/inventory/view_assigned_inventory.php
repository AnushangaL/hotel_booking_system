<?php
require_once '../../config/database.php';
require_once '../../includes/auth_check.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../controllers/InventoryController.php';

$inventoryController = new InventoryController($pdo);

// Get current user's role and ID
$userRole = $_SESSION['role'];
$userId = $_SESSION['user_id'];

// Fetch assigned inventories
$assignedInventories = $inventoryController->getAssignedInventory($userRole, $userId);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Assigned Inventory</h1>
    </section>

    <section class="content">
        <?php if (isset($_GET['done'])): ?>
            <div class="alert alert-success">Inventory marked as done.</div>
        <?php elseif (isset($_GET['updated'])): ?>
            <div class="alert alert-success">Inventory status updated successfully.</div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger">Something went wrong. Please try again.</div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Assigned By</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($assignedInventories as $inv): ?>
                            <tr>
                                <td><?= htmlspecialchars($inv['id']) ?></td>
                                <td><?= htmlspecialchars($inv['name']) ?></td>
                                <td><?= htmlspecialchars($inv['quantity']) ?></td>
                                <td><?= htmlspecialchars($inv['assigned_by_name']) ?></td>
                                <td>
                                    <span class="badge 
                                        <?= $inv['status'] === 'pending' ? 'badge-warning' : ($inv['status'] === 'in_use' ? 'badge-info' : ($inv['status'] === 'returned' ? 'badge-secondary' : 'badge-success')) ?>">
                                        <?= ucfirst($inv['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (in_array($userRole, ['kitchen_manager', 'transport_manager', 'cleaning_manager'])): ?>
                                        <form method="POST" action="update_inventory_status.php" class="form-inline">
                                            <input type="hidden" name="id" value="<?= $inv['id'] ?>">
                                            <select name="status" class="form-control form-control-sm mr-1">
                                                <option value="pending" <?= $inv['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="in_use" <?= $inv['status'] == 'in_use' ? 'selected' : '' ?>>In Use</option>
                                                <option value="returned" <?= $inv['status'] == 'returned' ? 'selected' : '' ?>>Returned</option>
                                                <option value="done" <?= $inv['status'] == 'done' ? 'selected' : '' ?>>Done</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        </form>
                                    <?php elseif ($inv['status'] == 'pending'): ?>
                                        <a href="mark_inventory_done.php?id=<?= $inv['id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Mark as done?');">Mark as Done</a>
                                    <?php else: ?>
                                        <em>N/A</em>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($assignedInventories)): ?>
                            <tr><td colspan="6" class="text-center">No records found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php require_once '../../includes/footer.php'; ?>