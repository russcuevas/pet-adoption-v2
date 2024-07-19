<?php
include 'database/connection.php';

session_start();

// DISPLAY FULLNAME IF LOGGED IN
$is_authenticated = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);

// Get user's full name if authenticated
$fullname = '';
if ($is_authenticated) {
    $user_id = $_SESSION['user_id'];
    $get_user = "SELECT fullname FROM `tbl_users` WHERE user_id = ?";
    $stmt = $conn->prepare($get_user);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $fullname = $user['fullname'];
    }
}

// Requesting post
if (isset($_POST['request'])) {
    $user_id = $_POST['user_id'];
    $pet_name = htmlspecialchars($_POST['pet_name']);
    $pet_age = isset($_POST['pet_age']) ? htmlspecialchars($_POST['pet_age']) : null;
    $pet_type = htmlspecialchars($_POST['pet_type']);
    $pet_breed = htmlspecialchars($_POST['pet_breed']);
    $pet_condition = htmlspecialchars($_POST['pet_condition']);

    if ($pet_condition === "in sick") {
        $specific_sickness = isset($_POST['specific_sickness']) ? htmlspecialchars($_POST['specific_sickness']) : null;
        if (!empty($specific_sickness)) {
            $pet_condition .= " - Specific: " . $specific_sickness;
        }
    }

    $target_dir = "images/pet-images/";
    $file_name = basename($_FILES["pet_image"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (!empty($_FILES["pet_image"]["tmp_name"])) {
        $check = getimagesize($_FILES["pet_image"]["tmp_name"]);
        if ($check === false) {
            $uploadOk = 0;
        }
    } else {
        $uploadOk = 0;
    }

    if ($_FILES["pet_image"]["size"] > 500000) {
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
    }

    $timestamp = time();
    $file_name = "{$timestamp}_{$file_name}";
    $target_file = $target_dir . $file_name;

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["pet_image"]["tmp_name"], $target_file)) {
            $pet_status = "Requesting";

            $relative_path = $file_name;
            $sql = "INSERT INTO tbl_pets (user_id, pet_name, pet_age, pet_type, pet_breed, pet_condition, pet_status, pet_image, created_at, updated_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$user_id, $pet_name, $pet_age, $pet_type, $pet_breed, $pet_condition, $pet_status, $relative_path]);

            $_SESSION['post_adopt_success'] = "Post for your pet successfully, Please wait for the approval of the admin";
            header("Location: adopt.php");
            exit();
        } else {
            $_SESSION['post_adopt_error'] = "Sorry, there was an error uploading your file.";
        }
    } else {
        $_SESSION['post_adopt_error'] = "Sorry, your file was not uploaded. Make sure it is an image file and less than 500KB.";
    }
}

// READ THE PETS FOR ADOPTION
$get_pets_base_query = 'SELECT p.pet_id, p.pet_name, p.pet_age, p.pet_type, p.pet_breed, p.pet_condition, p.pet_status, p.pet_image, p.created_at,
                        u.fullname AS owner_name, u.address AS owner_address, u.contact AS owner_contact, u.email AS owner_email
                     FROM tbl_pets p
                     LEFT JOIN tbl_users u ON p.user_id = u.user_id 
                     WHERE p.pet_status = "For adoption"';

if ($is_authenticated) {
    $get_pets_query = $get_pets_base_query . ' AND p.user_id <> :user_id LIMIT 6';
    $get_stmt = $conn->prepare($get_pets_query);
    $get_stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $get_stmt->execute();
    $pets = $get_stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $get_pets_query = $get_pets_base_query . ' LIMIT 6';
    $get_stmt = $conn->prepare($get_pets_query);
    $get_stmt->execute();
    $pets = $get_stmt->fetchAll(PDO::FETCH_ASSOC);
}

// PAGINATION
$items_per_page = 6;
$total_items = 0;

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;
$count_query = 'SELECT COUNT(*) AS total FROM tbl_pets WHERE pet_status = "For adoption"';
if ($is_authenticated) {
    $count_query .= ' AND user_id <> :user_id';
}
$count_stmt = $conn->prepare($count_query);
if ($is_authenticated) {
    $count_stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
}
$count_stmt->execute();
$total_items = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];

