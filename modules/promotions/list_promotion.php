<?php
require_once '../../config/db.php';
require_once '../../auth/auth_check.php';
include '../../includes/header.php';
include '../../includes/sidebar.php';

$stmt = $pdo->query("SELECT * FROM promotions ORDER BY id DESC");
$promotions = $stmt->fetchAll();
?>

<div class="content-wrapper p-4">
    <h2>Promotion List</h2>
    <a href="add_promotion.php" class="btn btn-primary mb-3">Add Promotion</a>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Promotion added!</div>
    <?php elseif (isset($_GET['updated'])): ?>
        <div class="alert alert-success">Promotion updated!</div>
    <?php elseif (isset($_GET['deleted'])): ?>
        <div class="alert alert-danger">Promotion deleted!</div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Code</th>
                <th>Discount (%)</th>
                <th>Start</th>
                <th>End</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($promotions as $i => $promo): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $promo['title'] ?></td>
                    <td><?= $promo['promo_code'] ?></td>
                    <td><?= $promo['discount_percent'] ?></td>
                    <td><?= $promo['start_date'] ?></td>
                    <td><?= $promo['end_date'] ?></td>
                    <td>
                        <a href="edit_promotion.php?id=<?= $promo['id'] ?>" class="btn btn-sm btn-info">Edit</a>
                        <a href="delete_promotion.php?id=<?= $promo['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
