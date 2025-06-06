<?php
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

<!DOCTYPE html>
<html>
<head>
    <title>Payment Report</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body { padding: 20px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <h2>Payment History Report</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Guest Name</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $row): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['guest_name']) ?></td>
                    <td><?= $row['amount'] ?></td>
                    <td><?= $row['method'] ?></td>
                    <td><?= $row['payment_date'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button class="btn btn-primary no-print" onclick="window.print()">Print</button>
</body>
</html>
