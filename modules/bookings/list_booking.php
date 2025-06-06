<?php
require_once '../../config/database.php';

// Fetch bookings with guest and room info
$sql = "SELECT b.id, g.name AS guest_name, r.room_number, b.check_in, b.check_out, b.status
        FROM bookings b
        JOIN guests g ON b.guest_id = g.id
        JOIN rooms r ON b.room_id = r.id
        ORDER BY b.id DESC";
$stmt = $pdo->query($sql);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bookings List</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css" />
</head>
<body>
<div class="container mt-4">
    <h2>Bookings List</h2>
    <a href="add_booking.php" class="btn btn-primary mb-3">Add New Booking</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Guest</th>
                <th>Room Number</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
            <tr>
                <td><?= htmlspecialchars($booking['id']) ?></td>
                <td><?= htmlspecialchars($booking['guest_name']) ?></td>
                <td><?= htmlspecialchars($booking['room_number']) ?></td>
                <td><?= htmlspecialchars($booking['check_in']) ?></td>
                <td><?= htmlspecialchars($booking['check_out']) ?></td>
                <td><?= htmlspecialchars($booking['status']) ?></td>
                <td>
                    <a href="edit_booking.php?id=<?= $booking['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete_booking.php?id=<?= $booking['id'] ?>" onclick="return confirm('Delete this booking?')" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($bookings)) : ?>
            <tr><td colspan="7" class="text-center">No bookings found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
