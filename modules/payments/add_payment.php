<?php
require_once '../includes/auth_check.php';
require_once '../config/db.php';
require_once '../controllers/PaymentController.php';

$paymentController = new PaymentController($pdo);
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];
    $amount = $_POST['amount'];
    $method = $_POST['method'];
    $description = $_POST['description'];

    if ($paymentController->addPayment($booking_id, $amount, $method, $description)) {
        $message = "Payment recorded successfully.";
    } else {
        $message = "Failed to record payment.";
    }
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Add Payment</h1>
    </section>

    <section class="content">
        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="card card-primary">
            <div class="card-header">Record a New Payment</div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label>Booking ID</label>
                        <input type="text" name="booking_id" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Amount (LKR)</label>
                        <input type="number" name="amount" step="0.01" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Method</label>
                        <select name="method" class="form-control" required>
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                            <option value="Online">Online</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Description (optional)</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Add Payment</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include '../includes/footer.php'; ?>

