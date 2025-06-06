<?php
require_once '../../config/database.php';

// Fetch all guests
$stmt = $pdo->query("SELECT * FROM guests ORDER BY id DESC");
$guests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Guests List</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css" />
</head>
<body>
<div class="container mt-4">
    <h2>Guests List</h2>
    <a href="add_guest.php" class="btn btn-primary mb-3">Add New Guest</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>NIC</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($guests as $guest): ?>
            <tr>
                <td><?= htmlspecialchars($guest['id']) ?></td>
                <td><?= htmlspecialchars($guest['name']) ?></td>
                <td><?= htmlspecialchars($guest['nic']) ?></td>
                <td><?= htmlspecialchars($guest['email']) ?></td>
                <td><?= htmlspecialchars($guest['phone']) ?></td>
                <td><?= htmlspecialchars($guest['created_at']) ?></td>
                <td>
                    <a href="edit_guest.php?id=<?= $guest['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete_guest.php?id=<?= $guest['id'] ?>" onclick="return confirm('Delete this guest?')" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($guests)) : ?>
            <tr><td colspan="7" class="text-center">No guests found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
