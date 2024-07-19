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

$sql = "SELECT 
            p.pet_id,
            p.pet_image,
            p.pet_name,
            p.pet_age,
            p.pet_type,
            p.pet_breed,
            p.pet_condition,
            u.user_id AS pet_owner_id,
            u.fullname AS pet_owner_name,
            u.address AS pet_owner_address,
            u.contact AS pet_owner_contact,
            u.email AS pet_owner_email,
            a.user_id AS adopted_user_id,
            a.created_at AS adoption_date,
            a.remarks AS adoption_status,
            adopted_user.fullname AS adopted_user_fullname,
            adopted_user.address AS adopted_user_address,
            adopted_user.contact AS adopted_user_contact,
            adopted_user.email AS adopted_user_email
        FROM 
            tbl_pets p
        JOIN 
            tbl_users u ON p.user_id = u.user_id
        LEFT JOIN 
            tbl_adoption a ON p.pet_id = a.pet_id
        LEFT JOIN
            tbl_users adopted_user ON a.user_id = adopted_user.user_id WHERE remarks = 'Requesting' OR remarks = 'Ready to pick up' OR remarks = 'Completed'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$adoptionDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                        <h3 class="fw-bold mb-3">Adoptions</h3>
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
                                <span style="color: grey;">Adoptions</span>
                            </li>
                        </ul>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title"></h4>
                                    </div>
                                </div>
                                <div class="card-body">


                                    <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Owner Details</th>
                                                    <th>Pet Details</th>
                                                    <th>Adoptor Details</th>
                                                    <th>Date Adopted</th>
                                                    <th style="width: 10%">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($adoptionDetails as $adoption) : ?>
                                                    <tr>
                                                        <td>
                                                            <span><i class="fas fa-user-circle"></i> <?php echo $adoption['pet_owner_name'] ?></span> <br>
                                                            <span><i class="fa fa-map-marker"></i> <?php echo $adoption['pet_owner_address'] ?></span> <br>
                                                            <span><i class="fa fa-phone"></i> <?php echo $adoption['pet_owner_contact'] ?></span> <br>
                                                            <span><i class="fa fa-envelope"></i> <?php echo $adoption['pet_owner_email'] ?></span>
                                                        </td>
                                                        <td>
                                                            <span>
                                                                <img style="height: 100px;" src="../images/pet-images/<?php echo $adoption['pet_image'] ?>" alt="">
                                                            </span><br>
                                                            <span>
                                                                <?php echo $adoption['pet_name'] ?>
                                                            </span> <br>
                                                            <span>
                                                                <?php echo $adoption['pet_age'] ?>
                                                            </span> <br>
                                                            <span>
                                                                <?php echo $adoption['pet_type'] ?>
                                                            </span> <br>
                                                            <span>
                                                                <?php echo $adoption['pet_breed'] ?>
                                                            </span> <br>
                                                            <span>
                                                                <?php echo $adoption['pet_condition'] ?>
                                                            </span> <br>
                                                        </td>
                                                        <td>
                                                            <span><i class="fas fa-user-circle"></i> <?php echo $adoption['adopted_user_fullname'] ?></span> <br>
                                                            <span><i class="fa fa-map-marker"></i> <?php echo $adoption['adopted_user_address'] ?></span> <br>
                                                            <span><i class="fa fa-phone"></i> <?php echo $adoption['adopted_user_contact'] ?></span> <br>
                                                            <span><i class="fa fa-envelope"></i> <?php echo $adoption['adopted_user_email'] ?></span>
                                                        </td>
                                                        <td>
                                                            <span style="font-size: 15px;"><?= date('F j, Y / g:ia', strtotime($adoption['adoption_date'])) ?></span>
                                                        </td>
                                                        <td>
                                                            <?php if ($adoption['adoption_status'] === 'Requesting') : ?>
                                                                <p style="font-size: 12px; font-weight: 900; color: orange"><?php echo $adoption['adoption_status'] ?></p>
                                                            <?php elseif ($adoption['adoption_status'] === 'Ready to pick up') : ?>
                                                                <p style="font-size: 12px; font-weight: 900; color: red"><?php echo $adoption['adoption_status'] ?></p>
                                                            <?php else : ?>
                                                                <p style="font-size: 12px; font-weight: 900; color: green"><?php echo $adoption['adoption_status'] ?></p>
                                                            <?php endif ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
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