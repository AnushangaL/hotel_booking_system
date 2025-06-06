<?php
require_once '../../config/database.php';

$stmt = $pdo->query("SELECT * FROM rooms");
$rooms = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Room List</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Room List</h2>
    <a href="add_room.php" class="btn btn-success mb-3">Add Room</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Room Number</th>
            <th>Room Type</th>
            <th>Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rooms as $room): ?>
            <tr>
                <td><?= htmlspecialchars($room['room_number']) ?></td>
                <td><?= htmlspecialchars($room['room_type']) ?></td>
                <td><?= htmlspecialchars($room['price']) ?></td>
                <td><?= htmlspecialchars($room['status']) ?></td>
                <td>
                    <a href="edit_room.php?id=<?= $room['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="delete_room.php?id=<?= $room['id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this room?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
