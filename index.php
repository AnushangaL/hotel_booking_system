<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hotel Booking System</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="text-center">
        <h1 class="mb-4">Welcome to the Hotel Booking System</h1>
        <?php if (isset($_SESSION['username'])): ?>
            <p class="lead">Hello, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
            <a href="dashboard/<?php echo $_SESSION['role']; ?>/index.php" class="btn btn-primary">Go to Dashboard</a>
            <a href="auth/logout.php" class="btn btn-danger">Logout</a>
        <?php else: ?>
            <a href="auth/login.php" class="btn btn-primary me-2">Login</a>
            <a href="auth/register.php" class="btn btn-success">Register</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
