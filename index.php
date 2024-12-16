<?php
session_start();
include('connection.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 2) {
    header("Location: login.php");
    exit;
}

// Query to fetch products with category_id = 1 (Pastries)
$pastries_query = "SELECT * FROM products WHERE category_id = 1";
$pastries_result = mysqli_query($conn, $pastries_query);

// Query to fetch products with category_id = 2 (Cakes)
$cakes_query = "SELECT * FROM products WHERE category_id = 2";
$cakes_result = mysqli_query($conn, $cakes_query);
?>

<!DOCTYPE php>
<php lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@400;600&display=swap"
            rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/design.css">
        <style>
            .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 10px; /* Rounded corners for card */
    overflow: hidden; /* To ensure content doesn’t overflow the border */
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.card-body {
    background: white;
    border: none;
    padding: 20px;
    text-align: center;
    position: relative;
}

.card-body h5 {
    color: black;
    font-size: 1.25rem;
    margin-bottom: 10px;
}

.card-body p {
    font-size: 0.9rem;
    color: black;
    margin-bottom: 15px;
}

.card-body .btn-outline-dark {
    background-color: #876445;
    border: none;
    color: white;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.card-body .btn-outline-dark:hover {
    background-color: #361500;
    color: #fff;
}

/* Optional: Add a background texture or image */
.card-body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('your-image-url.jpg') no-repeat center center;
    background-size: cover;
    opacity: 0.1; /* Subtle texture effect */
    z-index: 0;
}

.card-body > * {
    position: relative;
    z-index: 1; /* Ensures content is above the background image */
}

        </style>
    </head>
    <body>
        
       <?php include('navbar.php'); ?>

        <!-- Header-->
        <header class="py-5" style="background: #361500;">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Julie's Bakery Shop</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Indulge in the finest pastries and cakes, crafted with love and
                        the freshest ingredients.</p>
                </div>
            </div>
        </header>

        <section class="container px-4 px-lg-5 mt-5" id="pastries">
    <div class="text-center mb-5">
        <h2 class="text-light">Pastries</h2>
    </div>

    <div class="row g-3">
        <?php while($row = mysqli_fetch_assoc($pastries_result)): ?>
        <div class="col-12 col-sm-6 col-md-4 mb-4">
            <div class="card h-100 shadow-sm rounded">
                <img class="card-img-top" src="uploads/<?php echo $row['image']; ?>" alt="..." style="height: 200px; object-fit: cover;">
                <div class="card-body p-4">
                    <h5 class="fw-bolder"><?php echo $row['product_name']; ?></h5>
                    <p class="text-dark"><?php echo htmlspecialchars($row['description']); ?></p> <!-- Display description here -->
                    <p class="mb-2 fw-bold">₱<?php echo number_format($row['price'], 2); ?></p>
                    <a class="btn btn-outline-dark" href="product_details.php?id=<?php echo $row['product_id']; ?>">Add to Cart</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<section class="container px-4 px-lg-5 mt-5" id="cakes">
    <div class="text-center mb-5">
        <h2 class="text-light">Cakes</h2>
    </div>

    <div class="row g-3">
        <?php while($row = mysqli_fetch_assoc($cakes_result)): ?>
        <div class="col-12 col-sm-6 col-md-4 mb-4">
            <div class="card h-100 shadow-sm rounded">
                <img class="card-img-top" src="uploads/<?php echo $row['image']; ?>" alt="..." style="height: 200px; object-fit: cover;">
                <div class="card-body p-4">
                    <h5 class="fw-bolder"><?php echo $row['product_name']; ?></h5>
                    <p class="text-muted"><?php echo htmlspecialchars($row['description']); ?></p> <!-- Display description here -->
                    <p class="mb-2">$<?php echo number_format($row['price'], 2); ?></p>
                    <a class="btn btn-outline-dark" href="product_details.php?id=<?php echo $row['product_id']; ?>">Add to Cart</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</php>
