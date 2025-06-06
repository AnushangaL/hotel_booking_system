<?php
require_once '../../config/database.php';

$name = $nic = $email = $phone = $password = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $nic = trim($_POST['nic']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];

    // Basic validation
    if (!$name) $errors[] = "Name is required";
    if (!$nic) $errors[] = "NIC is required";
    if (!$email) $errors[] = "Email is required";
    if (!$phone) $errors[] = "Phone is required";
    if (!$password) $errors[] = "Password is required";

    if (empty($errors)) {
        // Check if NIC or email exists
        $stmt = $pdo->prepare("SELECT id FROM guests WHERE nic = ? OR email = ?");
        $stmt->execute([$nic, $email]);
        if ($stmt->fetch()) {
            $errors[] = "NIC or Email already exists";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO guests (name, nic, email, phone, password) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$name, $nic, $email, $phone, $hash])) {
                header('Location: list_guests.php');
                exit;
            } else {
                $errors[] = "Failed to add guest";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Guest</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css" />
</head>
<body>
<div class="container mt-4">
    <h2>Add New Guest</h2>
    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul><?php foreach ($errors as $error) echo "<li>$error</li>"; ?></ul>
        </div>
    <?php endif; ?>
    <form method="post" action="">
        <div class="form-group">
            <label>Name</label>
            <input name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required />
        </div>
        <div class="form-group">
            <label>NIC</label>
            <input name="nic" class="form-control" value="<?= htmlspecialchars($nic) ?>" required />
        </div>
        <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required />
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>" required />
        </div>
        <div class="form-group">
            <label>Password</label>
            <input name="password" type="password" class="form-control" required />
        </div>
        <button class="btn btn-success" type="submit">Add Guest</button>
        <a href="list_guests.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
