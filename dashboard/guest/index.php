<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'guest') {
    header("Location: ../auth/guest_login.php");
    exit();
}

require_once '../../config/database.php';
require_once '../../includes/header.php';
require_once '../../includes/navbar.php';

$user_id = $_SESSION['user_id'];

// Fetch guest booking info
$stmtBooking = $pdo->prepare("SELECT * FROM bookings WHERE guest_id = ? AND status = 'confirmed' LIMIT 1");
$stmtBooking->execute([$user_id]);
$booking = $stmtBooking->fetch(PDO::FETCH_ASSOC);

// Fetch guest payment history
$stmtPayments = $pdo->prepare("SELECT * FROM payments WHERE guest_id = ? ORDER BY payment_date DESC");
$stmtPayments->execute([$user_id]);
$payments = $stmtPayments->fetchAll(PDO::FETCH_ASSOC);

// Fetch guest service requests
$stmtRequests = $pdo->prepare("SELECT * FROM guest_service_requests WHERE guest_id = ? ORDER BY created_at DESC");
$stmtRequests->execute([$user_id]);
$requests = $stmtRequests->fetchAll(PDO::FETCH_ASSOC);

// Fetch food menu example
$stmtFoodMenu = $pdo->query("SELECT * FROM food_menu ORDER BY name ASC");
$foodMenu = $stmtFoodMenu->fetchAll(PDO::FETCH_ASSOC);

// Fetch trip menu example (transport options)
$stmtTripMenu = $pdo->query("SELECT * FROM transport_services ORDER BY name ASC");
$tripMenu = $stmtTripMenu->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Guest Dashboard</h1>
  </section>

  <section class="content">

    <h3>Your Booking</h3>
    <?php if ($booking): ?>
      <ul>
        <li>Room: <?php echo htmlspecialchars($booking['room_number']); ?></li>
        <li>Check-in: <?php echo htmlspecialchars($booking['check_in']); ?></li>
        <li>Check-out: <?php echo htmlspecialchars($booking['check_out']); ?></li>
        <li>Status: <?php echo htmlspecialchars($booking['status']); ?></li>
      </ul>
    <?php else: ?>
      <p>No confirmed bookings found.</p>
    <?php endif; ?>

    <h3>Service Requests</h3>
    <?php if (count($requests) > 0): ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Service Type</th>
            <th>Details</th>
            <th>Status</th>
            <th>Requested At</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($requests as $req): ?>
          <tr>
            <td><?php echo htmlspecialchars(ucfirst($req['service_type'])); ?></td>
            <td><?php echo htmlspecialchars($req['details']); ?></td>
            <td><?php echo htmlspecialchars($req['status']); ?></td>
            <td><?php echo htmlspecialchars($req['created_at']); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No service requests made yet.</p>
    <?php endif; ?>

    <h3>Payments</h3>
    <?php if (count($payments) > 0): ?>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Payment Date</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($payments as $pay): ?>
          <tr>
            <td><?php echo htmlspecialchars($pay['payment_date']); ?></td>
            <td><?php echo htmlspecialchars(number_format($pay['amount'], 2)); ?></td>
            <td><?php echo htmlspecialchars($pay['method']); ?></td>
            <td><?php echo htmlspecialchars($pay['status']); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No payments found.</p>
    <?php endif; ?>

    <h3>Food Menu</h3>
    <?php if ($foodMenu): ?>
      <ul>
        <?php foreach ($foodMenu as $food): ?>
          <li><?php echo htmlspecialchars($food['name']) . " - $" . number_format($food['price'], 2); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No food items available.</p>
    <?php endif; ?>

    <h3>Trip Menu (Transport Options)</h3>
    <?php if ($tripMenu): ?>
      <ul>
        <?php foreach ($tripMenu as $trip): ?>
          <li><?php echo htmlspecialchars($trip['name']) . " - $" . number_format($trip['price'], 2); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No transport services available.</p>
    <?php endif; ?>

  </section>
</div>

<?php require_once '../../includes/footer.php'; ?>
