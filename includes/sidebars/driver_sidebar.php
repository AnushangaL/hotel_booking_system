<?php
// Driver Sidebar - styled with AdminLTE (Bootstrap 4)
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/dashboard/driver/index.php" class="brand-link">
    <img src="/assets/images/logo.png" alt="Hotel Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Hotel Desk</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- User Panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="/assets/images/driver.png" class="img-circle elevation-2" alt="Driver Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Driver</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <li class="nav-item">
          <a href="/dashboard/driver/index.php" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/services/transport/assigned_trips.php" class="nav-link">
            <i class="nav-icon fas fa-car"></i>
            <p>Assigned Trips</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/services/transport/report_issue.php" class="nav-link">
            <i class="nav-icon fas fa-exclamation-triangle"></i>
            <p>Report Issue</p>
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