$get_pets_paginated = $get_pets_base_query;
if ($is_authenticated) {
    $get_pets_paginated .= ' AND p.user_id <> :user_id';
}
$get_pets_paginated .= ' LIMIT :offset, :items_per_page';
$get_stmt = $conn->prepare($get_pets_paginated);
if ($is_authenticated) {
    $get_stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
}
$get_stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$get_stmt->bindValue(':items_per_page', $items_per_page, PDO::PARAM_INT);
$get_stmt->execute();
$pets = $get_stmt->fetchAll(PDO::FETCH_ASSOC);
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


    <!-- ADOPT SECTION -->
    <div class="adopt-section">
        <div class="container">
            <div class="container px-4 py-5" id="custom-cards">
                <!-- IF LOGIN IT WILL SHOW IF NOT IT IS BLANK -->
                <?php if ($is_authenticated) : ?>
                    <h2 class="pb-2">Post to adopt</h2>
                    <div class="mb-4">
                        <button class="btn btn-primary" style="background-color: #704130 !important; border: none;" data-bs-toggle="modal" data-bs-target="#postPet">Post your pet to adopt +</button>
                    </div>
                    <hr class="featurette-divider">
                <?php else : ?>
                    <h2 class="pb-2">Post to adopt</h2>
                    <div class="mb-4">
                        <button class="btn btn-primary" style="background-color: #704130 !important; border: none;" id="postPetBtn">Post your pet to adopt +</button>
                    </div>
                    <hr class="featurette-divider">
                <?php endif; ?>

                <h2 class="pb-2">Available Pets</h2>
                <!-- Filter Section -->
                <div>
                    <form action="" id="search-form">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="search-filter" class="form-label">Search Type/Breed:</label>
                                <input type="text" class="form-control" id="search-filter" placeholder="Please search here..">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary mt-2 mb-4" style="background-color: #704130 !important; border: none;" onclick="searchFilters()">Search</button>
                    </form>
                </div>

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
                                <label for="age-filter" class="form-label">Age (years):</label>
                                <div class="input-group">
                                    <select class="form-control" id="age-filter">
                                        <option value="">Select Age</option>
                                        <!-- Options will be dynamically generated by JavaScript -->
                                    </select>
                                </div>
                            </div>



                        </div>
                        <button type="button" class="btn btn-primary mt-2" style="background-color: #704130 !important; border: none;" onclick="applyFilters()">Apply Filters</button>
                    </form>


                </div>

                <?php if (empty($pets)) : ?>
                    <div style="border: 2px solid #704130; padding: 20px;">
                        <h1 style="text-align: center; font-weight: bold; color: brown;">No pets available</h1>
                    </div>
                <?php else : ?>
                    <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
                        <?php foreach ($pets as $pet) : ?>
                            <div class="col">
                                <form class="adoptForm" action="ajax/adoption.php" method="POST" id="adoptForm_<?php echo $pet['pet_id']; ?>">
                                    <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('unsplash-photo-1.jpg');">
                                        <div class="badge bg-success mt-3">For Adoption</div>
                                        <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                            <img style="border-radius: 50px; height: 200px;" src="images/pet-images/<?php echo $pet['pet_image'] ?>" alt="">
                                            <h3 style="font-size: 20px;" class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Type: <?php echo $pet['pet_type'] ?></h3>
                                            <p class="pet-breed" style="font-size: 20px; margin: 0px !important;">Breed: <?php echo $pet['pet_breed'] ?></p>
                                            <p style="font-size: 20px; margin: 0px !important;">Name: <?php echo $pet['pet_name'] ?></p>
                                            <p class="pet-age" style="font-size: 20px; margin: 0px !important;">Age: <?php echo $pet['pet_age'] ?></p>
                                            <p style="font-size: 20px;">Condition: <?php echo $pet['pet_condition'] ?></p>
                                            <ul class="d-flex list-unstyled mt-auto">
                                                <li class="me-auto">
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white">
                                                </li>
                                                <li class="d-flex align-items-center me-6">
                                                    <svg class="bi me-2" width="1em" height="1em">
                                                        <use xlink:href="#geo-fill" />
                                                    </svg>
                                                    <small><?php echo $pet['owner_name'] ?></small>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <svg class="bi me-2" width="1em" height="1em">
                                                        <use xlink:href="#calendar3" />
                                                    </svg>
                                                    <small><?php echo date('Y-m-d', strtotime($pet['created_at'])) ?></small>
                                                </li>
                                            </ul>
                                            <?php if ($is_authenticated) : ?>
                                                <input type="hidden" name="pet_id" value="<?php echo $pet['pet_id']; ?>">
                                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                                <?php
                                                $check_requests = "SELECT COUNT(*) AS num_requests FROM tbl_adoption WHERE user_id = ? AND remarks = 'Requesting'";
                                                $stmt_check = $conn->prepare($check_requests);
                                                $stmt_check->execute([$_SESSION['user_id']]);
                                                $num_requests = $stmt_check->fetch(PDO::FETCH_ASSOC)['num_requests'];
                                                ?>
                                                <button type="submit" id="adoptButton_<?php echo $pet['pet_id']; ?>" style="background-color: #704130 !important; border: none;" class="btn btn-primary<?php echo ($num_requests > 0) ? ' d-none' : ''; ?>">Adopt</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php endforeach; ?>

                    </div>


                    <!-- PAGINATION -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item<?php if ($current_page <= 1) echo ' disabled'; ?>">
                                <a class="page-link" href="?page=<?php echo max(1, $current_page - 1); ?>" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <?php
                            $total_pages = ceil($total_items / $items_per_page);
                            for ($i = 1; $i <= $total_pages; $i++) : ?>
                                <li class="page-item<?php if ($i == $current_page) echo ' active'; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item<?php if ($current_page >= $total_pages) echo ' disabled'; ?>">
                                <a class="page-link" href="?page=<?php echo min($total_pages, $current_page + 1); ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                <?php endif ?>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="postPet" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">

                        <div class="modal-header border-0">
                            <h5 class="modal-title">
                                <span class="fw-mediumbold"> Post pet for adopt</span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label>Pet Image</label><br>
                                <input type="file" id="pet_image" name="pet_image" accept="image/*"><br><br>
                                <img id="diplay_pet_image" style="height: 70px;" src="https://cdn4.iconfinder.com/data/icons/documents-36/25/add-picture-1024.png" alt="">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pet Name</label>
                                        <input style="border: 2px solid grey;" type="text" class="form-control" name="pet_name" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pet Age</label>
                                        <input style="border: 2px solid grey;" type="text" class="form-control" name="pet_age" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pet Type</label>
                                        <select style="border: 2px solid grey;" class="form-select" name="pet_type">
                                            <option value="Dog">Dog</option>
                                            <option value="Cat">Cat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pet Breed</label>
                                        <input style="border: 2px solid grey;" type="text" class="form-control" name="pet_breed" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="petCondition">Pet Condition</label>
                                <select style="border: 2px solid grey;" class="form-select" id="petCondition" name="pet_condition" onchange="toggleInput()">
                                    <option value="healthy">Healthy</option>
                                    <option value="in sick">In sick</option>
                                </select>
                                <div id="specificSickInput" style="display: none;">
                                    <label for="specificSick">Specific sickness:</label>
                                    <input style="border: 2px solid grey;" type="text" class="form-control" id="specificSickInput" name="specific_sickness">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer border-0">
                            <input type="submit" name="request" class="btn btn-primary" style="background-color: #704130 !important; border: none;" value="Add">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="assets/js/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- PET CHANGE IMAGE -->
        <script>
            document.getElementById('pet_image').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('diplay_pet_image').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
        <!-- END PET CHANGE -->

        <script>
            // DYNAMIC FILTERRING
            document.addEventListener('DOMContentLoaded', function() {
                var ageFilterSelect = document.getElementById('age-filter');

                for (var i = 1; i <= 99; i++) {
                    var option = document.createElement('option');
                    option.value = i.toString();
                    option.textContent = i.toString();
                    ageFilterSelect.appendChild(option);
                }

                ageFilterSelect.addEventListener('change', function() {
                    applyFilters();
                });

                applyFilters();
            });

            function applyFilters() {
                var typeFilter = document.getElementById('type-filter').value.toLowerCase();
                var breedFilter = document.getElementById('breed-filter').value.toLowerCase();
                var ageFilter = document.getElementById('age-filter').value;

                var cards = document.querySelectorAll('.col');

                cards.forEach(function(card) {
                    var petType = card.querySelector('.display-6').textContent.toLowerCase();
                    var petBreed = card.querySelector('.pet-breed').textContent.toLowerCase();
                    var petAgeText = card.querySelector('.pet-age').textContent.trim();
                    var petAge = parseInt(petAgeText.split(':')[1].trim());

                    var showCard = true;

                    if (typeFilter && petType.indexOf(typeFilter) === -1) {
                        showCard = false;
                    }

                    if (breedFilter && petBreed.indexOf(breedFilter) === -1) {
                        showCard = false;
                    }

                    if (ageFilter) {
                        var selectedAge = parseInt(ageFilter);

                        if (isNaN(petAge)) {
                            showCard = false;
                        } else if (petAge !== selectedAge) {
                            showCard = false;
                        }
                    }

                    if (showCard) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
        </script>


        <script>
            function searchFilters() {
                var input, filter, cards, card, petType, petBreed, i, txtValue;
                input = document.getElementById('search-filter');
                filter = input.value.toUpperCase();
                cards = document.getElementsByClassName('col');

                for (i = 0; i < cards.length; i++) {
                    card = cards[i];
                    petType = card.getElementsByClassName('display-6')[0];
                    petBreed = card.getElementsByTagName('p')[0];

                    txtValue = petType.textContent || petType.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1 || petBreed.textContent.toUpperCase().indexOf(filter) > -1) {
                        card.style.display = "";
                    } else {
                        card.style.display = "none";
                    }
                }
            }
        </script>


        <!-- CREATE-->
        <?php if (isset($_SESSION['post_adopt_success'])) : ?>
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '<?php echo $_SESSION['post_adopt_success']; ?>',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
            <?php unset($_SESSION['post_adopt_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['post_adopt_error'])) : ?>
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '<?php echo $_SESSION['post_adopt_error']; ?>',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
            <?php unset($_SESSION['post_adopt_error']); ?>
        <?php endif; ?>

        <!-- END CREATE -->
        <script>
            $(document).ready(function() {
                $('.adoptForm').on('submit', function(event) {
                    event.preventDefault();

                    var form = $(this);
                    var formData = form.serialize();
                    var submitButton = form.find('[type=submit]');
                    var petId = form.attr('id').replace('adoptForm_', '');

                    Swal.fire({
                        title: 'Confirm Adoption',
                        text: 'Are you sure you want to request an adoption for this pet?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, adopt!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'ajax/adoption.php',
                                type: 'POST',
                                data: formData,
                                dataType: 'json',
                                success: function(response) {
                                    console.log(response);
                                    if (response.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: response.message,
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: response.message
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Failed to submit adopt request. Please try again.',
                                        confirmButtonText: 'OK'
                                    });
                                },
                                beforeSend: function() {
                                    submitButton.prop('disabled', true);
                                },
                                complete: function() {
                                    submitButton.prop('disabled', false);
                                }
                            });
                        }
                    });
                });
            });
        </script>

        <script>
            function toggleInput() {
                var selectBox = document.getElementById("petCondition");
                var specificSickInput = document.getElementById("specificSickInput");

                if (selectBox.value === "in sick") {
                    specificSickInput.style.display = "block";
                } else {
                    specificSickInput.style.display = "none";
                }
            }
        </script>

        <script>
            $(document).ready(function() {
                $('#postPetBtn').click(function() {
                    <?php if (!$is_authenticated) : ?>
                        Swal.fire({
                            icon: 'info',
                            title: 'Please login first to post a pet',
                            confirmButtonColor: '#704130'
                        });
                    <?php endif; ?>
                });
            });
        </script>
</body>

</html>