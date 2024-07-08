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
                        <h4 class="card-title">3</h4>
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
                        <h4 class="card-title">1303</h4>
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
                        <p class="card-category">Approval Adoption</p>
                        <h4 class="card-title">3</h4>
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
                        <h4 class="card-title">576</h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="card card-round">
                <div class="card-body">
                  <div class="card-head-row card-tools-still-right">
                    <div class="card-title">New Users</div>
                  </div>
                  <div class="card-list py-4">
                    <div class="item-list">
                      <div class="avatar">
                        <img src="assets/img/jm_denis.jpg" alt="..." class="avatar-img rounded-circle" />
                      </div>
                      <div class="info-user ms-3">
                        <div class="username">Jimmy Denis</div>
                        <div class="status">Graphic Designer</div>
                      </div>
                      <div class="info-user ms-3">
                        <div class="username">Role</div>
                        <div class="status">Admin</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-8">
              <div class="card card-round">
                <div class="card-header">
                  <div class="card-head-row card-tools-still-right">
                    <div class="card-title">Successful Adoption</div>
                    <div class="card-tools">
                      <div class="dropdown">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center mb-0">
                      <thead class="thead-light">
                        <tr>
                          <th scope="col">Details</th>
                          <th scope="col" class="text-end">Date & Time</th>
                          <th scope="col" class="text-end">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">
                            <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                              <i class="fa fa-check"></i>
                            </button>
                            Dog/Labrador/15
                          </th>
                          <td class="text-end">Mar 19, 2020, 2.45pm</td>
                          <td class="text-end">
                            <span class="badge badge-success">Completed</span>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">
                            <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                              <i class="fa fa-check"></i>
                            </button>
                            Dog/Labrador/15
                          </th>
                          <td class="text-end">Mar 19, 2020, 2.45pm</td>
                          <td class="text-end">
                            <span class="badge badge-success">Completed</span>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">
                            <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                              <i class="fa fa-check"></i>
                            </button>
                            Dog/Labrador/15
                          </th>
                          <td class="text-end">Mar 19, 2020, 2.45pm</td>
                          <td class="text-end">
                            <span class="badge badge-success">Completed</span>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">
                            <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                              <i class="fa fa-check"></i>
                            </button>
                            Dog/Labrador/15
                          </th>
                          <td class="text-end">Mar 19, 2020, 2.45pm</td>
                          <td class="text-end">
                            <span class="badge badge-success">Completed</span>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">
                            <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                              <i class="fa fa-check"></i>
                            </button>
                            Dog/Labrador/15
                          </th>
                          <td class="text-end">Mar 19, 2020, 2.45pm</td>
                          <td class="text-end">
                            <span class="badge badge-success">Completed</span>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">
                            <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                              <i class="fa fa-check"></i>
                            </button>
                            Dog/Labrador/15
                          </th>
                          <td class="text-end">Mar 19, 2020, 2.45pm</td>
                          <td class="text-end">
                            <span class="badge badge-success">Completed</span>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">
                            <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                              <i class="fa fa-check"></i>
                            </button>
                            Dog/Labrador/15
                          </th>
                          <td class="text-end">Mar 19, 2020, 2.45pm</td>
                          <td class="text-end">
                            <span class="badge badge-success">Completed</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
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