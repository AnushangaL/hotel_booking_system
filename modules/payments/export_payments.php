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

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=payment_history.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Guest Name', 'Amount', 'Method', 'Date']);

foreach ($payments as $row) {
    fputcsv($output, [$row['id'], $row['guest_name'], $row['amount'], $row['method'], $row['payment_date']]);
}
fclose($output);
exit;
