<div class="main-header">
  <div class="main-header-logo">
    <!-- Logo Header -->
    <div style="background-color: #704130 !important;" class="logo-header" data-background-color="dark">
      <a href="index.html" class="logo">
        <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
    <!-- End Logo Header -->
  </div>
  <!-- Navbar Header -->
  <nav style="background-color: #704130 !important; border-left: 1px solid white !important;" class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
      <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">

      </nav>

      <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
        <!-- <li class="nav-item topbar-icon dropdown hidden-caret">
          <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bell"></i>
            <span class="notification">4</span>
          </a>
          <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
            <li>
              <div class="dropdown-title">
                You have 4 new notification
              </div>
            </li>
            <li>
              <div class="notif-scroll scrollbar-outer">
                <div class="notif-center">
                  <a href="#">
                    <div class="notif-icon notif-primary">
                      <i class="fa fa-user-plus"></i>
                    </div>
                    <div class="notif-content">
                      <span class="block"> New user registered </span>
                      <span class="time">5 minutes ago</span>
                    </div>
                  </a>
                  <a href="#">
                    <div class="notif-icon notif-success">
                      <i class="fa fa-comment"></i>
                    </div>
                    <div class="notif-content">
                      <span class="block">
                        Rahmad commented on Admin
                      </span>
                      <span class="time">12 minutes ago</span>
                    </div>
                  </a>
                  <a href="#">
                    <div class="notif-img">
                      <img src="assets/img/profile2.jpg" alt="Img Profile" />
                    </div>
                    <div class="notif-content">
                      <span class="block">
                        Reza send messages to you
                      </span>
                      <span class="time">12 minutes ago</span>
                    </div>
                  </a>
                  <a href="#">
                    <div class="notif-icon notif-danger">
                      <i class="fa fa-heart"></i>
                    </div>
                    <div class="notif-content">
                      <span class="block"> Farrah liked Admin </span>
                      <span class="time">17 minutes ago</span>
                    </div>
                  </a>
                </div>
              </div>
            </li>
            <li>
              <a class="see-all" href="javascript:void(0);">See all notifications<i class="fa fa-angle-right"></i>
              </a>
            </li>
          </ul>
        </li> -->



        <li class="nav-item topbar-user dropdown hidden-caret">
          <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
            <span class="profile-username">
              <span style="color: white !important;" class="op-7">Hi,</span>
              <span style="color: white !important;" class="fw-bold"><?php echo $admin['fullname'] ?></span>
            </span>
          </a>
          <ul class="dropdown-menu dropdown-user animated fadeIn">
            <div class="dropdown-user-scroll scrollbar-outer">
              <li>
                <div class="user-box">
                  <div class="u-text">
                    <h4><?php echo $admin['fullname'] ?></h4>
                    <p class="text-muted"><?php echo $admin['email'] ?></p>
                  </div>
                </div>
              </li>
              <li>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">Change profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="admin_logout.php">Logout</a>
              </li>
            </div>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
  <!-- End Navbar -->
</div>


<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profileModalLabel">Change Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="update_profile.php">
          <div class="mb-3">
            <label for="fullname" class="form-label">Fullname</label>
            <input style="border: 2px solid grey" type="text" class="form-control" id="fullname" name="fullname" placeholder="Fullname" value="<?php echo htmlspecialchars($admin['fullname']); ?>" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input style="border: 2px solid grey" type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input style="border: 2px solid grey" type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo htmlspecialchars($admin['address']); ?>" required>
          </div>
          <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input style="border: 2px solid grey" type="text" class="form-control" id="contact" name="contact" placeholder="Contact" value="<?php echo htmlspecialchars($admin['contact']); ?>" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input style="border: 2px solid grey" type="password" class="form-control" id="password" name="password" placeholder="Password">
          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input style="border: 2px solid grey" type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
          </div>
          <div class="modal-footer border-0">
            <input type="submit" class="btn btn-primary" value="Save Changes">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>