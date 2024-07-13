<?php

// INCLUDING CONNECTION TO DATABASE
include '../database/connection.php';

// SESSION IF NOT LOGIN YOU CANT GO TO DIRECT PAGE
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:admin_login.php');
}

// ADD NEWS & ANNOUNCEMENT QUERY
if (isset($_POST['submit'])) {

    $title = $_POST['event_title'];
    $date = $_POST['event_schedule'];
    $description = $_POST['event_description'];

    $uploadDir = '../assets/event_image/';
    $uploadFile = $uploadDir . basename($_FILES['event_image']['name']);
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    if ($_FILES['event_image']['size'] > 0) {
        $check = getimagesize($_FILES['event_image']['tmp_name']);
        if ($check === false) {
            $_SESSION['upload_error'] = "File is not an image.";
            header('location: news_announcement.php');
            exit;
        }
        if ($_FILES['event_image']['size'] > 5000000) {
            $_SESSION['upload_error'] = "Sorry, your file is too large.";
            header('location: news_announcement.php');
            exit;
        }
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($imageFileType, $allowedTypes)) {
            $_SESSION['upload_error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            header('location: news_announcement.php');
            exit;
        }

        $uniqueFileName = uniqid('event_image_', true) . '.' . $imageFileType;
        $uploadFile = $uploadDir . $uniqueFileName;

        if (!move_uploaded_file($_FILES['event_image']['tmp_name'], $uploadFile)) {
            $_SESSION['upload_error'] = "Sorry, there was an error uploading your file.";
            header('location: news_announcement.php');
            exit;
        }
    } else {
        $_SESSION['upload_error'] = "Please select an image file.";
        header('location: news_announcement.php');
        exit;
    }

    $insert_query = $conn->prepare("INSERT INTO tbl_news_announcement (event_image, event_title, event_schedule, event_description) VALUES (?, ?, ?, ?)");
    $insert_query->execute([$uniqueFileName, $title, $date, $description]);

    if ($insert_query) {
        $_SESSION['upload_success'] = "News & Announcement added successfully.";
        header('location: news_announcement.php');
        exit;
    } else {
        $_SESSION['upload_error'] = "Error inserting data into database.";
        header('location: news_announcement.php');
        exit;
    }
}

// READ THE NEWS & ANNOUNCEMENT
$get_news = "SELECT * FROM `tbl_news_announcement`";
$get_stmt = $conn->query($get_news);
$announcements = $get_stmt->fetchAll(PDO::FETCH_ASSOC);
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
                        <h3 class="fw-bold mb-3">News & Announcement</h3>
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
                                <span style="color: grey;">News & Announcement</span>
                            </li>
                        </ul>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title"></h4>
                                        <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addRowModal">
                                            <i class="fa fa-plus"></i>
                                            Add News & Announcement
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- Modal -->
                                    <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="" method="POST" enctype="multipart/form-data">
                                                    <div class="modal-header border-0">
                                                        <h5 class="modal-title">
                                                            <span class="fw-mediumbold"> Add News & Announcement</span>
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Image</label><br>
                                                                    <input type="file" name="event_image" required><br><br>
                                                                    <img style="height: 70px;" src="https://th.bing.com/th/id/OIP.mA_5Jzd0hjmCnEBy3kNhIAHaFB?rs=1&pid=ImgDetMain" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Title</label>
                                                                    <input style="border: 2px solid grey;" type="text" class="form-control" name="event_title" placeholder="Enter title" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Datetime</label>
                                                                    <input style="border: 2px solid grey;" type="datetime-local" class="form-control" name="event_schedule" placeholder="Select date" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Description</label>
                                                                    <textarea class="form-control" name="event_description" style="border: 2px solid grey;" placeholder="Enter description"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <input type="submit" name="submit" class="btn btn-primary" value="Add">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Title</th>
                                                    <th>Date scheduled</th>
                                                    <th>Description</th>
                                                    <th style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($announcements as $announcement) : ?>
                                                    <tr>
                                                        <td><img style="height: 75px;" src="../assets/event_image/<?php echo $announcement['event_image'] ?>" alt=""></td>

                                                        <td><?php echo $announcement['event_title'] ?></td>
                                                        <td><?php echo date_format(new DateTime($announcement['event_schedule']), 'F j Y / h:i A'); ?></td>
                                                        <td><?php echo $announcement['event_description'] ?></td>
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

        <!-- SWEETALERT -->
        <?php if (isset($_SESSION['upload_success'])) : ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '<?php echo $_SESSION['upload_success']; ?>',
                    confirmButtonText: 'OK'
                })
            </script>
            <?php unset($_SESSION['upload_success']); ?>;
        <?php endif; ?>

        <?php if (isset($_SESSION['upload_error'])) : ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '<?php echo $_SESSION['upload_error']; ?>',
                    confirmButtonText: 'OK'
                })
            </script>
            <?php unset($_SESSION['upload_error']); ?>;
        <?php endif; ?>
        <!-- END SWEETALERT -->

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