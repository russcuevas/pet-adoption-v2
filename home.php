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
                        <li class="nav-item" style="background-color: black; border-radius: 50px;">
                            <a href="#" data-toggle="modal" data-target="#loginModal" style="text-decoration: none !important" class="nav-link">
                                <i class="fas fa-user"></i> Login
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- MODAL AUTH -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #704130;">
                    <h5 class="modal-title" id="loginModalLabel"></h5>
                    <button style="background: black;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-weight: 900; color: white;">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="loginForm">
                        <form method="POST">
                            <h5>Login</h5><br>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Password" required>
                            </div>
                            <br>
                            <div style="display: flex; justify-content: flex-end;">
                                <button type="submit" class="btn btn-primary" style="background-color: #704130; border: none !important;">Login</button>
                            </div>
                            <p class="mt-2">Don't have an account? Click here to <a href="#" id="showRegister">Sign Up</a></p>
                        </form>
                    </div>
                    <div id="registerForm" style="display: none;">
                        <form method="POST">
                            <h5>Register</h5><br>
                            <div class="form-group">
                                <label for="registerEmail">Email address</label>
                                <input type="email" class="form-control" id="registerEmail" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label for="registerPassword">Password</label>
                                <input type="password" class="form-control" id="registerPassword" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" placeholder="Enter address" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" class="form-control" id="phone" placeholder="Enter phone number" required>
                            </div>
                            <br>
                            <div style="display: flex; justify-content: flex-end;">
                                <button type="submit" class="btn btn-primary" style="background-color: #704130; border: none !important;">Register</button>
                            </div>
                        </form>
                        <p class="mt-2">Already have an account? Click here to <a href="#" id="showLogin">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-success mb-2">News & Announcement</h5>
                                <h3 class="card-title">Title</h3>
                                <p class="card-text mb-1"><small class="text-muted">Nov 11</small></p>
                                <p class="card-text">This is a sample description. It can be a bit longer to demonstrate how the card layout handles more text.</p>
                                <a href="#" class="stretched-link">Continue reading</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <img style="height: auto; width: auto" src="https://th.bing.com/th/id/OIP.j746v7OdUjPc9M9IUq00mwHaE8?rs=1&pid=ImgDetMain" alt="Image" class="img-fluid rounded-start">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-success mb-2">News & Announcement</h5>
                                <h3 class="card-title">Title</h3>
                                <p class="card-text mb-1"><small class="text-muted">Nov 11</small></p>
                                <p class="card-text">This is a sample description. It can be a bit longer to demonstrate how the card layout handles more text.</p>
                                <a href="#" class="stretched-link">Continue reading</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <img style="height: auto; width: auto" src="https://th.bing.com/th/id/OIP.j746v7OdUjPc9M9IUq00mwHaE8?rs=1&pid=ImgDetMain" alt="Image" class="img-fluid rounded-start">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-success mb-2">News & Announcement</h5>
                                <h3 class="card-title">Title</h3>
                                <p class="card-text mb-1"><small class="text-muted">Nov 11</small></p>
                                <p class="card-text">This is a sample description. It can be a bit longer to demonstrate how the card layout handles more text.</p>
                                <a href="#" class="stretched-link">Continue reading</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <img style="height: auto; width: auto" src="https://th.bing.com/th/id/OIP.j746v7OdUjPc9M9IUq00mwHaE8?rs=1&pid=ImgDetMain" alt="Image" class="img-fluid rounded-start">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-success mb-2">News & Announcement</h5>
                                <h3 class="card-title">Title</h3>
                                <p class="card-text mb-1"><small class="text-muted">Nov 11</small></p>
                                <p class="card-text">This is a sample description. It can be a bit longer to demonstrate how the card layout handles more text.</p>
                                <a href="#" class="stretched-link">Continue reading</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <img style="height: auto; width: auto" src="https://th.bing.com/th/id/OIP.j746v7OdUjPc9M9IUq00mwHaE8?rs=1&pid=ImgDetMain" alt="Image" class="img-fluid rounded-start">
                        </div>
                    </div>
                </div>
            </div>

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