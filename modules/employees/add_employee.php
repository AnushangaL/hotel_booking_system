<?php
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Add New Employee</h1>
  </section>
  <section class="content">
    <form action="save_employee.php" method="POST">
      <div class="form-group">
        <label>Name:</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Role:</label>
        <select name="role" class="form-control">
          <option value="receptionist">Receptionist</option>
          <option value="transport_manager">Transport Manager</option>
          <option value="cleaning_manager">Cleaning Manager</option>
          <option value="kitchen_manager">Kitchen Manager</option>
          <option value="driver">Driver</option>
          <option value="cleaner">Cleaner</option>
        </select>
      </div>
      <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success">Save</button>
    </form>
  </section>
</div>
<?php require_once '../includes/footer.php'; ?>