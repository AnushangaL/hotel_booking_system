<?php
// Receptionist Sidebar - styled with AdminLTE (Bootstrap 4)
?>
<html><head>
    <!-- Font Awesome -->
<link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
<!-- AdminLTE -->
<link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
<!-- Optional: custom sidebar styling -->
<style>
  .brand-link {
    font-size: 1.1rem;
  }
</</style></head>
<body>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/dashboard/receptionist/index.php" class="brand-link">
    <img src="/assets/images/logo.png" alt="Hotel Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Hotel Desk</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- User Panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="/assets/images/user.png" class="img-circle elevation-2" alt="Receptionist Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Receptionist</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <li class="nav-item">
          <a href="/dashboard/receptionist/index.php" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/rooms/book_room.php" class="nav-link">
            <i class="nav-icon fas fa-bed"></i>
            <p>Book Rooms</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/rooms/list_rooms.php" class="nav-link">
            <i class="nav-icon fas fa-list"></i>
            <p>Room List</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/services/food_ordering/list_orders.php" class="nav-link">
            <i class="nav-icon fas fa-utensils"></i>
            <p>Food Orders</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/payments/payment_history.php" class="nav-link">
            <i class="nav-icon fas fa-file-invoice-dollar"></i>
            <p>Payments</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/auth/logout.php" class="nav-link text-danger">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>

<!-- jQuery -->
<script src="/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/dist/js/adminlte.min.js"></script>


</body>
</html>