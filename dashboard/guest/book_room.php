<?php
session_start();
require_once '../../config/database.php';  // Adjust path to your DB config

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Guest details from form
    $name = trim($_POST['name'] ?? '');
    $nic = trim($_POST['nic'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Booking details
    $room_id = $_POST['room_id'] ?? '';
    $check_in = $_POST['check_in'] ?? '';
    $check_out = $_POST['check_out'] ?? '';

    // Basic validation
    if (!$name) $errors[] = 'Name is required.';
    if (!$nic) $errors[] = 'NIC is required.';
    if (!$email) $errors[] = 'Email is required.';
    if (!$phone) $errors[] = 'Phone number is required.';
    if (!$password) $errors[] = 'Password is required.';
    if ($password !== $confirm_password) $errors[] = 'Passwords do not match.';
    if (!$room_id) $errors[] = 'Please select a room.';
    if (!$check_in) $errors[] = 'Check-in date is required.';
    if (!$check_out) $errors[] = 'Check-out date is required.';
    if ($check_in >= $check_out) $errors[] = 'Check-out must be after check-in date.';

    // Check room availability (simple example)
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE room_id = ? AND NOT (check_out <= ? OR check_in >= ?)");
        $stmt->execute([$room_id, $check_in, $check_out]);
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            $errors[] = "Room is already booked for selected dates.";
        }
    }

    if (empty($errors)) {
        // Check if guest already exists by NIC
        $stmt = $pdo->prepare("SELECT id FROM guests WHERE nic = ?");
        $stmt->execute([$nic]);
        $guest = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$guest) {
            // Create new guest
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO guests (name, nic, email, phone, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $nic, $email, $phone, $hashed_password]);
            $guest_id = $pdo->lastInsertId();
        } else {
            $guest_id = $guest['id'];
        }

        // Insert booking
        $stmt = $pdo->prepare("INSERT INTO bookings (guest_id, room_id, check_in, check_out, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$guest_id, $room_id, $check_in, $check_out, 'booked']);

        $success = "Booking successful! You can now login with your NIC and password.";
    }
}

// Fetch rooms for dropdown
$stmt = $pdo->query("SELECT id, room_number, room_type FROM rooms WHERE status = 'available'");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Room - Hotel Booking</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Book a Room</h2>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul><?php foreach ($errors as $error) echo "<li>" . htmlspecialchars($error) . "</li>"; ?></ul>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="">

        <h4>Guest Details</h4>

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="nic">NIC</label>
            <input type="text" name="nic" id="nic" class="form-control" required value="<?= htmlspecialchars($_POST['nic'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" name="phone" id="phone" class="form-control" required value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="password">Set Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        </div>

        <h4>Booking Details</h4>

        <div class="form-group">
            <label for="room_id">Select Room</label>
            <select name="room_id" id="room_id" class="form-control" required>
                <option value="">-- Select a room --</option>
                <?php foreach ($rooms as $room): ?>
                    <option value="<?= $room['id'] ?>" <?= (isset($_POST['room_id']) && $_POST['room_id'] == $room['id']) ? 'selected' : '' ?>>
                        Room <?= htmlspecialchars($room['room_number']) ?> - <?= htmlspecialchars($room['room_type']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="check_in">Check-in Date</label>
            <input type="date" name="check_in" id="check_in" class="form-control" required value="<?= htmlspecialchars($_POST['check_in'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="check_out">Check-out Date</label>
            <input type="date" name="check_out" id="check_out" class="form-control" required value="<?= htmlspecialchars($_POST['check_out'] ?? '') ?>">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Book Now</button>
    </form>
</div>

<script src="../../assets/js/jquery.min.js"></script>
<script src="../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
