<?php
require_once '../config/db.php';
$stmt = $pdo->query("SELECT * FROM employees");
$employees = $stmt->fetchAll();
?>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Role</th>
      <th>Email</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($employees as $emp): ?>
      <tr>
        <td><?= $emp['id'] ?></td>
        <td><?= $emp['name'] ?></td>
        <td><?= ucfirst(str_replace('_', ' ', $emp['role'])) ?></td>
        <td><?= $emp['email'] ?></td>
        <td>
          <a href="edit_employee.php?id=<?= $emp['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="delete_employee.php?id=<?= $emp['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>