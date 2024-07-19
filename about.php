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
                            <a class="nav-link active" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adopt.php">Adopt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="news_announcement.php">News & Announcement</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#footer">Contact</a>
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


    <!-- NEWS & ANNOUNCEMENT SECTION -->
    <div class="news-section">
        <div class="container">
            <h1 class="mt-5" style="text-align: center;">About Us</h1>
            <p class="lead" style="text-align: justify;">We are dedicated to rescuing and finding loving homes for abandoned and mistreated pets. Our commitment extends beyond adoption; we rehabilitate each animal, providing medical care, training, and affection until they are ready for their forever families. Through education and community outreach, we advocate for responsible pet ownership, striving to reduce homelessness among pets in our community. Our ultimate goal is to ensure every pet receives the love and care they deserve, creating happier lives for both animals and their human companions.</p>

            <hr class="featurette-divider">

            <!-- Mission Section -->
            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="featurette-heading fw-normal lh-1">Mission</h2>
                    <p class="lead" style="text-align: justify;">Our mission is to rescue and find loving homes for abandoned and mistreated pets. We strive to rehabilitate each animal, providing them with medical care, training, and affection until they are ready to be adopted into caring families. Through education and community outreach, we advocate for responsible pet ownership and strive to reduce the number of homeless pets in our community. Our ultimate goal is to ensure that every pet receives the love and care they deserve, creating happier lives for both animals and their human companions.</p>
                </div>
                <div class="col-md-5">
                    <img src="https://i3.cpcache.com/product/977275538/pets_adoption_saves_lifes_banner.jpg?height=630&width=630&qv=90" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" role="img" aria-label="Mission Image" alt="Mission Image">
                </div>
            </div>

            <hr class="featurette-divider">

            <!-- Vision Section -->
            <div class="row featurette">
                <div class="col-md-7 order-md-2">
                    <h2 class="featurette-heading fw-normal lh-1">Vision</h2>
                    <p class="lead" style="text-align: justify;">Our vision is a world where every pet has a loving and caring home, free from neglect and cruelty. We envision communities where pet adoption is the preferred choice, where all pets are seen as valuable members of families. Through innovative programs and partnerships, we aim to create sustainable solutions to pet overpopulation and abandonment. By fostering a culture of compassion and responsibility, we believe we can make a significant impact on the lives of animals, ensuring they live in environments filled with love, respect, and dignity.</p>
                </div>
                <div class="col-md-5 order-md-1">
                    <img src="https://i3.cpcache.com/product/977275538/pets_adoption_saves_lifes_banner.jpg?height=630&width=630&qv=90" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" role="img" aria-label="Vision Image" alt="Vision Image">
                </div>
            </div>

            <hr class="featurette-divider">
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>