<?php
define('ALLOWED_ROLES', ['admin', 'kitchen_manager']);  // example allowed roles for this page
require_once __DIR__ . '/../includes/auth_check.php';
?>

<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'kitchen_manager') {
    header('Location: /auth/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Kitchen Manager Dashboard</title>
    <link rel="stylesheet" href="/assets/css/adminlte.min.css" />
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
</head>
<bod class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <?php include __DIR__ . '/../../includes/navbar.php'; ?>

    <!-- Sidebar -->
    <?php include __DIR__ . '/../../includes/sidebars/manager_sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper p-3">
        <h1>Welcome, Kitchen Manager <?=htmlspecialchars($_SESSION['username'])?></h1>
        <p>This is your dashboard.</p>
    </div>

<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <!-- Kitchen Tasks -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>7</h3>
            <p>Pending Kitchen Tasks</p>
          </div>
          <div class="icon">
            <i class="fas fa-utensils"></i>
          </div>
          <a href="../../inventory/assign_Task.php" class="small-box-footer">Assign Kitchen Task <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>

      <!-- Assign Inventory Card -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>Assign</h3>
            <p>Assign Inventory</p>
          </div>
          <div class="icon">
            <i class="fas fa-plus-square"></i>
          </div>
          <a href="../../inventory/assign_inventory.php" class="small-box-footer">Assign Now <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <!-- View Inventory Card -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>View</h3>
            <p>Inventory List</p>
          </div>
          <div class="icon">
            <i class="fas fa-list"></i>
          </div>
          <a href="../../inventory/inventory_list.php" class="small-box-footer">View Inventory <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once '../../includes/footer.php'; ?>

<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/adminlte.min.js"></script>
</body>
</html>
