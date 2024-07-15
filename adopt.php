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
                            <a class="nav-link active" href="adopt.php">Adopt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="news_announcement.php">News & Announcement</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#footer">Contact</a>
                        </li>
                        <li class="nav-item" style="background-color: black; border-radius: 50px;">
                            <a href="login.php" style="text-decoration: none !important" class="nav-link">
                                <i class="fas fa-user"></i> Login
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <!-- ADOPT SECTION -->
    <div class="adopt-section">
        <div class="container">
            <div class="container px-4 py-5" id="custom-cards">
                <!-- IF LOGIN IT WILL SHOW IF NOT IT IS BLANK -->
                <h2 class="pb-2">Post to adopt</h2>
                <div class="mb-4">
                    <button class="btn btn-primary" style="background-color: #704130 !important; border: none;" data-bs-toggle="modal" data-bs-target="#postPet">Post your pet to adopt +</button>
                </div>
                <hr class="featurette-divider">

                <h2 class="pb-2">Available Pets</h2>
                <!-- Filter Section -->
                <div class="mb-4">
                    <form id="filter-form">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="type-filter" class="form-label">Type:</label>
                                <select class="form-select" id="type-filter">
                                    <option value="">All Types</option>
                                    <option value="dog">Dog</option>
                                    <option value="cat">Cat</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="breed-filter" class="form-label">Breed:</label>
                                <input type="text" class="form-control" id="breed-filter" placeholder="Enter breed">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="age-filter" class="form-label">Age Range (years):</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="age-filter" placeholder="E.g., 1-5">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary mt-2" style="background-color: #704130 !important; border: none;" onclick="applyFilters()">Apply Filters</button>
                    </form>
                </div>

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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="postPet" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">
                            <span class="fw-mediumbold"> Post pet for adopt</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Pet Image</label><br>
                                    <input type="file"><br><br>
                                    <img style="height: 70px;" src="https://th.bing.com/th/id/OIP.mA_5Jzd0hjmCnEBy3kNhIAHaFB?rs=1&pid=ImgDetMain" alt="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pet Name</label>
                                    <input style="border: 2px solid grey;" type="text" class="form-control" placeholder="" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pet Age <span style="font-size: 10px; color: red;">(leave blank if you dont know*)</span></label>
                                    <input style="border: 2px solid grey;" type="text" class="form-control" placeholder="" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pet Type</label>
                                    <select style="border: 2px solid grey;" class="form-select" id="exampleFormControlSelect1">
                                        <option>Dog</option>
                                        <option>Cat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pet Breed</label>
                                    <input style="border: 2px solid grey;" type="text" class="form-control" placeholder="" required />
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="petCondition">Pet Condition</label>
                                    <select style="border: 2px solid grey;" class="form-select" id="petCondition" onchange="toggleInput()">
                                        <option value="healthy">Healthy</option>
                                        <option value="sick">In sick</option>
                                    </select>
                                    <div id="specificSickInput" style="display: none;">
                                        <label for="specificSick">Specific sickness:</label>
                                        <input style="border: 2px solid grey" type="text" class="form-control" id="specificSick" name="specificSick">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <input type="submit" class="btn btn-primary" style="background-color: #704130 !important; border: none;" value="Add">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        function toggleInput() {
            var selectBox = document.getElementById("petCondition");
            var specificSickInput = document.getElementById("specificSickInput");

            if (selectBox.value === "sick") {
                specificSickInput.style.display = "block";
            } else {
                specificSickInput.style.display = "none";
            }
        }
    </script>
</body>

</html>