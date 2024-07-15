<?php
include 'database/connection.php';

// SESSION
session_start();
if (isset($_SESSION['user_id'])) {
    header('location:home.php');
    exit();
}

// REGISTER QUERY
$errors = [];

if (isset($_POST['register'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    $confirm_password = $_POST['confirm_password'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    if ($password !== sha1($confirm_password)) {
        $errors['password'] = 'Password does not match.';
    }

    $check_email = $conn->prepare("SELECT * FROM `tbl_users` WHERE email = ?");
    $check_email->execute([$email]);
    if ($check_email->rowCount() > 0) {
        $errors['email'] = 'Email already exists.';
    }

    if (empty($errors)) {
        $insert_user = $conn->prepare("INSERT INTO `tbl_users` (fullname, email, password, contact, address) VALUES (?, ?, ?, ?, ?)");
        $insert_user->execute([$fullname, $email, $password, $contact, $address]);
        $_SESSION['success'] = 'Registration successful. You can now login.';
        header('location:register.php');
        exit();
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/login-assets/fonts/icomoon/style.css">
    <link rel="stylesheet" href="assets/login-assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/login-assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/login-assets/css/style.css">

    <title>User Register</title>
    <style>
        #banner {
            display: block;
        }

        @media (max-width: 991.98px) {
            #banner {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="d-lg-flex half">
        <div id="banner" class="bg order-1 order-md-2" style="background-image: url('https://img.freepik.com/premium-vector/dont-buy-adopt-pet-adoption-banner-vector_112018-633.jpg');"></div>
        <div class="contents order-2 order-md-1">

            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7">
                        <div class="mb-4">
                            <h3>Register</h3>
                        </div>
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php foreach ($errors as $error) : ?>
                                    <h6><?php echo $error; ?></h6>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <form action="" method="post">
                            <div class="form-group first">
                                <label for="fullname">Fullname</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" required>
                            </div>
                            <div class="form-group first">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group first">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group first">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <div class="form-group first">
                                <label for="contact">Phone number</label>
                                <input type="text" class="form-control" id="contact" name="contact">
                            </div>
                            <div class="form-group last mb-3">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address">
                            </div>

                            <input type="submit" style="background-color: #704130; border: none;" name="register" value="Register" class="btn btn-block btn-primary">
                            <a href="login.php" style="float: right;">Login here</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/login-assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/login-assets/js/popper.min.js"></script>
    <script src="assets/login-assets/js/bootstrap.min.js"></script>
    <script src="assets/login-assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- SWEETALERT -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($_SESSION['success'])) : ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '<?php echo $_SESSION['success']; ?>',
                    confirmButtonColor: '#704130'
                });
            <?php
                unset($_SESSION['success']);
            endif; ?>
        });
    </script>
</body>

</html>