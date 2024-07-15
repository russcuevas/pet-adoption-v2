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

// FETCH NEWS AND ANNOUNCEMENTS
$get_news = "SELECT * FROM `tbl_news_announcement` LIMIT 4";
$get_stmt = $conn->query($get_news);
$announcements = $get_stmt->fetchAll(PDO::FETCH_ASSOC);
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
                            <a class="nav-link active" href="home.php">Home</a>
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



    <!-- HOME SECTION -->
    <div class="home-section">
        <div class="container">
            <div class="row banner-section">
                <div class="col-md-6 banner-text">
                    <h1 class="h1-home">Welcome to <br> Pet-Connect System</h1>
                    <p style="text-align: justify;" class="home-p">Discover a world of care and companionship with our Pet-Connect. Whether
                        you’re adopting a new friend or ensuring your current pet's well-being, we're here to help.
                        From health monitoring to personalized care tips, we provide everything you need to keep your furry
                        family members happy and healthy.</p>
                </div>
                <div class="col-md-6 banner-img">
                    <img src="images/home/home-background.png" alt="Background Image">
                </div>
            </div>
        </div>
    </div>



    <div class="container px-4 py-5" id="custom-cards">
        <div class="container px-4 py-5" id="featured-3">
            <h2 class="pb-2" style="text-align: center;">Pet Care Tips</h2>
            <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
                <div class="col">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-4">
                            <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-gradient rounded-circle">
                                <img src="images/pet-care/dog.svg" alt="Dog Icon" width="32" height="32">
                            </div>
                            <h3 class="fs-4 text-body-emphasis mt-3">Grooming</h3>
                            <p class="card-text">Regular grooming keeps your pet clean and healthy.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-4">
                            <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-gradient rounded-circle">
                                <img src="images/pet-care/foot.svg" alt="Foot Icon" width="32" height="32">
                            </div>
                            <h3 class="fs-4 text-body-emphasis mt-3">Exercise</h3>
                            <p class="card-text">Provide daily exercise to keep your pet active and fit.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-4">
                            <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-gradient rounded-circle">
                                <img src="images/pet-care/cat.svg" alt="Cat Icon" width="32" height="32">
                            </div>
                            <h3 class="fs-4 text-body-emphasis mt-3">Nutrition</h3>
                            <p class="card-text">Feed your pet a balanced diet suitable for their age.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="pb-2 mb-5">News & Announcement</h2>
        <div class="row mb-2">
            <?php foreach ($announcements as $announcement) : ?>
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title text-success mb-2">News & Announcement</h5>
                                    <h3 class="card-title"><?php echo $announcement['event_title'] ?></h3>
                                    <p class="card-text mb-1"><small class="text-muted"><?php echo date_format(new DateTime($announcement['event_schedule']), 'F j Y / h:i A'); ?></small></p>
                                    <p class="card-text"><?php echo substr($announcement['event_description'], 0, 10) . '...' ?></p>
                                    <a href="single_news.php?event_id=<?php echo $announcement['event_id']; ?>" class="stretched-link">Continue reading</a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <img style="height: auto; width: auto" src="assets/event_image/<?php echo $announcement['event_image'] ?>" alt="Image" class="img-fluid rounded-start">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>

        </div>
        <a style="display: flex; align-items: center; justify-content: center;" href="news_announcement.php">View all</a>

        <br>
        <br>
        <br>

        <h2 class="pb-2">List of Available Pets</h2>
        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">

            <div class="col">
                <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('unsplash-photo-1.jpg');">
                    <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                        <img style="border-radius: 50px; height: 200px;" src="https://i0.wp.com/doggybiome.com/wp-content/uploads/2022/08/DoggyBiome-DogPlaying-1789057343-1660165325547.jpg?resize=1048%2C779&ssl=1" alt="">
                        <h3 style="font-size: 20px;" class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Type: Dog</h3>
                        <p style="font-size: 20px;">Breed: Sample</p>
                        <ul class="d-flex list-unstyled mt-auto">
                            <li class="me-auto">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white">
                            </li>
                            <li class="d-flex align-items-center me-3">
                                <svg class="bi me-2" width="1em" height="1em">
                                    <use xlink:href="#geo-fill" />
                                </svg>
                                <small>Russel Vincent Cuevas</small>
                            </li>
                            <li class="d-flex align-items-center">
                                <svg class="bi me-2" width="1em" height="1em">
                                    <use xlink:href="#calendar3" />
                                </svg>
                                <small>Today</small>
                            </li>
                        </ul>
                        <button style="background-color: #704130 !important; border: none;" class="btn btn-primary">Adopt</button>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('unsplash-photo-1.jpg');">
                    <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                        <img style="border-radius: 50px; height: 200px;" src="https://i0.wp.com/doggybiome.com/wp-content/uploads/2022/08/DoggyBiome-DogPlaying-1789057343-1660165325547.jpg?resize=1048%2C779&ssl=1" alt="">
                        <h3 style="font-size: 20px;" class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Type: Dog</h3>
                        <p style="font-size: 20px;">Breed: Sample</p>
                        <ul class="d-flex list-unstyled mt-auto">
                            <li class="me-auto">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white">
                            </li>
                            <li class="d-flex align-items-center me-3">
                                <svg class="bi me-2" width="1em" height="1em">
                                    <use xlink:href="#geo-fill" />
                                </svg>
                                <small>Russel Vincent Cuevas</small>
                            </li>
                            <li class="d-flex align-items-center">
                                <svg class="bi me-2" width="1em" height="1em">
                                    <use xlink:href="#calendar3" />
                                </svg>
                                <small>Today</small>
                            </li>
                        </ul>
                        <button style="background-color: #704130 !important; border: none;" class="btn btn-primary">Adopt</button>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('unsplash-photo-1.jpg');">
                    <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                        <img style="border-radius: 50px; height: 200px;" src="https://i0.wp.com/doggybiome.com/wp-content/uploads/2022/08/DoggyBiome-DogPlaying-1789057343-1660165325547.jpg?resize=1048%2C779&ssl=1" alt="">
                        <h3 style="font-size: 20px;" class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Type: Dog</h3>
                        <p style="font-size: 20px;">Breed: Sample</p>
                        <ul class="d-flex list-unstyled mt-auto">
                            <li class="me-auto">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white">
                            </li>
                            <li class="d-flex align-items-center me-3">
                                <svg class="bi me-2" width="1em" height="1em">
                                    <use xlink:href="#geo-fill" />
                                </svg>
                                <small>Russel Vincent Cuevas</small>
                            </li>
                            <li class="d-flex align-items-center">
                                <svg class="bi me-2" width="1em" height="1em">
                                    <use xlink:href="#calendar3" />
                                </svg>
                                <small>Today</small>
                            </li>
                        </ul>
                        <button style="background-color: #704130 !important; border: none;" class="btn btn-primary">Adopt</button>
                    </div>
                </div>
            </div>
        </div>
        <a style="display: flex; align-items: center; justify-content: center;" href="adopt.php">View all</a>
    </div>

    <!-- FOOTER -->
    <footer id="footer" style="background-color: #704130 !important;" class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; 2024 Russel Vincent Cuevas, John Dave De Leon, Archie De Vera</p>
            <p>Contact us at info@petkosystem</p>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>

</body>

</html>