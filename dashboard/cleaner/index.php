<?php
define('ALLOWED_ROLES', ['admin', 'manager']);  // example allowed roles for this page
require_once __DIR__ . '/../includes/auth_check.php';
?>

<?php
// dashboard/admin/index.php
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Admin Dashboard</h1>
  </section>
  <section class="content">
    <div class="row">
      <!-- Employees -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>5</h3>
            <p>Employees</p>
          </div>
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
          <a href="employees.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- Promotions -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>3</h3>
            <p>Active Promotions</p>
          </div>
          <div class="icon">
            <i class="fas fa-tags"></i>
          </div>
          <a href="../../promotions/index.php" class="small-box-footer">Manage Promotions <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
  </section>
</div>
<?php require_once '../../includes/footer.php'; ?>