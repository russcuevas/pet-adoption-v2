<?php
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

// DISPLAY REPORTS
$get_reports = "SELECT * FROM `tbl_reports`";
$get_stmt = $conn->query($get_reports);
$reports = $get_stmt->fetchAll(PDO::FETCH_ASSOC);
// END REPORTS
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
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Reports</h3>
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
                                <span style="color: grey;">Reports</span>
                            </li>
                        </ul>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title"></h4>
                                        <button class="btn btn-primary btn-round ms-auto" onclick="window.open('print/print_report.php', '_blank', 'width=800,height=600')">
                                            <i class="fas fa-file"></i> &nbsp;
                                            Download for Print
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">


                                    <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Adopter Details</th>
                                                    <th>Pet Details</th>
                                                    <th>Adoptor Details</th>
                                                    <th>Date Adopted</th>
                                                    <th style="width: 10%">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($reports as $report) : ?>
                                                    <tr>
                                                        <td>
                                                            <span><?php echo $report['owner_fullname'] ?></span> <br>
                                                            <span><?php echo $report['owner_address'] ?></span> <br>
                                                            <span><?php echo $report['owner_contact'] ?></span> <br>
                                                            <span><?php echo $report['owner_email'] ?></span>
                                                        </td>
                                                        <td>
                                                            <span><?php echo $report['pet_name'] ?></span> <br>
                                                            <span><?php echo $report['pet_type'] ?></span> <br>
                                                            <span><?php echo $report['pet_breed'] ?></span> <br>
                                                            <span><?php echo $report['pet_condition'] ?></span>
                                                        </td>
                                                        <td>
                                                            <span><?php echo $report['adoptor_fullname'] ?></span> <br>
                                                            <span><?php echo $report['adoptor_address'] ?></span> <br>
                                                            <span><?php echo $report['adoptor_contact'] ?></span> <br>
                                                            <span><?php echo $report['adoptor_email'] ?></span>
                                                        </td>
                                                        <td>
                                                            <span style="font-size: 10px;"><?= date('F j, Y / g:ia', strtotime($report['date'])) ?></span>
                                                        </td>
                                                        <td>
                                                            <span style="color: green;"><?php echo $report['status'] ?></span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- UPDATE PROFILE -->
        <?php if (isset($_SESSION['profile_update_success'])) : ?>
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '<?php echo $_SESSION['profile_update_success']; ?>',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
            <?php unset($_SESSION['profile_update_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['profile_update_error'])) : ?>
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '<?php echo $_SESSION['profile_update_error']; ?>',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
            <?php unset($_SESSION['profile_update_error']); ?>
        <?php endif; ?>
        <!-- END UPDATE PROFILE -->

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

        <script>
            $(document).ready(function() {
                $("#basic-datatables").DataTable({});

                $("#multi-filter-select").DataTable({
                    pageLength: 5,
                    initComplete: function() {
                        this.api()
                            .columns()
                            .every(function() {
                                var column = this;
                                var select = $(
                                        '<select class="form-select"><option value=""></option></select>'
                                    )
                                    .appendTo($(column.footer()).empty())
                                    .on("change", function() {
                                        var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                        column
                                            .search(val ? "^" + val + "$" : "", true, false)
                                            .draw();
                                    });

                                column
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function(d, j) {
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