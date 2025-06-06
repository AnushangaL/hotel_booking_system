<?php
require_once '../../config/database.php';

$errors = [];

// Fetch guests and rooms for dropdowns
$guests = $pdo->query("SELECT id, name FROM guests ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$rooms = $pdo->query("SELECT id, room_number, room_type FROM rooms WHERE status = 'available' ORDER BY room_number")->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $guest_id = $_POST['guest_id'];
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    // Validate input
    if (!$guest_id || !$room_id || !$check_in || !$check_out) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        // Check for room availability in the selected dates
        $stmt = $pdo->prepare("SELECT * FROM bookings WHERE room_id = ? AND (check_in <= ? AND check_out >= ?)");
        $stmt->execute([$room_id, $check_out, $check_in]);
        if ($stmt->fetch()) {
            $errors[] = "This room is already booked during the selected dates.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO bookings (guest_id, room_id, check_in, check_out) VALUES (?, ?, ?, ?)");
            $stmt->execute([$guest_id, $room_id, $check_in, $check_out]);

            // Optional: mark room as temporarily unavailable
            $pdo->prepare("UPDATE rooms SET status = 'booked' WHERE id = ?")->execute([$room_id]);

            header("Location: list_bookings.php?success=1");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Booking</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Add New Booking</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?= implode("<br>", $errors) ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Guest</label>
            <select name="guest_id" class="form-control" required>
                <option value="">-- Select Guest --</option>
                <?php foreach ($guests as $guest): ?>
                    <option value="<?= $guest['id'] ?>"><?= htmlspecialchars($guest['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Room</label>
            <select name="room_id" class="form-control" required>
                <option value="">-- Select Room --</option>
                <?php foreach ($rooms as $room): ?>
                    <option value="<?= $room['id'] ?>">
                        Room <?= htmlspecialchars($room['room_number']) ?> (<?= htmlspecialchars($room['room_type']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Check-in Date</label>
            <input type="date" name="check_in" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Check-out Date</label>
            <input type="date" name="check_out" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Book Room</button>
        <a href="list_bookings.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
