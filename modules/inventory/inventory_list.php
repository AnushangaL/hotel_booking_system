<?php
include_once '../../includes/header.php';
include_once '../../includes/auth_check.php';
include_once '../../config/database.php';

?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Inventory List</h1>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>Item</th>
              <th>Assigned To</th>
              <th>Quantity</th>
              <th>Status</th>
              <?php if ($_SESSION['role'] != 'employee'): ?>
                <th>Actions</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <!-- PHP Loop for Inventory Records -->
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<?php include_once '../../includes/footer.php'; ?>
