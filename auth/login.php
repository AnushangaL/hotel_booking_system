<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter username and password.';
    } else {
        $pdo = getPDO(); // Make sure your database.php defines this function

        $stmt = $pdo->prepare(
            'SELECT u.id, u.username, u.password, r.role_name AS role_name
             FROM users u
             JOIN roles r ON u.role_id = r.id
             WHERE u.username = ?
             LIMIT 1'
        );
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role_name'];
            // Redirect based on role
            switch ($user['role']) {
                case 'admin':
                    header('Location: /dashboard/admin/index.php');
                    break;
                case 'receptionist':
                    header('Location: /dashboard/receptionist/index.php');
                    break;
                case 'transport_manager':
                    header('Location: /dashboard/transport_manager/index.php'); // or  if separate
                    break;
                case 'cleaning_manager':
                    header('Location: /dashboard/cleaning_manager/index.php'); // or 
                    break;
                case 'kitchen_manager':
                    header('Location: /dashboard/kitchen_manager/index.php'); // or 
                    break;
                case 'driver':
                    header('Location: /dashboard/driver/index.php');
                    break;
                case 'cleaner':
                    header('Location: /dashboard/cleaner/index.php');
                    break;
                case 'kitchen_staff':
                    header('Location: /dashboard/kitchen_staff/index.php');
                    break;
                default:
                    header('Location: /dashboard/guest/index.php');
                    break;
            }
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login - Hotel Booking System</title>
    <link rel="stylesheet" href="/assets/css/adminlte.min.css" />
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <style>
        body {
            background: #f4f6f9;
        }
        .login-box {
            margin-top: 80px;
            max-width: 400px;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="login-box">
        <h3 class="text-center mb-4">Hotel Booking System Login</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    class="form-control" 
                    value="<?=htmlspecialchars($_POST['username'] ?? '')?>" 
                    required 
                    autofocus
                >
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    required
                >
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <p class="mt-3 mb-0 text-center">
            Don't have an account? <a href="/register.php">Register here</a>
        </p>
    </div>
</div>

<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/adminlte.min.js"></script>
</body>
</html>
