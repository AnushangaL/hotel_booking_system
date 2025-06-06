<?php
require_once '../../config/db.php';
require_once '../../auth/auth_check.php';
include '../../includes/header.php';
include '../../includes/sidebar.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM promotions WHERE id = ?");
$stmt->execute([$id]);
$promo = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $code = $_POST['code'];
    $discount = $_POST['discount'];
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];

    $stmt = $pdo->prepare("UPDATE promotions SET title=?, promo_code=?, discount_percent=?, start_date=?, end_date=? WHERE id=?");
    $stmt->execute([$title, $code, $discount, $start, $end, $id]);
    header("Location: promotion_list.php?updated=1");
}
?>

<div class="content-wrapper p-4">
    <h2>Edit Promotion</h2>
    <form method="post">
        <div class="form-group">
            <label>Promotion Title</label>
            <input type="text" name="title" class="form-control" value="<?= $promo['title'] ?>" required>
        </div>
        <div class="form-group">
            <label>Promo Code</label>
            <input type="text" name="code" class="form-control" value="<?= $promo['promo_code'] ?>" required>
        </div>
        <div class="form-group">
            <label>Discount (%)</label>
            <input type="number" name="discount" class="form-control" value="<?= $promo['discount_percent'] ?>" required>
        </div>
        <div class="form-group">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" value="<?= $promo['start_date'] ?>" required>
        </div>
        <div class="form-group">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" value="<?= $promo['end_date'] ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Update Promotion</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
