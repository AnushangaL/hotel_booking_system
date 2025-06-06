<?php
require_once '../../config/database.php';

$booking_id = $_GET['id'] ?? null;
if (!$booking_id) {
    die("Booking ID is missing.");
}

$stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->execute([$booking_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    die("Booking not found.");
}

$guests = $pdo->query("SELECT id, name FROM guests")->fetchAll(PDO::FETCH_ASSOC);
$rooms = $pdo->query("SELECT id, room_number, room_type FROM rooms")->fetchAll(PDO::FETCH_ASSOC);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $guest_id = $_POST['guest_id'];
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    if (!$guest_id || !$room_id || !$check_in || !$check_out) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE bookings SET guest_id = ?, room_id = ?, check_in = ?, check_out = ? WHERE id = ?");
        $stmt->execute([$guest_id, $room_id, $check_in, $check_out, $booking_id]);
        header("Location: list_bookings.php?updated=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Booking</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Edit Booking</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger"><?= implode("<br>", $errors) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Guest</label>
            <select name="guest_id" class="form-control" required>
                <?php foreach ($guests as $guest): ?>
                    <option value="<?= $guest['id'] ?>" <?= $guest['id'] == $booking['guest_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($guest['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Room</label>
            <select name="room_id" class="form-control" required>
                <?php foreach ($rooms as $room): ?>
                    <option value="<?= $room['id'] ?>" <?= $room['id'] == $booking['room_id'] ? 'selected' : '' ?>>
                        Room <?= htmlspecialchars($room['room_number']) ?> (<?= $room['room_type'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Check-in</label>
            <input type="date" name="check_in" class="form-control" value="<?= $booking['check_in'] ?>" required>
        </div>


        <div class="form-group">
            <label>Check-out</label>
            <input type="date" name="check_out" class="form-control" value="<?= $booking['check_out'] ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Booking</button>
        <a href="list_bookings.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
