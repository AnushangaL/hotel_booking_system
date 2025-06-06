<?php
require_once '../../config/database.php';

$booking_id = $_GET['id'] ?? null;

if (!$booking_id) {
    die("Booking ID not provided.");
}

$stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->execute([$booking_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    die("Booking not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->execute([$booking_id]);
    header("Location: list_bookings.php?deleted=1");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Booking</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="card border-danger">
        <div class="card-header bg-danger text-white">
            Confirm Deletion
        </div>
        <div class="card-body">
            <p>Are you sure you want to delete the booking for:</p>
            <ul>
                <li><strong>Booking ID:</strong> <?= $booking['id'] ?></li>
                <li><strong>Guest ID:</strong> <?= $booking['guest_id'] ?></li>
                <li><strong>Room ID:</strong> <?= $booking['room_id'] ?></li>
                <li><strong>Check-in:</strong> <?= $booking['check_in'] ?></li>
                <li><strong>Check-out:</strong> <?= $booking['check_out'] ?></li>
            </ul>

            <form method="POST">
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                <a href="list_bookings.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
