<?php
include 'database/connection.php';
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    $stmt = $conn->prepare("SELECT * FROM `tbl_news_announcement` WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $news = $stmt->fetch(PDO::FETCH_ASSOC);
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


    <!-- NEWS SECTION -->
    <div class="news-section">
        <div class="container">
            <div class="p-4 p-md-5 mt-5 mb-4 rounded text-body-emphasis bg-body-secondary">
                <div class="col-lg-6 px-0">
                    <h1 class="display-4 fst-italic"><?php echo $news['event_title']; ?></h1>
                </div>
            </div>

            <div class="row g-5">
                <div class="col-md-8">
                    <article class="blog-post">
                        <h2 class="display-5 link-body-emphasis mb-1">
                            <img style="height: 200px; width: 200px" src="assets/event_image/<?php echo $news['event_image'] ?>" alt="">
                        </h2>
                        <p class="blog-post-meta"><?php echo date_format(new DateTime($news['event_schedule']), 'F j Y / h:i A'); ?> by <a href="#">Admin</a></p>
                        <p><?php echo $news['event_description'] ?></p>
                    </article>
                </div>
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