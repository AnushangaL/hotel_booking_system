<?php
require_once '../../config/database.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list_guests.php');
    exit;
}

// Fetch guest data
$stmt = $pdo->prepare("SELECT * FROM guests WHERE id = ?");
$stmt->execute([$id]);
$guest = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$guest) {
    header('Location: list_guests.php');
    exit;
}

$name = $guest['name'];
$nic = $guest['nic'];
$email = $guest['email'];
$phone = $guest['phone'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $nic = trim($_POST['nic']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (!$name) $errors[] = "Name is required";
    if (!$nic) $errors[] = "NIC is required";
    if (!$email) $errors[] = "Email is required";
    if (!$phone) $errors[] = "Phone is required";

    if (empty($errors)) {
        // Check uniqueness NIC/email excluding current
        $stmt = $pdo->prepare("SELECT id FROM guests WHERE (nic = ? OR email = ?) AND id != ?");
        $stmt->execute([$nic, $email, $id]);
        if ($stmt->fetch()) {
            $errors[] = "NIC or Email already in use by another guest";
        } else {
            $stmt = $pdo->prepare("UPDATE guests SET name = ?, nic = ?, email = ?, phone = ? WHERE id = ?");
            if ($stmt->execute([$name, $nic, $email, $phone, $id])) {
                header('Location: list_guests.php');
                exit;
            } else {
                $errors[] = "Failed to update guest";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Guest</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css" />
</head>
<body>
<div class="container mt-4">
    <h2>Edit Guest</h2>
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
        <button class="btn btn-primary" type="submit">Update Guest</button>
        <a href="list_guests.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
