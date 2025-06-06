<?php
define('ALLOWED_ROLES', ['admin', 'transport_manager']);  // example allowed roles for this page
require_once __DIR__ . '/../includes/auth_check.php';
?>

<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'transport_manager') {
    header('Location: /auth/login.php');
    exit;
}
?>
<?php
// dashboard/transport_manager/index.php
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../controller/DashboardController.php';

$data = getTransportManagerDashboardData();
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Transport Manager Dashboard</h1>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?= $data['assignedTasks'] ?></h3>
            <p>Assigned Transport Tasks</p>
          </div>
          <div class="icon">
            <i class="fas fa-truck"></i>
          </div>
          <a href="../../tasks/view_tasks.php" class="small-box-footer">View Tasks <i class="fas fa-arrow-circle-right"></i></a>
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


    </div>
  </section>
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
