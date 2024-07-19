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

// FETCH NEWS AND ANNOUNCEMENTS
$get_news = "SELECT * FROM `tbl_news_announcement` LIMIT 4";
$get_stmt = $conn->query($get_news);
$announcements = $get_stmt->fetchAll(PDO::FETCH_ASSOC);


// READ THE PETS FOR ADOPTION
if ($is_authenticated) {
    $get_pets = 'SELECT p.pet_id, p.pet_name, p.pet_age, p.pet_type, p.pet_breed, p.pet_condition, p.pet_status, p.pet_image, p.created_at,
                    u.fullname AS owner_name, u.address AS owner_address, u.contact AS owner_contact, u.email AS owner_email
                 FROM tbl_pets p
                 LEFT JOIN tbl_users u ON p.user_id = u.user_id 
                 WHERE p.pet_status = "For adoption" 
                     AND p.user_id <> ?
                 LIMIT 3';
    $get_stmt = $conn->prepare($get_pets);
    $get_stmt->execute([$_SESSION['user_id']]);
    $pets = $get_stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $get_pets = 'SELECT p.pet_id, p.pet_name, p.pet_age, p.pet_type, p.pet_breed, p.pet_condition, p.pet_status, p.pet_image, p.created_at,
                    u.fullname AS owner_name, u.address AS owner_address, u.contact AS owner_contact, u.email AS owner_email
                 FROM tbl_pets p
                 LEFT JOIN tbl_users u ON p.user_id = u.user_id 
                 WHERE p.pet_status = "For adoption"
                 LIMIT 3';
    $get_stmt = $conn->prepare($get_pets);
    $get_stmt->execute();
    $pets = $get_stmt->fetchAll(PDO::FETCH_ASSOC);
}
// END PETS

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
                    <div class="card border-0 shadow-sm" style="border: 2px solid #704130 !important">
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
                    <div class="card border-0 shadow-sm" style="border: 2px solid #704130 !important">
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
                    <div class="card border-0 shadow-sm" style="border: 2px solid #704130 !important">
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
            <?php if (empty($announcements)) : ?>
                <div style="border: 2px solid #704130; padding: 20px;">
                    <h1 style="text-align: center; font-weight: bold; color: brown;">No news and announcements posted</h1>
                </div>
            <?php else : ?>
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
                <a style="display: flex; align-items: center; justify-content: center;" href="news_announcement.php">View all</a>
            <?php endif ?>
        </div>
        <br>
        <br>
        <br>

        <h2 class="pb-2">List of Available Pets</h2>
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
            <?php endif ?>
            </div>
            <?php if (!empty($pets)) : ?>
                <a style="display: flex; align-items: center; justify-content: center;" href="adopt.php">View all</a>
            <?php endif ?>
    </div>

    <!-- FOOTER -->
    <footer id="footer" style="background-color: #704130 !important;" class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; 2024 Russel Vincent Cuevas, John Dave De Leon, Archie De Vera</p>
            <p>Contact us at info@petkosystem</p>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

</body>

</html>