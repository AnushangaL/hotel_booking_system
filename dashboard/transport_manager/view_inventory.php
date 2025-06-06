<?php
// view_inventory.php
session_start();
require_once '../config/db.php';
require_once '../auth/check.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['transport_manager', 'cleaning_manager', 'kitchen_manager'])) {
    header("Location: ../auth/login.php");
    exit();
}

$managerRole = $_SESSION['role'];

try {
    $stmt = $pdo->prepare("SELECT * FROM inventory WHERE assigned_role = :role");
    $stmt->execute(['role' => $managerRole]);
    $inventoryItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching inventory: " . $e->getMessage());
}

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Your Assigned Inventory</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php if (count($inventoryItems) > 0): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Assigned To</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inventoryItems as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['item_name']) ?></td>
                                    <td><?= htmlspecialchars($item['assigned_to']) ?></td>
                                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                                    <td><?= htmlspecialchars($item['status']) ?></td>
                                    <td>
                                        <?php if ($item['status'] !== 'done'): ?>
                                            <a href="mark_inventory_done.php?id=<?= $item['id'] ?>" class="btn btn-success btn-sm">Mark as Done</a>
                                        <?php else: ?>
                                            <span class="badge badge-success">Completed</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No inventory items assigned to you yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
<?php require_once '../includes/footer.php'; ?>
