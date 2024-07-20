<?php
include 'database/connection.php';

// DISPLAY FULLNAME IF LOGGED IN
session_start();
$is_authenticated = isset($_SESSION['user_id']);

if ($is_authenticated) {
    $user_id = $_SESSION['user_id'];
    $get_user = "SELECT fullname, email, contact, address FROM `tbl_users` WHERE user_id = ?";
    $stmt = $conn->prepare($get_user);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_fullname'] = $user['fullname'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_contact'] = $user['contact'];
        $_SESSION['user_address'] = $user['address'];
    } else {
        $is_authenticated = false;
    }
} else {
    header("Location: login.php");
    exit;
}

$fetch_user = $conn->prepare("SELECT fullname, email, address, contact FROM `tbl_users` WHERE user_id = ?");
$fetch_user->execute([$user_id]);
$user = $fetch_user->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (!empty($password)) {
        if ($password === $confirmPassword) {
            $hashed_password = sha1($password);
            $update_query = "UPDATE `tbl_users` SET fullname = ?, email = ?, address = ?, contact = ?, password = ? WHERE user_id = ?";
            $stmt = $conn->prepare($update_query);
            $success = $stmt->execute([$fullname, $email, $address, $contact, $hashed_password, $user_id]);

            if ($success) {
                $_SESSION['profile_update_success'] = "Updated successfully";
            } else {
                $_SESSION['profile_update_error'] = "Not updated successfully";
            }
        } else {
            $_SESSION['profile_update_error'] = "Password and confirm password do not match";
        }
    } else {
        $update_query = "UPDATE `tbl_users` SET fullname = ?, email = ?, address = ?, contact = ? WHERE user_id = ?";
        $stmt = $conn->prepare($update_query);
        $success = $stmt->execute([$fullname, $email, $address, $contact, $user_id]);

        if ($success) {
            $_SESSION['profile_update_success'] = "Updated successfully";
        } else {
            $_SESSION['profile_update_error'] = "Not updated successfully";
        }
    }

    header('location:profile.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Adoption Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="images/home/pet-logo.png" type="image/x-icon" />

</head>

<body>

    <!-- HEADER NAVBAR -->
    <header style="background-color: #704130; border-bottom: 3px solid black;">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a style="color: white !important;" class="navbar-brand" href="#"> <img style="height: 75px;" src="images/home/pet-logo.png" alt="">
                    Pet-Ko.</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adopt.php">Adopt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="news_announcement.php">News & Announcement</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item dropdown" style="background-color: black; border-radius: 50px;">
                            <?php
                            if (isset($user_id)) { ?>
                                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> Hi <?php echo htmlspecialchars($user['fullname']); ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="my_adoption.php">My adoption</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                </ul>
                            <?php
                            } else {
                            ?>
                                <a href="login.php" style="text-decoration: none !important" class="nav-link">
                                    <i class="fas fa-user"></i> Login
                                </a>
                            <?php
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <!-- ADOPT SECTION -->
    <div class="adopt-section">
        <div class="container">
            <h1 class="mt-5">My Profile</h1>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="list-home">My profile</a><br>
                        <img style="height: auto; width: auto;" src="https://tse4.mm.bing.net/th?id=OIP.jixXH_Els1MXBRmKFdMQPAHaHa&pid=Api&P=0&h=180" alt="">
                    </div>
                </div>
                <div class="col-md-8 mt-5">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                            <form method="post" action="">
                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Fullname</label>
                                    <input style="border: 2px solid grey" type="text" class="form-control" id="fullname" name="fullname" placeholder="Fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input style="border: 2px solid grey" type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input style="border: 2px solid grey" type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="contact" class="form-label">Contact</label>
                                    <input style="border: 2px solid grey" type="text" class="form-control" id="contact" name="contact" placeholder="Contact" value="<?php echo htmlspecialchars($user['contact']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input style="border: 2px solid grey" type="password" class="form-control" id="password" name="password" placeholder="Password">
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <input style="border: 2px solid grey" type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
                                </div>
                                <div class="modal-footer border-0 mb-1">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
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

</body>

</html>