<?php

// INCLUDING CONNECTION TO DATABASE
include '../database/connection.php';

// SESSION IF NOT LOGIN YOU CANT GO TO DIRECT PAGE
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
  header('location:admin_login.php');
}

// GET ADMIN
$admin_id = $_SESSION['admin_id'];
$fetch_admin = $conn->prepare("SELECT * FROM `tbl_admin` WHERE admin_id = ?");
$fetch_admin->execute([$admin_id]);
$admin = $fetch_admin->fetch(PDO::FETCH_ASSOC);

// GET THE USERS
$get_total_users = "SELECT COUNT(*) AS total_users FROM `tbl_users`";
$stmt_total_users = $conn->prepare($get_total_users);
$stmt_total_users->execute();
$result_total_users = $stmt_total_users->fetch(PDO::FETCH_ASSOC);
$total_users = $result_total_users['total_users'];
// END GET TOTAL USERS

// GET THE TOTAL PETS REGISTERED
$get_total_pets_register = "SELECT COUNT(*) AS total_pets FROM `tbl_pets` WHERE pet_status = 'For adoption'";
$stmt_total_pets_register = $conn->prepare($get_total_pets_register);
$stmt_total_pets_register->execute();
$restult_total_pets_register = $stmt_total_pets_register->fetch(PDO::FETCH_ASSOC);
$total_pets = $restult_total_pets_register['total_pets'];
// END GET TOTAL PETS

// GET THE TOTAL PETS APPROVAL
$get_total_pets_approval = "SELECT COUNT(*) AS total_pets_approval FROM `tbl_pets` WHERE pet_status = 'Requesting'";
$stmt_total_pets_approval = $conn->prepare($get_total_pets_approval);
$stmt_total_pets_approval->execute();
$restult_total_pets_approval = $stmt_total_pets_approval->fetch(PDO::FETCH_ASSOC);
$total_pets_approval = $restult_total_pets_approval['total_pets_approval'];
// END GET TOTAL PETS APPROVAL

// GET THE TOTAL REPORTS
$get_total_reports = "SELECT COUNT(*) AS total_reports FROM `tbl_reports`";
$stmt_total_reports = $conn->prepare($get_total_reports);
$stmt_total_reports->execute();
$result_total_reports = $stmt_total_reports->fetch(PDO::FETCH_ASSOC);
$total_reports = $result_total_reports['total_reports'];
// END GET TOTAL REPORTS

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Pet Adoption Management System</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="../images/home/pet-logo.png" type="image/x-icon" />

  <!-- CSS Files -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/plugins.min.css" />
  <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link rel="stylesheet" href="assets/css/demo.css" />
</head>

<body>
  <div class="wrapper">

    <!-- SIDEBAR -->
    <?php include('sidebar.php') ?>
    <!-- END SIDEBAR -->


    <div class="main-panel">

      <!-- HEADER / NAVBAR -->
      <?php include('header.php') ?>
      <!-- END HEADER / NAVBAR -->


      <div class="container">
        <div class="page-inner">
          <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">Dashboard</h3>
            </div>

          </div>
          <div class="row">
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-primary bubble-shadow-small">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Total Users</p>
                        <h4 class="card-title"><?php echo $total_users ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div style="background-color: #704130;" class="icon-big text-center icon-info bubble-shadow-small">
                        <i class="fas fa-user-check"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Total Pet</p>
                        <h4 class="card-title"><?php echo $total_pets ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div style="background-color: #704130;" class="icon-big text-center icon-success bubble-shadow-small">
                        <i class="fas fa-luggage-cart"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Approval Pets</p>
                        <h4 class="card-title"><?php echo $total_pets_approval ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-secondary bubble-shadow-small">
                        <i class="far fa-check-circle"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Reports</p>
                        <h4 class="card-title"><?php echo $total_reports ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Fonts and icons -->
  <script src="assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: {
        families: ["Public Sans:300,400,500,600,700"]
      },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["assets/css/fonts.min.css"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery-3.7.1.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>

  <!-- jQuery Scrollbar -->
  <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

  <!-- Chart JS -->
  <script src="assets/js/plugin/chart.js/chart.min.js"></script>

  <!-- jQuery Sparkline -->
  <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

  <!-- Chart Circle -->
  <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

  <!-- Datatables -->
  <script src="assets/js/plugin/datatables/datatables.min.js"></script>

  <!-- Bootstrap Notify -->
  <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

  <!-- jQuery Vector Maps -->
  <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
  <script src="assets/js/plugin/jsvectormap/world.js"></script>

  <!-- Sweet Alert -->
  <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

  <!-- Kaiadmin JS -->
  <script src="assets/js/kaiadmin.min.js"></script>

  <!-- Kaiadmin DEMO methods, don't include it in your project! -->
  <script src="assets/js/setting-demo.js"></script>
  <script src="assets/js/demo.js"></script>
  <script>
    $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
      type: "line",
      height: "70",
      width: "100%",
      lineWidth: "2",
      lineColor: "#177dff",
      fillColor: "rgba(23, 125, 255, 0.14)",
    });

    $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
      type: "line",
      height: "70",
      width: "100%",
      lineWidth: "2",
      lineColor: "#f3545d",
      fillColor: "rgba(243, 84, 93, .14)",
    });

    $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
      type: "line",
      height: "70",
      width: "100%",
      lineWidth: "2",
      lineColor: "#ffa534",
      fillColor: "rgba(255, 165, 52, .14)",
    });
  </script>
</body>

</html>