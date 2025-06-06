<?php
session_start();
require_once '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = trim($_POST['booking_id'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($booking_id) || empty($password)) {
        $error = "Please enter both Booking ID and Password.";
    } else {
        // Get booking info and guest info by booking ID
        $stmt = $pdo->prepare("
            SELECT g.* FROM bookings b
            JOIN guests g ON b.guest_id = g.id
            WHERE b.booking_id = ?
        ");
        $stmt->execute([$booking_id]);
        $guest = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($guest && password_verify($password, $guest['password'])) {
            // Login success
            $_SESSION['user_id'] = $guest['id'];
            $_SESSION['user_role'] = 'guest';
            $_SESSION['user_name'] = $guest['name'];
            $_SESSION['booking_id'] = $booking_id;

            header("Location: ../dashboard/guest/index.php");
            exit();
        } else {
            $error = "Invalid Booking ID or Password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Guest Login</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/adminlte.min.css" />
</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <b>Hotel</b> Guest Login
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in with your Booking ID</p>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="booking_id" class="form-control" placeholder="Booking ID" required value="<?php echo htmlspecialchars($_POST['booking_id'] ?? '') ?>">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-id-card"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>

        <div class="row">
          <div class="col-8">
            <a href="../auth/guest_register.php">Register new guest</a>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/adminlte.min.js"></script>
</body>
</html>
