<?php
// INCLUDING CONNECTION TO DATABASE
include '../database/connection.php';

// SESSION IF NOT LOGIN YOU CANT GO TO DIRECT PAGE
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:admin_login.php');
}

// FETCH THE PETS
$get_pets = 'SELECT p.pet_id, p.pet_name, p.pet_age, p.pet_type, p.pet_breed, p.pet_condition, p.pet_status, p.pet_image, p.created_at,
               u.fullname AS owner_name, u.address AS owner_address, u.contact AS owner_contact, u.email AS owner_email
        FROM tbl_pets p
        LEFT JOIN tbl_users u ON p.user_id = u.user_id WHERE p.pet_status = "For adoption"';
$get_stmt = $conn->query($get_pets);
$pets = $get_stmt->fetchAll(PDO::FETCH_ASSOC);

// END PETS


// DELETE USERS
if (isset($_POST['delete'])) {
    $pet_id = $_POST['pet_id'];

    $select_image_query = $conn->prepare("SELECT pet_image FROM tbl_pets WHERE pet_id = ?");
    $select_image_query->execute([$pet_id]);
    $pet = $select_image_query->fetch(PDO::FETCH_ASSOC);

    if (!$pet) {
        $_SESSION['delete_error'] = "Pet not found.";
        header('location: pet_management.php');
        exit;
    }

    $image_path = '../images/pet-images/' . $pet['pet_image'];

    if (file_exists($image_path)) {
        unlink($image_path);
    }

    $delete_query = $conn->prepare("DELETE FROM tbl_pets WHERE pet_id = ?");
    $delete_success = $delete_query->execute([$pet_id]);

    if ($delete_success) {
        $_SESSION['delete_success'] = "Pet deleted successfully.";
    } else {
        $_SESSION['delete_error'] = "Error deleting pet.";
    }

    header('location: pet_management.php');
    exit;
}
// END DELETE USERS

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
                        <h3 class="fw-bold mb-3">Pet Management</h3>
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
                                <span style="color: grey;">Pet Management</span>
                            </li>
                        </ul>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Pet Name</th>
                                                    <th>Pet Type</th>
                                                    <th>Pet Breed</th>
                                                    <th>Pet Description</th>
                                                    <th>Pet Age</th>
                                                    <th style="width: 10%">Status</th>
                                                    <th style="width: 10%">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($pets as $pet) : ?>
                                                    <tr>
                                                        <td><img style="height: 75px;" src="../images/pet-images/<?php echo $pet['pet_image'] ?>" alt=""></td>
                                                        <td><?php echo $pet['pet_name']; ?></td>
                                                        <td><?php echo $pet['pet_type']; ?></td>
                                                        <td><?php echo $pet['pet_breed']; ?></td>
                                                        <td><?php echo $pet['pet_condition']; ?></td>
                                                        <td><?php echo $pet['pet_age']; ?></td>
                                                        <td>
                                                            <p style="font-size: 13px; font-weight: 900; color: green; "><?php echo $pet['pet_status'] ?></p>
                                                        </td>
                                                        <td>
                                                            <div class="form-button-action">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#delete_<?php echo $pet['pet_id']; ?>" class="btn btn-link btn-danger btn-lg">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </div>

                                                            <!-- DELETE MODAL -->
                                                            <div class="modal fade" id="delete_<?php echo $pet['pet_id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <form action="" method="POST">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Delete Pet</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name="pet_id" value="<?php echo $pet['pet_id'] ?>">
                                                                                <p>Are you sure you want to delete the pet "<?php echo $pet['pet_name']; ?>"?</p>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END DELETE MODAL -->

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

        <!-- DELETE -->
        <?php if (isset($_SESSION['delete_success'])) : ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '<?php echo $_SESSION['delete_success']; ?>',
                    confirmButtonText: 'OK'
                })
            </script>
            <?php unset($_SESSION['delete_success']); ?>;
        <?php endif; ?>

        <?php if (isset($_SESSION['delete_error'])) : ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '<?php echo $_SESSION['delete_error']; ?>',
                    confirmButtonText: 'OK'
                })
            </script>
            <?php unset($_SESSION['delete_error']); ?>;
        <?php endif; ?>
        <!-- END DELETE -->

        <script>
            function toggleInputEdit(petId) {
                var selectBox = document.getElementById("petCondition_" + petId);
                var specificSickInput = document.getElementById("specificSickInput_" + petId);

                if (selectBox.value === "in sick") {
                    specificSickInput.style.display = "block";
                } else {
                    specificSickInput.style.display = "none";
                }
            }
        </script>
        <script>
            function toggleInput() {
                var selectBox = document.getElementById("petCondition");
                var specificSickInput = document.getElementById("specificSickInput");

                if (selectBox.value === "sick") {
                    specificSickInput.style.display = "block";
                } else {
                    specificSickInput.style.display = "none";
                }
            }
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