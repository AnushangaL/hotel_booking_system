<?php
require_once '../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("INSERT INTO rooms (room_number, room_type, price, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$room_number, $room_type, $price, $status]);

    header("Location: list_rooms.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Room</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Add New Room</h2>
    <form method="POST">
        <div class="form-group">
            <label>Room Number</label>
            <input type="text" name="room_number" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Room Type</label>
            <input type="text" name="room_type" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="available">Available</option>
                <option value="booked">Booked</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Room</button>
    </form>
</div>
</body>
</html>
