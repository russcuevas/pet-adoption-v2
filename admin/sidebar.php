<!-- Sidebar -->
<div style="background-color: #F5F7F8 !important;" class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" style="background-color: #704130;">
      <a style="color: white !important;" href="dashboard.php" class="logo">
        <img src="../images/home/pet-logo.png" alt="navbar brand" class="navbar-brand" height="50" />
        PET-KO.
      </a>
      <div class="nav-toggle" style="color: white !important;">
        <button class="btn btn-toggle toggle-sidebar">
          <i style="color: white !important;" class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i style="color: white !important;" class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
    <!-- End Logo Header -->
  </div>
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">
        <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'dashboard.php') echo 'active'; ?>">
          <a href="dashboard.php" class="collapsed" aria-expanded="false">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Components</h4>
        </li>
        <li class="nav-item <?php if (in_array(basename($_SERVER['PHP_SELF']), array('users_management.php', 'admin_management.php'))) echo 'active submenu'; ?>">
          <a data-bs-toggle="collapse" href="#sidebarLayouts" class="<?php if (in_array(basename($_SERVER['PHP_SELF']), array('users_management.php', 'admin_management.php'))) echo 'active'; ?>">
            <i class="fas fa-user-circle"></i>
            <p>Users Management</p>
            <span class="caret"></span>
          </a>
          <div class="collapse <?php if (in_array(basename($_SERVER['PHP_SELF']), array('users_management.php', 'admin_management.php'))) echo 'show'; ?>" id="sidebarLayouts">
            <ul class="nav nav-collapse">
              <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'users_management.php') echo 'active'; ?>">
                <a href="users_management.php">
                  <span class="sub-item">Users</span>
                </a>
              </li>
              <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'admin_management.php') echo 'active'; ?>">
                <a href="admin_management.php">
                  <span class="sub-item">Admin</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'pet_management.php') echo 'active'; ?>">
          <a href="pet_management.php">
            <i class="fas fa-paw"></i>
            <p>Pet Management</p>
          </a>
        </li>

        <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'approval.php') echo 'active'; ?>">
          <a href="approval.php">
            <i class="fas fa-check"></i>
            <p>Pet Approval</p>
          </a>
        </li>

        <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'adoptions.php') echo 'active'; ?>">
          <a href="adoptions.php">
            <i class="fas fa-calendar"></i>
            <p>Adoptions</p>
          </a>
        </li>

        <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'news_announcement.php') echo 'active'; ?>">
          <a href="news_announcement.php">
            <i class="fas fa-bookmark"></i>
            <p>News & Announcement</p>
          </a>
        </li>

        <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'reports.php') echo 'active'; ?>">
          <a href="reports.php">
            <i class="far fa-chart-bar"></i>
            <p>Reports</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
<!-- End Sidebar -->