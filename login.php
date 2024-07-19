<?php
include 'database/connection.php';

// SESSION
session_start();
if (isset($_SESSION['user_id'])) {
    header('location:home.php');
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    $select_users = $conn->prepare("SELECT * FROM `tbl_users` WHERE email = ? AND password = ?");
    $select_users->execute([$email, $password]);
    if ($select_users->rowCount() > 0) {
        $fetch_user_id = $select_users->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user_id'] = $fetch_user_id['user_id'];
        header('location:home.php');
    } else {
        $_SESSION['unsuccess'] = 'Incorrect email or password';
        header('location:login.php');
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
    <link rel="icon" href="images/home/pet-logo.png" type="image/x-icon" />


    <title>User Login</title>
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
                            <h3>Sign In</h3>
                        </div>
                        <form action="" method="post">
                            <div class="form-group first">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email">

                            </div>
                            <div class="form-group last mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">

                            </div>

                            <input type="submit" style="background-color: #704130; border: none;" name="login" value="Log In" class="btn btn-block btn-primary">
                            <a href="register.php" style="float: right;">Register here</a>
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
    <?php
    if (isset($_SESSION['unsuccess'])) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: '" . $_SESSION['unsuccess'] . "',
                });
              </script>";
        unset($_SESSION['unsuccess']);
    }
    ?>
</body>

</html>