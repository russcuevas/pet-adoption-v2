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

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 6;
$offset = ($page - 1) * $items_per_page;

$total_query = $conn->query("SELECT COUNT(*) FROM `tbl_news_announcement`");
$total_items = $total_query->fetchColumn();
$total_pages = ceil($total_items / $items_per_page);

$get_news = "SELECT * FROM `tbl_news_announcement` LIMIT :offset, :items_per_page";
$get_stmt = $conn->prepare($get_news);
$get_stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$get_stmt->bindValue(':items_per_page', $items_per_page, PDO::PARAM_INT);
$get_stmt->execute();
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
                            <a class="nav-link active" href="news_announcement.php">News & Announcement</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
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
                <?php if (empty($announcements)) : ?>
                    <div style="padding: 5px;">
                        <div style="border: 2px solid #704130; padding: 20px;">
                            <h1 style="text-align: center; font-weight: bold; color: brown;">No news and announcements posted</h1>
                        </div>
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

                    <!-- PAGINATION -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="news_announcement.php?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php else : ?>
                                <li class="page-item disabled">
                                    <span class="page-link">&laquo;</span>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="news_announcement.php?page=<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="news_announcement.php?page=<?php echo $page + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php else : ?>
                                <li class="page-item disabled">
                                    <span class="page-link">&raquo;</span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif ?>
            </div>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="assets/js/script.js"></script>
</body>

</html>