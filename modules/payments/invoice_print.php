<?php
require_once '../../config/database.php';
require_once '../../includes/auth_check.php';

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$paymentId = $_GET['id'];

// Fetch payment + guest + booking info
$stmt = $pdo->prepare("
    SELECT p.*, g.full_name AS guest_name, g.email, g.phone, b.room_number
    FROM payments p
    LEFT JOIN guests g ON p.guest_id = g.id
    LEFT JOIN bookings b ON p.booking_id = b.id
    WHERE p.id = ?
");
$stmt->execute([$paymentId]);
$payment = $stmt->fetch();

if (!$payment) {
    echo "Payment not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= htmlspecialchars($payment['id']) ?></title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }

        body {
            padding: 20px;
        }

        .invoice-box {
            border: 1px solid #ddd;
            padding: 30px;
        }

        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div class="container invoice-box">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Hotel Invoice</h2>
        </div>
        <div class="col-md-6 text-right">
            <p><strong>Date:</strong> <?= date("F d, Y", strtotime($payment['payment_date'])) ?></p>
            <p><strong>Invoice #</strong> <?= htmlspecialchars($payment['id']) ?></p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <h5>Guest Information</h5>
            <p>
                <?= htmlspecialchars($payment['guest_name']) ?><br>
                <?= htmlspecialchars($payment['email']) ?><br>
                <?= htmlspecialchars($payment['phone']) ?>
            </p>
        </div>
        <div class="col-md-6 text-right">
            <h5>Room & Booking</h5>
            <p>
                Room #: <?= htmlspecialchars($payment['room_number']) ?><br>
                Booking ID: <?= htmlspecialchars($payment['booking_id']) ?>
            </p>
        </div>
    </div>

    <h5>Payment Summary</h5>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Description</th>
                <th class="text-right">Amount (LKR)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= htmlspecialchars($payment['description']) ?></td>
                <td class="text-right"><?= number_format($payment['amount'], 2) ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th class="text-right"><?= number_format($payment['amount'], 2) ?></th>
            </tr>
        </tfoot>
    </table>

    <p><strong>Payment Method:</strong> <?= htmlspecialchars(ucfirst($payment['payment_method'])) ?></p>
    <p><strong>Status:</strong> <span class="badge badge-success">Paid</span></p>

    <div class="text-center no-print mt-4">
        <button onclick="window.print();" class="btn btn-primary">Print Invoice</button>
        <a href="payment_history.php" class="btn btn-secondary">Back to Payment History</a>
    </div>
</div>

</body>
</html>