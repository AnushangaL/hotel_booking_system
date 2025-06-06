<?php
// dashboard/receptionist/index.php
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../controller/DashboardController.php';

$data = getReceptionistDashboardData();
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Receptionist Dashboard</h1>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?= $data['bookingsToday'] ?></h3>
            <p>Today's Bookings</p>
          </div>
          <div class="icon">
            <i class="fas fa-calendar-check"></i>
          </div>
          <a href="../../bookings/list_bookings.php" class="small-box-footer">View Bookings <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
  </section>
</div>
<?php require_once '../../includes/footer.php'; ?>

