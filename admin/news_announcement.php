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

// ADD NEWS & ANNOUNCEMENT QUERY
if (isset($_POST['submit'])) {
    $upload_error = [];
    $uploadDir = '../assets/event_image/';
    $uploadFile = $uploadDir . basename($_FILES['event_image']['name']);
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    if ($_FILES['event_image']['size'] > 0) {
        $check = getimagesize($_FILES['event_image']['tmp_name']);
        if ($check === false) {
            $upload_error['image'] = "File is not an image.";
        } elseif ($_FILES['event_image']['size'] > 5000000) {
            $upload_error['image'] = "Sorry, your file is too large.";
        } elseif (!in_array($imageFileType, array('jpg', 'jpeg', 'png', 'gif'))) {
            $upload_error['image'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }

        if (empty($upload_error['image'])) {
            $uniqueFileName = uniqid('event_image_', true) . '.' . $imageFileType;
            $uploadFile = $uploadDir . $uniqueFileName;

            if (!move_uploaded_file($_FILES['event_image']['tmp_name'], $uploadFile)) {
                $upload_error['image'] = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $upload_error['image'] = "Please select an image file.";
    }

    if (empty($upload_error['image'])) {
        $insert_query = $conn->prepare("INSERT INTO tbl_news_announcement (event_image, event_title, event_schedule, event_description) VALUES (?, ?, ?, ?)");
        $insert_query->execute([$uniqueFileName, $_POST['event_title'], $_POST['event_schedule'], $_POST['event_description']]);

        if ($insert_query) {
            $_SESSION['upload_success'] = "News & Announcement added successfully.";
            header('location: news_announcement.php');
            exit;
        } else {
            $upload_error['database'] = "Error inserting data into database.";
        }
    }
    $_SESSION['upload_error'] = $upload_error;
}
// END CREATE NEWS & ANNOUNCEMENT

// READ THE NEWS & ANNOUNCEMENT
$get_news = "SELECT * FROM `tbl_news_announcement`";
$get_stmt = $conn->query($get_news);
$announcements = $get_stmt->fetchAll(PDO::FETCH_ASSOC);
// END READ ANNOUNCEMENT

// UPDATE THE NEWS & ANNOUNCEMENT
if (isset($_POST['update'])) {
    $event_id = $_POST['event_id'];
    $title = $_POST['event_title'];
    $date = $_POST['event_schedule'];
    $description = $_POST['event_description'];

    if ($_FILES['event_image']['size'] > 0) {
        $uploadDir = '../assets/event_image/';
        $uploadFile = $uploadDir . basename($_FILES['event_image']['name']);
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES['event_image']['tmp_name']);
        if ($check === false) {
            $_SESSION['update_upload_error'] = "File is not an image.";
            $_SESSION['show_edit_modal'] = true;
            header('location: news_announcement.php');
            exit;
        }

        if ($_FILES['event_image']['size'] > 5000000) {
            $_SESSION['update_upload_error'] = "Sorry, your file is too large.";
            $_SESSION['show_edit_modal'] = true;
            header('location: news_announcement.php');
            exit;
        }

        $allowedTypes = array(
            'jpg', 'jpeg', 'png', 'gif'
        );
        if (!in_array($imageFileType, $allowedTypes)) {
            $_SESSION['update_upload_error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $_SESSION['show_edit_modal'] = true;
            header('location: news_announcement.php');
            exit;
        }

        $uniqueFileName = uniqid('event_image_', true) . '.' . $imageFileType;
        $uploadFile = $uploadDir . $uniqueFileName;

        if (!move_uploaded_file($_FILES['event_image']['tmp_name'], $uploadFile)) {
            $_SESSION['update_upload_error'] = "Sorry, there was an error uploading your file.";
            $_SESSION['show_edit_modal'] = true;
            header('location: news_announcement.php');
            exit;
        }

        $update_query = $conn->prepare("UPDATE tbl_news_announcement SET event_image = ? WHERE event_id = ?");
        $update_query->execute([$uniqueFileName, $event_id]);
    }

    $update_query = $conn->prepare("UPDATE tbl_news_announcement SET event_title = ?, event_schedule = ?, event_description = ? WHERE event_id = ?");
    $update_query->execute([$title, $date, $description, $event_id]);

    if ($update_query) {
        $_SESSION['update_upload_success'] = "News & Announcement updated successfully.";
        header('location: news_announcement.php');
        exit;
    } else {
        $_SESSION['update_upload_error'] = "Error updating announcement.";
        $_SESSION['show_edit_modal'] = true;
        header('location: news_announcement.php');
        exit;
    }
}
// END UPDATE ANNOUNCEMENT

// DELETE NEWS AND ANNOUNCEMENT
if (isset($_POST['delete'])) {
    $event_id = $_POST['event_id'];
    $select_query = $conn->prepare("SELECT event_image FROM tbl_news_announcement WHERE event_id = ?");
    $select_query->execute([$event_id]);
    $announcement = $select_query->fetch(PDO::FETCH_ASSOC);

    if ($announcement && !empty($announcement['event_image'])) {
        $uploadDir = '../assets/event_image/';
        $filePath = $uploadDir . $announcement['event_image'];

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    $delete_query = $conn->prepare("DELETE FROM tbl_news_announcement WHERE event_id = ?");
    $delete_query->execute([$event_id]);

    if ($delete_query) {
        $_SESSION['delete_success'] = "Announcement deleted successfully.";
    } else {
        $_SESSION['delete_error'] = "Error deleting announcement.";
    }

    header('location: news_announcement.php');
    exit;
}
// END DELETE NEWS AND ANNOUNCEMENT
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
                                                <form id="uploadForm" action="" method="POST" enctype="multipart/form-data">
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
                                                                    <input type="file" id="event_image" name="event_image" required><br><br>
                                                                    <img id="display_image" style="height: 70px;" src="https://cdn4.iconfinder.com/data/icons/documents-36/25/add-picture-1024.png" alt="">
                                                                    <br>
                                                                    <?php if (isset($_SESSION['upload_error']['image'])) : ?>
                                                                        <span class="text-danger">* <?php echo $_SESSION['upload_error']['image']; ?></span>
                                                                    <?php endif; ?>
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
                                    <!-- ADD MODAL END -->



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
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#edit_<?php echo $announcement['event_id']; ?>" class="btn btn-link btn-primary btn-lg">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#delete_<?php echo $announcement['event_id']; ?>" class="btn btn-link btn-danger btn-lg">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </div>

                                                            <!-- EDIT MODAL -->
                                                            <div class="modal fade" id="edit_<?php echo $announcement['event_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <form action="" method="POST" enctype="multipart/form-data">
                                                                            <div class="modal-header border-0">
                                                                                <h5 class="modal-title">
                                                                                    <span class="fw-mediumbold"> Update News & Announcement</span>
                                                                                </h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <input type="hidden" name="event_id" value="<?php echo $announcement['event_id']; ?>">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label>Current Image</label><br>
                                                                                            <img style="height: 70px;" src="../assets/event_image/<?php echo $announcement['event_image'] ?>" alt="Current Image">
                                                                                        </div>

                                                                                        <div class="form-group">
                                                                                            <label>Update Image</label><br>
                                                                                            <input type="file" id="update_event_image" name="event_image" required><br><br>
                                                                                            <img id="update_display_image" style="height: 70px;" src="https://cdn4.iconfinder.com/data/icons/documents-36/25/add-picture-1024.png" alt="">
                                                                                            <br>
                                                                                            <?php if (isset($_SESSION['update_upload_error'])) : ?>
                                                                                                <span class="text-danger"><?php echo $_SESSION['update_upload_error']; ?></span>
                                                                                                <?php unset($_SESSION['update_upload_error']); ?>
                                                                                            <?php endif; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label>Title</label>
                                                                                            <input style="border: 2px solid grey;" type="text" class="form-control" name="event_title" value="<?php echo $announcement['event_title'] ?>" placeholder=" Enter title" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label>Datetime</label>
                                                                                            <input style="border: 2px solid grey;" type="datetime-local" class="form-control" name="event_schedule" value="<?php echo $announcement['event_schedule'] ?>" placeholder=" Select date" required />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-12">
                                                                                        <div class="form-group">
                                                                                            <label>Description</label>
                                                                                            <textarea class="form-control" name="event_description" style="border: 2px solid grey;"><?php echo $announcement['event_description']; ?></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer border-0">
                                                                                <input type="submit" name="update" class="btn btn-primary" value="Save changes">
                                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END EDIT MODAL -->


                                                            <!-- DELETE MODAL -->
                                                            <div class="modal fade" id="delete_<?php echo $announcement['event_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <form action="" method="POST">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Delete Announcement</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name="event_id" value="<?php echo $announcement['event_id']; ?>">
                                                                                <p>Are you sure you want to delete the announcement "<?php echo $announcement['event_title']; ?>"?</p>
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

        <!-- DISPLAY IMAGE -->
        <script>
            document.getElementById('event_image').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('display_image').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
        <!-- END DISPLAY IMAGE -->
        <script>
            document.getElementById('update_event_image').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('update_display_image').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>

        <!-- UPDATE IMAGE DISPLAY -->

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

        <!-- SWEETALERT -->

        <!-- CREATE-->
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


        <script>
            <?php if (isset($_SESSION['upload_error']['image'])) : ?>
                $(document).ready(function() {
                    $('#addRowModal').modal('show');
                });
            <?php endif; ?>

            <?php unset($_SESSION['upload_error']); ?>
        </script>
        <!-- END CREATE -->

        <!-- UPDATE -->
        <?php if (isset($_SESSION['update_upload_success'])) : ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '<?php echo $_SESSION['update_upload_success']; ?>',
                    confirmButtonText: 'OK'
                })
            </script>
            <?php unset($_SESSION['update_upload_success']); ?>;
        <?php endif; ?>

        <script>
            $(document).ready(function() {
                <?php if (isset($_SESSION['show_edit_modal']) && $_SESSION['show_edit_modal']) : ?>
                    $('#edit_<?php echo $announcement['event_id']; ?>').modal('show');
                <?php endif; ?>

                <?php unset($_SESSION['show_edit_modal']); ?>;
            });
        </script>
        <!-- END UPDATE -->



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