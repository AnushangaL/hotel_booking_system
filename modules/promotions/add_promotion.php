<?php
require_once '../../config/db.php';
require_once '../../auth/auth_check.php';
include '../../includes/header.php';
include '../../includes/sidebar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $code = $_POST['code'];
    $discount = $_POST['discount'];
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];

    $stmt = $pdo->prepare("INSERT INTO promotions (title, promo_code, discount_percent, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $code, $discount, $start, $end]);
    header("Location: promotion_list.php?success=1");
}
?>

<div class="content-wrapper p-4">
    <h2>Add Promotion</h2>
    <form method="post">
        <div class="form-group">
            <label>Promotion Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Promo Code</label>
            <input type="text" name="code" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Discount (%)</label>
            <input type="number" name="discount" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Promotion</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
