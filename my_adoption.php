<?php
include 'database/connection.php';

// DISPLAY FULLNAME IF LOGGED IN
session_start();
$is_authenticated = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);

if (!$is_authenticated) {
    header('Location: login.php');
    exit();
}

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
}

$fullname = isset($_SESSION['user_fullname']) ? $_SESSION['user_fullname'] : '';


// READ POSTED PETS
$pets = [];

if ($is_authenticated) {
    $user_id = $_SESSION['user_id'];
    $get_pets = 'SELECT pet_id, pet_name, pet_age, pet_type, pet_breed, pet_condition, pet_status, pet_image, created_at
                 FROM tbl_pets
                 WHERE user_id = ?';
    $stmt = $conn->prepare($get_pets);
    $stmt->execute([$user_id]);
    $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// END READ

// READ MY ADOPTED PETS
$sql =
    "SELECT 
            p.pet_id,
            p.pet_image,
            p.pet_name,
            p.pet_age,
            p.pet_type,
            p.pet_breed,
            p.pet_condition,
            u.user_id AS pet_owner_id,
            u.fullname AS pet_owner_name,
            u.address AS pet_owner_address,
            u.contact AS pet_owner_contact,
            u.email AS pet_owner_email,
            a.user_id AS adopted_user_id,
            a.created_at AS adoption_date,
            a.remarks AS adoption_status,
            adopted_user.fullname AS adopted_user_fullname,
            adopted_user.address AS adopted_user_address,
            adopted_user.contact AS adopted_user_contact,
            adopted_user.email AS adopted_user_email
        FROM 
            tbl_pets p
        JOIN 
            tbl_users u ON p.user_id = u.user_id
        LEFT JOIN 
            tbl_adoption a ON p.pet_id = a.pet_id
        LEFT JOIN
            tbl_users adopted_user ON a.user_id = adopted_user.user_id
        WHERE 
           (a.remarks = 'Requesting' OR a.remarks = 'Ready to pick up' OR a.remarks = 'Completed')
            AND a.user_id = :user_id";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':user_id', $user_id);
$stmt->execute();
$adoptionDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
// END READ MY ADOPTED

// OTHERS ADOPTION REQUEST
$sql = "SELECT 
            p.pet_id,
            p.pet_image,
            p.pet_name,
            p.pet_age,
            p.pet_type,
            p.pet_breed,
            p.pet_condition,
            p.user_id AS pet_owner_id,
            u1.fullname AS pet_owner_name,
            u1.address AS pet_owner_address,
            u1.contact AS pet_owner_contact,
            u1.email AS pet_owner_email,
            a.adoption_id,
            a.user_id AS adopted_user_id,
            u2.fullname AS adopted_user_fullname,
            u2.address AS adopted_user_address,
            u2.contact AS adopted_user_contact,
            u2.email AS adopted_user_email,
            a.created_at AS adoption_date,
            a.remarks AS adoption_status
        FROM 
            tbl_pets p
        JOIN 
            tbl_users u1 ON p.user_id = u1.user_id
        LEFT JOIN 
            tbl_adoption a ON p.pet_id = a.pet_id
        LEFT JOIN
            tbl_users u2 ON a.user_id = u2.user_id
        WHERE 
            a.remarks = 'Requesting'
            AND p.user_id = :user_id";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':user_id', $user_id);
$stmt->execute();
$other_request = $stmt->fetchAll(PDO::FETCH_ASSOC);
// END OTHERS ADOPTION

// OTHERS ADOPTION REQUEST
$sql = "SELECT 
            p.pet_id,
            p.pet_image,
            p.pet_name,
            p.pet_age,
            p.pet_type,
            p.pet_breed,
            p.pet_condition,
            p.user_id AS pet_owner_id,
            u1.fullname AS pet_owner_name,
            u1.address AS pet_owner_address,
            u1.contact AS pet_owner_contact,
            u1.email AS pet_owner_email,
            a.adoption_id,
            a.user_id AS adopted_user_id,
            u2.fullname AS adopted_user_fullname,
            u2.address AS adopted_user_address,
            u2.contact AS adopted_user_contact,
            u2.email AS adopted_user_email,
            a.created_at AS adoption_date,
            a.remarks AS adoption_status
        FROM 
            tbl_pets p
        JOIN 
            tbl_users u1 ON p.user_id = u1.user_id
        LEFT JOIN 
            tbl_adoption a ON p.pet_id = a.pet_id
        LEFT JOIN
            tbl_users u2 ON a.user_id = u2.user_id
        WHERE 
            a.remarks = 'Ready to pick up'
            AND p.user_id = :user_id";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':user_id', $user_id);
$stmt->execute();
$to_pick_up = $stmt->fetchAll(PDO::FETCH_ASSOC);
// END OTHERS ADOPTION

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
            <h1 class="mt-5">My Adoption</h1>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="list-home">My posted pet</a>
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile">My adopted pet</a>
                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="list-messages">Adoption request</a>
                        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="list-settings">To pick up</a>

                    </div>
                </div>
                <div class="col-md-8 mt-5">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                            <div class="box mb-5" style="border: 2px solid brown; padding: 20px;">
                                <div class="filter-my-posted">
                                    <div class="col-md-4 mb-3">
                                        <label for="posted-filter" class="form-label">Status:</label>
                                        <select style="border: 2px solid grey;" class="form-select" id="posted-filter">
                                            <option value="">All status</option>
                                            <option value="For adoption">For adoption</option>
                                            <option value="Requesting">Requesting</option>
                                            <option value="Already adopt">Already adopt</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="example" class="table table-dark table-hover table-striped table-bordered">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Age</th>
                                                <th>Type</th>
                                                <th>Breed</th>
                                                <th>Condition</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($pets as $pet) : ?>
                                                <tr>
                                                    <td><img style="height: 75px;" src="images/pet-images/<?php echo $pet['pet_image'] ?>" alt=""></td>
                                                    <td><?php echo $pet['pet_name']; ?></td>
                                                    <td><?php echo $pet['pet_age']; ?></td>
                                                    <td><?php echo $pet['pet_type']; ?></td>
                                                    <td><?php echo $pet['pet_breed']; ?></td>
                                                    <td><?php echo $pet['pet_condition']; ?></td>
                                                    <td>
                                                        <?php if ($pet['pet_status'] === 'Requesting') : ?>
                                                            <p style="font-size: 13px; font-weight: 900; color: orange;"><?php echo htmlspecialchars($pet['pet_status']) ?></p>
                                                        <?php else : ?>
                                                            <p style="font-size: 13px; font-weight: 900; color: green;"><?php echo htmlspecialchars($pet['pet_status']) ?></p>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                            <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                <div class="box mb-5" style="border: 2px solid brown; padding: 20px;">
                                    <div class="filter">
                                        <div class="col-md-4 mb-3">
                                            <label for="adopted-filter" class="form-label">Status:</label>
                                            <select style="border: 2px solid grey;" class="form-select" id="adopted-filter">
                                                <option value="">All status</option>
                                                <option value="Requesting">Requesting</option>
                                                <option value="Ready to pick up">Ready to pick up</option>
                                                <option value="Completed">Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="example2" class="table table-dark table-hover table-striped table-bordered">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th>Owner Details</th>
                                                    <th>Pet Details</th>
                                                    <th>Adoptor Details</th>
                                                    <th>Date Adopted</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($adoptionDetails as $detail) : ?>
                                                    <tr>
                                                        <td>
                                                            <?php if ($detail['adoption_status'] === 'Ready to pick up') : ?>
                                                                <?php echo $detail['pet_owner_name']; ?><br>
                                                                <?php echo $detail['pet_owner_email']; ?>

                                                                <div style="border: 2px solid brown; padding: 20px;">
                                                                    <span style="color: brown; font-weight: 900;">You can contact this to pick up or go to provided address</span><br>
                                                                    <hr>
                                                                    <span style="color: green; font-weight: 900;"><?php echo $detail['pet_owner_address']; ?></span><br>
                                                                    <span style="color: green; font-weight: 900;"><?php echo $detail['pet_owner_contact']; ?></span><br>
                                                                </div>
                                                            <?php else : ?>
                                                                <?php echo $detail['pet_owner_name']; ?><br>
                                                                <?php echo $detail['pet_owner_address']; ?><br>
                                                                <?php echo $detail['pet_owner_contact']; ?><br>
                                                                <?php echo $detail['pet_owner_email']; ?>
                                                            <?php endif ?>
                                                        </td>
                                                        <td>
                                                            <img style="height: 75px;" src="images/pet-images/<?php echo $detail['pet_image'] ?>" alt="">
                                                            <?php echo $detail['pet_name']; ?><br>
                                                            <?php echo $detail['pet_age']; ?><br>
                                                            <?php echo $detail['pet_type']; ?><br>
                                                            <?php echo $detail['pet_breed']; ?><br>
                                                            <?php echo $detail['pet_condition']; ?>
                                                        </td>
                                                        <td><?php echo $detail['adopted_user_fullname']; ?><br>
                                                            <?php echo $detail['adopted_user_address']; ?><br>
                                                            <?php echo $detail['adopted_user_contact']; ?><br>
                                                            <?php echo $detail['adopted_user_email']; ?>
                                                        </td>
                                                        <td><?php echo $detail['adoption_date']; ?></td>
                                                        <td>
                                                            <?php if ($detail['adoption_status'] === 'Completed') : ?>
                                                                <span style="color: green; font-weight: 900;"><?php echo $detail['adoption_status']; ?></span>
                                                            <?php elseif ($detail['adoption_status'] === 'Requesting') : ?>
                                                                <span style="color: orange; font-weight: 900;"><?php echo $detail['adoption_status']; ?></span>
                                                            <?php else : ?>
                                                                <span style="color: red; font-weight: 900;"><?php echo $detail['adoption_status']; ?></span>
                                                            <?php endif ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                            <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                <div class="box mb-5" style="border: 2px solid brown; padding: 20px;">
                                    <div class="table-responsive">
                                        <table id="example3" class="table table-dark table-hover table-striped table-bordered">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th>My Details</th>
                                                    <th>Pet Details</th>
                                                    <th>Adoptor Details</th>
                                                    <th>Date Adopted</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($other_request as $request) : ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $request['pet_owner_name']; ?><br>
                                                            <?php echo $request['pet_owner_address']; ?><br>
                                                            <?php echo $request['pet_owner_contact']; ?><br>
                                                            <?php echo $request['pet_owner_email']; ?>
                                                        </td>
                                                        <td>
                                                            <img style="height: 75px;" src="images/pet-images/<?php echo $request['pet_image'] ?>" alt="">

                                                            <?php echo $request['pet_name']; ?><br>
                                                            <?php echo $request['pet_age']; ?><br>
                                                            <?php echo $request['pet_type']; ?><br>
                                                            <?php echo $request['pet_breed']; ?><br>
                                                            <?php echo $request['pet_condition']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $request['adopted_user_fullname']; ?><br>
                                                            <?php echo $request['adopted_user_address']; ?><br>
                                                            <?php echo $request['adopted_user_contact']; ?><br>
                                                            <?php echo $request['adopted_user_email']; ?>
                                                        </td>
                                                        <td><?php echo $request['adoption_date']; ?></td>
                                                        <td><?php echo $request['adoption_status']; ?></td>
                                                        <td>
                                                            <div style="display: flex; justify-content: space-between;">
                                                                <a href="#" class="btn btn-link  approve-btn" data-adoption-id="<?php echo $request['adoption_id']; ?>">
                                                                    <i style="color: green;" class="fa fa-check"> Ready to get</i>
                                                                </a>
                                                                <a href="#" class="btn btn-link reject-btn" data-adoption-id="<?php echo $request['adoption_id']; ?>">
                                                                    <i style="color: brown;" class="fa fa-times"> Reject</i>
                                                                </a>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
                            <div class="box" style="border: 2px solid brown; padding: 20px;">
                                <div class="table-responsive">
                                    <table id="example4" class="table table-dark table-hover table-striped table-bordered">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>My Details</th>
                                                <th>Pet Details</th>
                                                <th>Adoptor Details</th>
                                                <th>Date Adopted</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($to_pick_up as $request) : ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $request['pet_owner_name']; ?><br>
                                                        <?php echo $request['pet_owner_address']; ?><br>
                                                        <?php echo $request['pet_owner_contact']; ?><br>
                                                        <?php echo $request['pet_owner_email']; ?>
                                                    </td>
                                                    <td>
                                                        <img style="height: 75px;" src="images/pet-images/<?php echo $request['pet_image'] ?>" alt="">

                                                        <?php echo $request['pet_name']; ?><br>
                                                        <?php echo $request['pet_age']; ?><br>
                                                        <?php echo $request['pet_type']; ?><br>
                                                        <?php echo $request['pet_breed']; ?><br>
                                                        <?php echo $request['pet_condition']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $request['adopted_user_fullname']; ?><br>
                                                        <?php echo $request['adopted_user_address']; ?><br>
                                                        <?php echo $request['adopted_user_contact']; ?><br>
                                                        <?php echo $request['adopted_user_email']; ?>
                                                    </td>
                                                    <td><?php echo $request['adoption_date']; ?></td>
                                                    <td><?php echo $request['adoption_status']; ?></td>
                                                    <td>
                                                        <div style="display: flex; justify-content: space-between;">
                                                            <a href="#" class="btn btn-link  completed-btn" data-adoption-id="<?php echo $request['adoption_id']; ?>">
                                                                <i style="color: green;" class="fa fa-check"> Completed</i>
                                                            </a>
                                                            <a href="#" class="btn btn-link cancel-btn" data-adoption-id="<?php echo $request['adoption_id']; ?>">
                                                                <i style="color: brown;" class="fa fa-times"> Cancel</i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
    <!-- READY TO PICK UP -->
    <script>
        $(document).ready(function() {
            $('.approve-btn').click(function(e) {
                e.preventDefault();

                var adoption_id = $(this).data('adoption-id');

                $.ajax({
                    type: 'POST',
                    url: 'ajax/approval.php',
                    data: {
                        adoption_id: adoption_id
                    },
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
                    }
                });
            });
        });
    </script>
    <!-- END READY TO PICK UP -->

    <!-- REJECTED -->
    <script>
        $('.reject-btn').click(function(e) {
            e.preventDefault();

            var adoption_id = $(this).closest('tr').find('.approve-btn').data('adoption-id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to reject this adoption request.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reject it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'ajax/reject.php',
                        data: {
                            adoption_id: adoption_id
                        },
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
                        }
                    });
                }
            });
        });
    </script>
    <!-- END REJECTED -->

    <!-- COMPLETED -->
    <script>
        $(document).ready(function() {
            $('.completed-btn').click(function(e) {
                e.preventDefault();

                var adoption_id = $(this).data('adoption-id');

                $.ajax({
                    type: 'POST',
                    url: 'ajax/completed.php',
                    data: {
                        adoption_id: adoption_id,
                        action: 'completed'
                    },
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
                    }
                });
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "dom": '<lf<t>ip<l>',
                "ordering": true,
                "info": false,
                "paging": true,
                "bLengthChange": false,
                "searching": true,
            });
        });

        $(document).ready(function() {
            var table = $('#example2').DataTable({
                "dom": '<lf<t>ip<l>',
                "ordering": true,
                "info": false,
                "paging": true,
                "bLengthChange": false,
                "searching": true,
            });
        });

        $(document).ready(function() {
            var table = $('#example3').DataTable({
                "dom": '<lf<t>ip<l>',
                "ordering": true,
                "info": false,
                "paging": true,
                "bLengthChange": false,
                "searching": true,
            });
        });

        $(document).ready(function() {
            var table = $('#example4').DataTable({
                "dom": '<lf<t>ip<l>',
                "ordering": true,
                "info": false,
                "paging": true,
                "bLengthChange": false,
                "searching": true,
            });
        });
    </script>


    <!-- FILTER MY POSTED -->
    <script>
        document.getElementById('posted-filter').addEventListener('change', function() {
            var selectedStatus = this.value.toLowerCase();
            var rows = document.querySelectorAll('#example tbody tr');

            rows.forEach(function(row) {
                var status = row.querySelector('td:nth-child(7) p').textContent.toLowerCase();
                if (selectedStatus === '' || status.includes(selectedStatus)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

    <!-- FILTER MY ADOPTED -->
    <script>
        document.getElementById('adopted-filter').addEventListener('change', function() {
            var selectedStatus = this.value;
            var rows = document.querySelectorAll('#example2 tbody tr');

            rows.forEach(function(row) {
                var status = row.querySelector('td:nth-child(5) span').textContent;
                if (selectedStatus === '' || status === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>