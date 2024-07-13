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
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adopt.php">Adopt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#available_pet">News & Announcement</a>
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

    <!-- NEWS SECTION -->
    <div class="news-section">
        <div class="container">
            <div class="p-4 p-md-5 mt-5 mb-4 rounded text-body-emphasis bg-body-secondary">
                <div class="col-lg-6 px-0">
                    <h1 class="display-4 fst-italic">News & Announcement</h1>
                    <p class="lead my-3">Currently happening</p>
                </div>
            </div>

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
                                    <a href="single_news.php" class="stretched-link">Continue reading</a>
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

                <!-- PAGINATION -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">1 <span class="visually-hidden">(current)</span></a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>





        <!-- FOOTER -->
        <footer id="footer" style="background-color: #704130 !important;" class="bg-dark text-white py-4 mt-5">
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