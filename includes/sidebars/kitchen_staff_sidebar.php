<!-- includes/sidebars/kitchen_manager_sidebar.php -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/dashboard/manager/index.php" class="brand-link">
        <img src="/assets/images/AdminLTELogo.png" alt="Hotel Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Kitchen Manager</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/assets/images/user-kitchen-manager.jpg" class="img-circle elevation-2" alt="Kitchen Manager Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Kitchen Manager') ?></a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="/dashboard/manager/index.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">KITCHEN TASKS</li>

                <li class="nav-item">
                    <a href="/modules/kitchen/assign_cook.php" class="nav-link">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>Assign Cook</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/modules/kitchen/view_kitchen_tasks.php" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>View Kitchen Tasks</p>
                    </a>
                </li>

                <li class="nav-header">COOKS</li>

                <li class="nav-item">
                    <a href="/modules/employees/cook_list.php" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Cook List</p>
                    </a>
                </li>

                <li class="nav-header">REPORTS</li>

                <li class="nav-item">
                    <a href="/reports/kitchen_reports.php" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Kitchen Reports</p>
                    </a>
                </li>

                <li class="nav-header">ACCOUNT</li>

                <li class="nav-item">
                    <a href="/auth/logout.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
