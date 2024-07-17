<?php
// INCLUDING CONNECTION TO DATABASE
include '../database/connection.php';

// SESSION IF NOT LOGIN YOU CANT GO TO DIRECT PAGE
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:admin_login.php');
}

// FETCH THE APPROVAL
$get_pets = 'SELECT p.pet_id, p.pet_name, p.pet_age, p.pet_type, p.pet_breed, p.pet_condition, p.pet_status, p.pet_image, p.created_at,
               u.fullname AS owner_name, u.address AS owner_address, u.contact AS owner_contact, u.email AS owner_email
        FROM tbl_pets p
        LEFT JOIN tbl_users u ON p.user_id = u.user_id WHERE p.pet_status = "Requesting"';
$get_stmt = $conn->query($get_pets);
$pets = $get_stmt->fetchAll(PDO::FETCH_ASSOC);

// END FETCH

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
                        <h3 class="fw-bold mb-3">Pets Approval</h3>
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
                                <span style="color: grey;">Pets Approval</span>
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
                                                    <th>Owner</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Breed</th>
                                                    <th>Description</th>
                                                    <th>Age</th>
                                                    <th style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($pets as $pet) : ?>
                                                    <tr>
                                                        <td>
                                                            <span> <?php echo $pet['owner_name']; ?></span> <br>
                                                            <span> <?php echo $pet['owner_address']; ?></span> <br>
                                                            <span> <?php echo $pet['owner_contact']; ?></span> <br>
                                                            <span> <?php echo $pet['owner_email']; ?></span>
                                                        </td>
                                                        <td><img style="height: 75px;" src="../images/pet-images/<?php echo $pet['pet_image'] ?>" alt=""></td>
                                                        <td><?php echo $pet['pet_name']; ?></td>
                                                        <td><?php echo $pet['pet_type']; ?></td>
                                                        <td><?php echo $pet['pet_breed']; ?></td>
                                                        <td><?php echo $pet['pet_condition']; ?></td>
                                                        <td><?php echo $pet['pet_age']; ?></td>
                                                        <td>
                                                            <div class="form-button-action">
                                                                <a href="#" class="btn btn-link btn-primary btn-lg approve-pet" data-pet-id="<?php echo $pet['pet_id']; ?>">
                                                                    <i class="fa fa-check"> Approve</i>
                                                                </a>
                                                                <a style="margin-top: 5px;" href="#" class="btn btn-link btn-danger reject-pet" data-pet-id="<?php echo $pet['pet_id']; ?>" data-pet-image="<?php echo $pet['pet_image']; ?>">
                                                                    <i class="fa fa-times"> Reject</i>
                                                                </a>
                                                            </div>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <!-- APPROVE -->
        <script>
            $(document).on('click', '.approve-pet', function(e) {
                e.preventDefault();
                var petId = $(this).data('pet-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to approve this pet for adoption.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'functions/approve.php',
                            type: 'POST',
                            data: {
                                pet_id: petId
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire(
                                        'Approved!',
                                        'Pet has been approved for adoption.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to approve pet: ' + response.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error!',
                                    'Failed to approve pet: ' + error,
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        </script>
        <!-- REJECT -->
        <script>
            $(document).on('click', '.reject-pet', function(e) {
                e.preventDefault();
                var petId = $(this).data('pet-id');
                var petImage = $(this).data('pet-image');

                console.log("Pet ID:", petId);
                console.log("Pet Image:", petImage);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to reject this pet. This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, reject it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log("User confirmed rejection.");

                        $.ajax({
                            url: 'functions/reject.php',
                            type: 'POST',
                            data: {
                                pet_id: petId,
                                pet_image: petImage
                            },
                            dataType: 'json',
                            success: function(response) {
                                console.log("AJAX Success Response:", response);

                                if (response.status === 'success') {
                                    Swal.fire(
                                        'Rejected!',
                                        'Pet has been rejected.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to reject pet: ' + response.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log("AJAX Error:", xhr, status, error);

                                Swal.fire(
                                    'Error!',
                                    'Failed to reject pet: ' + error,
                                    'error'
                                );
                            }
                        });
                    } else {
                        console.log("User canceled rejection.");
                    }
                });
            });
        </script>

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