<?php
require_once '../includes/auth_check.php';
require_once '../config/db.php';
require_once '../controllers/PaymentController.php';

$paymentController = new PaymentController($pdo);

$filters = [
    'from' => $_GET['from'] ?? '',
    'to' => $_GET['to'] ?? '',
    'guest' => $_GET['guest'] ?? '',
    'method' => $_GET['method'] ?? '',
];

$payments = $paymentController->getPaymentHistory($filters);
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Payment History</h1>
    </section>

    <section class="content">
        <form method="get" class="card card-body mb-3">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>From Date</label>
                    <input type="date" name="from" value="<?= htmlspecialchars($filters['from']) ?>" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>To Date</label>
                    <input type="date" name="to" value="<?= htmlspecialchars($filters['to']) ?>" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>Guest Name</label>
                    <input type="text" name="guest" value="<?= htmlspecialchars($filters['guest']) ?>" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>Payment Method</label>
                    <select name="method" class="form-control">
                        <option value="">All</option>
                        <option value="Cash" <?= $filters['method'] == 'Cash' ? 'selected' : '' ?>>Cash</option>
                        <option value="Card" <?= $filters['method'] == 'Card' ? 'selected' : '' ?>>Card</option>
                        <option value="Online" <?= $filters['method'] == 'Online' ? 'selected' : '' ?>>Online</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="export_payments.php?<?= http_build_query($filters) ?>" class="btn btn-success ml-2">Export</a>
            <a href="print_payments.php?<?= http_build_query($filters) ?>" class="btn btn-secondary ml-2" target="_blank">Print</a>
        </form>

        <div class="card">
            <div class="card-header bg-info text-white">
                Filtered Payment Records
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Booking ID</th>
                            <th>Guest</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $index => $payment): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($payment['booking_id']) ?></td>
                                <td><?= htmlspecialchars($payment['guest_name']) ?></td>
                                <td>Rs. <?= number_format($payment['amount'], 2) ?></td>
                                <td><?= htmlspecialchars($payment['method']) ?></td>
                                <td><?= htmlspecialchars($payment['description']) ?></td>
                                <td><?= htmlspecialchars($payment['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($payments)): ?>
                            <tr><td colspan="7" class="text-center">No records found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php include '../includes/footer.php'; ?>
