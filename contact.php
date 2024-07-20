<?php
include 'database/connection.php';

session_start();

// DISPLAY FULLNAME IF LOGGED IN
$fullname = '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $get_user = "SELECT fullname FROM `tbl_users` WHERE user_id = $user_id";
    $stmt = $conn->query($get_user);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $fullname = $user['fullname'];
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
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="images/home/pet-logo.png" type="image/x-icon" />
    <style>
        .contact-section {
            background-color: #f8f9fa;
            padding: 50px 0;
        }

        .contact-info {
            padding: 20px;
        }

        .map-responsive {
            overflow: hidden;
            padding-bottom: 56.25%;
            position: relative;
            height: 0;
        }

        .map-responsive iframe {
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            position: absolute;
        }
    </style>

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
                            <a class="nav-link active" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item dropdown" style="background-color: black; border-radius: 50px;">
                            <?php
                            if (isset($user_id)) { ?>
                                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> Hi <?php echo htmlspecialchars($fullname); ?>
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


    <!-- CONTACT SECTION -->
    <div class="contact-section">
        <div class="container">
            <div class="row">
                <div style="border: 2px solid #704130; border-radius: 50px;" class="col-md-6 contact-info">
                    <h2>Contact Us</h2>
                    <p class="lead mt-5">Pet-Ko.</p>
                    <hr>
                    <p class="lead">Email: info@petkosystem</p>
                    <p class="lead">Location: Calingatan Mataasnakahoy Batangas</p>
                    <p class="lead">Phone: 0968-574-8302</p>
                </div>
                <div class="col-md-6">
                    <div class="map-responsive">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12345.6789123456!2d121.0828023!3d13.9501234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd7b9b7a32b2d7%3A0xd19f50a3cd9e8e73!2sCalingatan%2C%20Mataasnakahoy%2C%20Batangas%2C%20Philippines!5e0!3m2!1sen!2sus!4v1600332418016!5m2!1sen!2sus" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>