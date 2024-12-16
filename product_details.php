<?php
// Start the session
session_start();

// Include the database connection
include('connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? $_GET['id'] : null;

// If no product ID is passed, redirect to the homepage or display an error
if ($product_id === null) {
    header("Location: index.php");
    exit;
}

// Fetch the product details from the database
$query = "SELECT p.product_name, p.description, p.price, p.image, c.category_name 
          FROM products p
          JOIN category c ON p.category_id = c.category_id
          WHERE p.product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id); // Bind the product_id parameter
$stmt->execute();
$result = $stmt->get_result();

// If product not found, redirect to homepage
if ($result->num_rows == 0) {
    header("Location: index.php");
    exit;
}

// Fetch the product data
$product = $result->fetch_assoc();

// Handle the "Add to Cart" action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantity'])) {
    $quantity = (int)$_POST['quantity'];

    // Insert into the cart table
    $insertQuery = "INSERT INTO cart (user_id, product_id, quantity, created_at, updated_at) 
                    VALUES (?, ?, ?, NOW(), NOW())";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("iii", $user_id, $product_id, $quantity);
    
    if ($insertStmt->execute()) {
        // Redirect to the cart page or show a success message
        header("Location: cart.php");
        exit;
    } else {
        // Handle insert error
        echo "Error adding to cart. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Product Details - <?php echo htmlspecialchars($product['product_name']); ?></title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/design.css">
</head>

<body>

  <?php include('navbar.php'); ?>

  <section class="py-5" style="background-color: #1C0A00;">
    <section class="py-5">
      <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
          <!-- Product Image -->
          <div class="col-md-6">
            <img class="card-img-top mb-5 mb-md-0" src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" style="height: 400px; object-fit: cover;" />
          </div>

          <!-- Product Details -->
          <div class="col-md-6">
            <div class="small mb-1" style="color: #FB773C;">Category: <?php echo htmlspecialchars($product['category_name']); ?></div>
            <h1 class="display-5 fw-bolder" style="color: #FB773C;"><?php echo htmlspecialchars($product['product_name']); ?></h1>
            <div class="fs-5 mb-5">
              <span class="text-light">$<?php echo number_format($product['price'], 2); ?></span>
            </div>
            <p class="lead text-light"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            <form action="product_details.php?id=<?php echo $product_id; ?>" method="POST">
                <div class="d-flex flex-column">
                  <input class="form-control text-center me-3" id="inputQuantity" name="quantity" type="number" value="1" style="max-width: 3rem" />
                  <br>
                  <div class="d-flex justify-content-center">
                    <button class="btn btn-primary text-white flex-shrink-0 col-md-6" type="submit">
                    <i class="bi-cart-fill me-1 text-white"></i> Add to cart
                  </button>
                  </div> 
                </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/scripts.js"></script>
</body>
</html>
