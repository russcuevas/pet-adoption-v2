<?php
include '../database/connection.php';

// SESSION IF NOT LOGIN YOU CANT GO TO DIRECT PAGE
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
  header('location:admin_login.php');
}

// CREATE USER
if (isset($_POST['submit'])) {
  $fullname = $_POST['fullname'];
  $contact = $_POST['contact'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  $errors = [];

  if ($password !== $confirm_password) {
    $errors['password'] = "Password mismatch";
  }

  $stmt_check_email = $conn->prepare("SELECT COUNT(*) FROM tbl_users WHERE email = ?");
  $stmt_check_email->execute([$email]);
  $count = $stmt_check_email->fetchColumn();

  if ($count > 0) {
    $errors['email'] = "Email already exists";
  }

  if (!empty($errors)) {
    $_SESSION['insert_user_errors'] = $errors;
    header('location: users_management.php');
    exit;
  }

  unset($_SESSION['insert_user_errors']);

  $hashed_password = sha1($password);
  $stmt_insert_user = $conn->prepare("INSERT INTO tbl_users (fullname, contact, email, address, password) VALUES (?, ?, ?, ?, ?)");
  $stmt_insert_user->execute([$fullname, $contact, $email, $address, $hashed_password]);

  $_SESSION['insert_user_success'] = "User added successfully";
  header('location: users_management.php');
  exit;
}
// END CREATE USER

// READ USER
$get_users = "SELECT * FROM `tbl_users`";
$get_stmt = $conn->query($get_users);
$users = $get_stmt->fetchAll(PDO::FETCH_ASSOC);
// END READ USER

// UPDATE USER
if (isset($_POST['update'])) {
  $user_id = $_POST['user_id'];
  $fullname = $_POST['fullname'];
  $contact = $_POST['contact'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  $errors = [];

  if (!empty($password)) {
    if ($password !== $confirm_password) {
      $errors['password'] = "Password mismatch";
      $_SESSION['show_edit_modal'] = true;
    }
    $hashed_password = sha1($password);
  } else {
    $stmt_existing_password = $conn->prepare("SELECT password FROM tbl_users WHERE user_id = ?");
    $stmt_existing_password->execute([$user_id]);
    $existing_password = $stmt_existing_password->fetchColumn();
    $hashed_password = $existing_password;
  }

  if ($email != $user['email']) {
    $stmt_check_email = $conn->prepare("SELECT COUNT(*) FROM tbl_users WHERE email = ? AND user_id != ?");
    $stmt_check_email->execute([$email, $user_id]);
    $count = $stmt_check_email->fetchColumn();
    if ($count > 0) {
      $errors['email'] = "Email already exists for another user.";
      $_SESSION['show_edit_modal'] = true;
    }
  }

  if (!empty($errors)) {
    $_SESSION['update_user_errors'] = $errors;
    header("location: users_management.php");
    exit;
  }

  unset($_SESSION['update_user_errors']);

  $stmt_update_user = $conn->prepare("UPDATE tbl_users SET fullname = ?, contact = ?, email = ?, address = ?, password = ? WHERE user_id = ?");
  $stmt_update_user->execute([$fullname, $contact, $email, $address, $hashed_password, $user_id]);

  if ($stmt_update_user) {
    $_SESSION['update_user_success'] = "User updated successfully.";
  } else {
    $_SESSION['update_user_errors'] = "Error updating user.";
  }

  header('location: users_management.php');
  exit;
}
// END UPDATE USER


// DELETE USERS
if (isset($_POST['delete'])) {
  $user_id = $_POST['user_id'];

  $delete_query = $conn->prepare("DELETE FROM tbl_users WHERE user_id = ?");
  $delete_query->execute([$user_id]);

  if ($delete_query) {
    $_SESSION['delete_success'] = "User deleted successfully.";
  } else {
    $_SESSION['delete_error'] = "Error deleting user.";
  }

  header('location: users_management.php');
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
            <h3 class="fw-bold mb-3">Users Management</h3>
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
                <span style="color: grey;">Users</span>
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
                      Add Users
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
                              <span class="fw-mediumbold"> Add New Users</span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-6 pe-0">
                                <div class="form-group">
                                  <label>Fullname</label>
                                  <input style="border: 2px solid grey;" type="text" name="fullname" class="form-control" placeholder="" required />
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Phone Number</label>
                                  <input style="border: 2px solid grey;" type="text" name="contact" class="form-control" placeholder="" required />
                                </div>
                              </div>
                              <div class="col-sm-12">
                                <div class="form-group">
                                  <label>Email</label>
                                  <input style="border: 2px solid grey;" name="email" type="text" class="form-control" placeholder="" required />
                                  <?php if (isset($_SESSION['insert_user_errors']['email'])) : ?>
                                    <div class="col-12">
                                      <span class="text-danger">* <?php echo $_SESSION['insert_user_errors']['email']; ?></span>
                                    </div>
                                  <?php endif; ?>
                                </div>
                              </div>
                              <div class="col-sm-12">
                                <div class="form-group">
                                  <label>Address</label>
                                  <input style="border: 2px solid grey;" name="address" type="text" class="form-control" placeholder="" required />
                                </div>
                              </div>
                              <div class="col-md-6 pe-0">
                                <div class="form-group">
                                  <label>Password</label>
                                  <input style="border: 2px solid grey;" type="password" name="password" class="form-control" placeholder="" required />
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Confirm Password</label>
                                  <input style="border: 2px solid grey;" type="password" name="confirm_password" class="form-control" placeholder="" required />
                                  <?php if (isset($_SESSION['insert_user_errors']['password'])) : ?>
                                    <div class="col-12">
                                      <span class="text-danger">* <?php echo $_SESSION['insert_user_errors']['password']; ?></span>
                                    </div>
                                  <?php endif; ?>
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
                          <th>Fullname</th>
                          <th>Email</th>
                          <th>Address</th>
                          <th>Contact</th>
                          <th style="width: 10%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($users as $user) : ?>
                          <tr>
                            <td><?php echo $user['fullname'] ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <td><?php echo $user['address'] ?></td>
                            <td><?php echo $user['contact'] ?></td>
                            <td>
                              <div class="form-button-action">
                                <a href="" data-bs-toggle="modal" data-bs-target="#edit_<?php echo $user['user_id']; ?>" class="btn btn-link btn-primary btn-lg">
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="" style="margin-top: 5px;" data-bs-toggle="modal" data-bs-target="#delete_<?php echo $user['user_id']; ?>" class="btn btn-link btn-danger">
                                  <i class="fa fa-times"></i>
                                </a>
                              </div>

                              <!-- EDIT MODAL -->
                              <div class="modal fade" id="edit_<?php echo $user['user_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <form action="users_management.php" method="POST">
                                      <div class="modal-header border-0">
                                        <h5 class="modal-title">
                                          <span class="fw-mediumbold">Edit User</span>
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <div class="row">
                                          <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                          <div class="col-md-6 pe-0">
                                            <div class="form-group">
                                              <label>Fullname</label>
                                              <input style="border: 2px solid grey;" type="text" class="form-control" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" placeholder="Enter fullname" required />
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label>Phone Number</label>
                                              <input style="border: 2px solid grey;" type="text" class="form-control" name="contact" value="<?php echo htmlspecialchars($user['contact']); ?>" placeholder="Enter phone number" required />
                                            </div>
                                          </div>
                                          <div class="col-sm-12">
                                            <div class="form-group">
                                              <label>Email</label>
                                              <input style="border: 2px solid grey;" type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Enter email" required />
                                              <?php if (isset($_SESSION['update_user_errors']['email'])) : ?>
                                                <div class="col-12">
                                                  <span class="text-danger">* <?php echo $_SESSION['update_user_errors']['email']; ?></span>
                                                </div>
                                              <?php endif; ?>
                                            </div>
                                          </div>
                                          <div class="col-sm-12">
                                            <div class="form-group">
                                              <label>Address</label>
                                              <input style="border: 2px solid grey;" type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" placeholder="Enter address" required />
                                            </div>
                                          </div>
                                          <div class="col-md-6 pe-0">
                                            <div class="form-group">
                                              <label>New Password</label>
                                              <input style="border: 2px solid grey;" type="password" class="form-control" name="password" placeholder="Enter new password (optional)" />
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label>Confirm New Password</label>
                                              <input style="border: 2px solid grey;" type="password" name="confirm_password" class="form-control" placeholder="Confirm new password (optional)" />
                                              <?php if (isset($_SESSION['update_user_errors']['password'])) : ?>
                                                <div class="col-12">
                                                  <span class="text-danger">* <?php echo $_SESSION['update_user_errors']['password']; ?></span>
                                                </div>
                                              <?php endif; ?>
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
                              <div class="modal fade" id="delete_<?php echo $user['user_id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <form action="" method="POST">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Delete User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <input type="hidden" name="user_id" value="<?php echo $user['user_id'] ?>">
                                        <p>Are you sure you want to delete the user "<?php echo $user['fullname']; ?>"?</p>
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

    <!-- CREATE-->
    <?php if (isset($_SESSION['insert_user_success'])) : ?>
      <script>
        $(document).ready(function() {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '<?php echo $_SESSION['insert_user_success']; ?>',
            confirmButtonText: 'OK'
          });
        });
      </script>
      <?php unset($_SESSION['insert_user_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['insert_user_errors'])) : ?>
      <script>
        $(document).ready(function() {
          $('#addRowModal').modal('show');
        });
      </script>
      <?php unset($_SESSION['insert_user_errors']); ?>
    <?php endif; ?>

    <!-- END CREATE -->


    <!-- UPDATE-->
    <?php if (isset($_SESSION['update_user_success'])) : ?>
      <script>
        $(document).ready(function() {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '<?php echo $_SESSION['update_user_success']; ?>',
            confirmButtonText: 'OK'
          });
        });
      </script>
      <?php unset($_SESSION['update_user_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['update_user_errors'])) : ?>
      <script>
        $(document).ready(function() {
          <?php if (isset($_SESSION['show_edit_modal']) && $_SESSION['show_edit_modal']) : ?>
            $('#edit_<?php echo $user['user_id']; ?>').modal('show');
          <?php endif; ?>

          <?php unset($_SESSION['show_edit_modal']); ?>;
        });
      </script>
      <?php unset($_SESSION['update_user_errors']); ?>
    <?php endif; ?>

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