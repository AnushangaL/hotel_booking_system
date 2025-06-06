<?php
require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';

// Fetch available rooms
$stmt = $pdo->query("SELECT * FROM rooms WHERE status = 'available'");
$rooms = $stmt->fetchAll();

// Handle booking form submission
$successMsg = '';
$errorMsg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $guestName = $_POST['guest_name'];
    $guestEmail = $_POST['guest_email'];
    $guestPhone = $_POST['guest_phone'];
    $roomId = $_POST['room_id'];
    $checkin = $_POST['checkin_date'];
    $checkout = $_POST['checkout_date'];

    // Validate inputs
    if (empty($guestName) || empty($guestEmail) || empty($guestPhone) || empty($roomId) || empty($checkin) || empty($checkout)) {
        $errorMsg = "All fields are required.";
    } else {
        try {
            // Start transaction
            $pdo->beginTransaction();

            // Insert guest
            $guestStmt = $pdo->prepare("INSERT INTO guests (full_name, email, phone) VALUES (?, ?, ?)");
            $guestStmt->execute([$guestName, $guestEmail, $guestPhone]);
            $guestId = $pdo->lastInsertId();

            // Insert booking
            $bookingStmt = $pdo->prepare("INSERT INTO bookings (guest_id, room_id, checkin_date, checkout_date, status) VALUES (?, ?, ?, ?, 'booked')");
            $bookingStmt->execute([$guestId, $roomId, $checkin, $checkout]);

            // Update room status
            $roomStmt = $pdo->prepare("UPDATE rooms SET status = 'booked' WHERE id = ?");
            $roomStmt->execute([$roomId]);

            $pdo->commit();
            $successMsg = "Room booked successfully.";
        } catch (Exception $e) {
            $pdo->rollBack();
            $errorMsg = "Booking failed: " . $e->getMessage();
        }
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Book a Room</h1>
    </section>

    <section class="content">
        <?php if ($successMsg): ?>
            <div class="alert alert-success"><?= $successMsg ?></div>
        <?php endif; ?>
        <?php if ($errorMsg): ?>
            <div class="alert alert-danger"><?= $errorMsg ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="guest_name">Guest Name</label>
                        <input type="text" name="guest_name" id="guest_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="guest_email">Email</label>
                        <input type="email" name="guest_email" id="guest_email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="guest_phone">Phone</label>
                        <input type="text" name="guest_phone" id="guest_phone" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="room_id">Select Room</label>
                        <select name="room_id" id="room_id" class="form-control" required>
                            <option value="">-- Choose Room --</option>
                            <?php foreach ($rooms as $room): ?>
                                <option value="<?= $room['id'] ?>">
                                    Room <?= $room['room_number'] ?> - <?= $room['type'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="checkin_date">Check-in Date</label>
                        <input type="date" name="checkin_date" id="checkin_date" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="checkout_date">Check-out Date</label>
                        <input type="date" name="checkout_date" id="checkout_date" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Book Now</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
