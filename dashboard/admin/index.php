<?php
// dashboard/admin/index.php
require_once '../../includes/header.php';
require_once '../../includes/sidebars/admin_sidebar.php';
require_once '../../controllers/dashboardcontroller.php';

$dashboard = new dashboardcontroller();
$employeeCount = $dashboard->getEmployeeCount();
$taskCount = $dashboard->getTotalTasks();
$inventoryCount = $dashboard->getTotalInventoryItems();
$promoCount = $dashboard->getPromotionCount();
$reportCount = $dashboard->getReportCount();
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Admin Dashboard</h1>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?= $employeeCount ?></h3>
            <p>Employees</p>
          </div>
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
          <a href="employees.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?= $taskCount ?></h3>
            <p>Total Tasks</p>
          </div>
          <div class="icon">
            <i class="fas fa-tasks"></i>
          </div>
          <a href="../../tasks/task_list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?= $inventoryCount ?></h3>
            <p>Inventory Items</p>
          </div>
          <div class="icon">
            <i class="fas fa-boxes"></i>
          </div>
          <a href="../../inventory/inventory_list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?= $promoCount ?></h3>
            <p>Promotions</p>
          </div>
          <div class="icon">
            <i class="fas fa-tags"></i>
          </div>
          <a href="../../promotions/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3><?= $reportCount ?></h3>
            <p>Reports</p>
          </div>
          <div class="icon">
            <i class="fas fa-chart-line"></i>
          </div>
          <a href="../../reports/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
  </section>
</div>
<?php require_once '../../includes/footer.php'; ?>

<?php
// Similar logic can be applied for other dashboard roles using role-specific controllers or filtered queries
?>
