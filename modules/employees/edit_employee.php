<?php
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../config/db.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->execute([$id]);
$employee = $stmt->fetch();
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit Employee</h1>
  </section>
  <section class="content">
    <form action="update_employee.php" method="POST">
      <input type="hidden" name="id" value="<?= $employee['id'] ?>">
      <div class="form-group">
        <label>Name:</label>
        <input type="text" name="name" class="form-control" value="<?= $employee['name'] ?>" required>
      </div>
      <div class="form-group">
        <label>Role:</label>
        <select name="role" class="form-control">
          <option value="receptionist" <?= $employee['role'] == 'receptionist' ? 'selected' : '' ?>>Receptionist</option>
          <option value="transport_manager" <?= $employee['role'] == 'transport_manager' ? 'selected' : '' ?>>Transport Manager</option>
          <option value="cleaning_manager" <?= $employee['role'] == 'cleaning_manager' ? 'selected' : '' ?>>Cleaning Manager</option>
          <option value="kitchen_manager" <?= $employee['role'] == 'kitchen_manager' ? 'selected' : '' ?>>Kitchen Manager</option>
          <option value="driver" <?= $employee['role'] == 'driver' ? 'selected' : '' ?>>Driver</option>
          <option value="cleaner" <?= $employee['role'] == 'cleaner' ? 'selected' : '' ?>>Cleaner</option>
        </select>
      </div>
      <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" value="<?= $employee['email'] ?>" required>
      </div>
      <button type="submit" class="btn btn-success">Update</button>
    </form>
  </section>
</div>
<?php require_once '../includes/footer.php'; ?>