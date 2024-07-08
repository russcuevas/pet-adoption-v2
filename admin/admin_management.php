
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Datatables - Kaiadmin Bootstrap 5 Admin Dashboard</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />

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
       <?php include ('sidebar.php') ?>
      <!-- END SIDEBAR -->

      <div class="main-panel">
        
        <!-- HEADER / NAVBAR -->
        <?php include ('header.php') ?>
        <!-- END HEADER / NAVBAR -->

        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Admin Management</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="dashboard.php">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <span style="color: grey;">Users Management</span>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                <span style="color: grey;">Admin</span>
                </li>
              </ul>
            </div>
            <div class="row">

              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title"></h4>
                      <button
                        class="btn btn-primary btn-round ms-auto"
                        data-bs-toggle="modal"
                        data-bs-target="#addRowModal"
                      >
                        <i class="fa fa-plus"></i>
                        Add Admin
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <!-- Modal -->
                    <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <form method="POST">
                                <div class="modal-header border-0">
                                <h5 class="modal-title">
                                    <span class="fw-mediumbold"> Add New Admin</span>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 pe-0">
                                    <div class="form-group">
                                        <label>Fullname</label>
                                        <input style="border: 2px solid grey;" type="text" class="form-control" placeholder="" required />
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input style="border: 2px solid grey;" type="text" class="form-control" placeholder="" required />
                                    </div>
                                    </div>
                                    <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input style="border: 2px solid grey;" id="addName" type="text" class="form-control" placeholder="" required />
                                    </div>
                                    </div>
                                    <div class="col-md-6 pe-0">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input style="border: 2px solid grey;" type="password" class="form-control" placeholder="" required />
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input style="border: 2px solid grey;" type="password" class="form-control" placeholder="" required />
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="modal-footer border-0">
                                <input type="submit" class="btn btn-primary" value="Add">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                            </div>
                        </div>
                        </div>



                    <div class="table-responsive">
                      <table
                        id="add-row"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th style="width: 10%">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Tiger Nixon</td>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>
                              <div class="form-button-action">
                                <a href="" class="btn btn-link btn-primary btn-lg">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a style="margin-top: 5px;" href="" class="btn btn-link btn-danger">
                                    <i class="fa fa-times"></i>
                                </a>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Garrett Winters</td>
                            <td>Tiger Nixon</td>

                            <td>Accountant</td>
                            <td>Tokyo</td>
                            <td>
                              <div class="form-button-action">
                                <a href="" class="btn btn-link btn-primary btn-lg">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a style="margin-top: 5px;" href="" class="btn btn-link btn-danger">
                                    <i class="fa fa-times"></i>
                                </a>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Ashton Cox</td>
                            <td>Tiger Nixon</td>

                            <td>Junior Technical Author</td>
                            <td>San Francisco</td>
                            <td>
                              <div class="form-button-action">
                                <a href="" class="btn btn-link btn-primary btn-lg">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a style="margin-top: 5px;" href="" class="btn btn-link btn-danger">
                                    <i class="fa fa-times"></i>
                                </a>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Cedric Kelly</td>
                            <td>Tiger Nixon</td>

                            <td>Senior Javascript Developer</td>
                            <td>Edinburgh</td>
                            <td>
                              <div class="form-button-action">
                                <a href="" class="btn btn-link btn-primary btn-lg">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a style="margin-top: 5px;" href="" class="btn btn-link btn-danger">
                                    <i class="fa fa-times"></i>
                                </a>
                              </div>
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

    <!-- Custom template | don't include it in your project! -->
    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>
    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="assets/js/setting-demo2.js"></script>

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <script>
      $(document).ready(function () {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
          pageLength: 5,
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                var column = this;
                var select = $(
                  '<select class="form-select"><option value=""></option></select>'
                )
                  .appendTo($(column.footer()).empty())
                  .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
                  });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
          },
        });

        // Add Row
        $("#add-row").DataTable({
          pageLength: 10,
        });

        var action =
          '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
      });
    </script>
  </body>
</html>
