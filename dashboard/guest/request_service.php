<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'guest') {
    header("Location: ../auth/guest_login.php");
    exit();
}

require_once '../../config/database.php'; // Your DB connection file
require_once '../../includes/header.php';
require_once '../../includes/navbar.php';

$user_id = $_SESSION['user_id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_type = $_POST['service_type'] ?? '';
    $details = trim($_POST['details'] ?? '');

    if ($service_type && $details) {
        // Insert guest service request into DB (example table: guest_service_requests)
        $stmt = $pdo->prepare("INSERT INTO guest_service_requests (guest_id, service_type, details, status, created_at) VALUES (?, ?, ?, 'pending', NOW())");
        if ($stmt->execute([$user_id, $service_type, $details])) {
            $message = "Service request submitted successfully.";
        } else {
            $message = "Failed to submit request. Please try again.";
        }
    } else {
        $message = "Please fill all fields.";
    }
}

?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Request a Service</h1>
  </section>

  <section class="content">
    <?php if ($message): ?>
      <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="post" action="">
      <div class="form-group">
        <label for="service_type">Service Type</label>
        <select name="service_type" id="service_type" class="form-control" required>
          <option value="">-- Select Service --</option>
          <option value="food">Food Ordering</option>
          <option value="transport">Transport</option>
          <option value="cleaning">Cleaning</option>
        </select>
      </div>

      <div class="form-group">
        <label for="details">Details / Requests</label>
        <textarea name="details" id="details" class="form-control" rows="4" required></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Submit Request</button>
    </form>
  </section>
</div>

<?php require_once '../../includes/footer.php'; ?>
