<?php
// Start the session
session_start();

// Include the database connection
include('connection.php');

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch the cart items for the logged-in user
$user_id = $_SESSION['user_id'];
$query = "SELECT c.cart_id, p.product_name, p.price, c.quantity, c.product_id
          FROM cart c
          JOIN products p ON c.product_id = p.product_id
          WHERE c.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id); // Bind the user_id parameter
$stmt->execute();
$cart_result = $stmt->get_result();

// Calculate the total price and prepare cart items
$total_price = 0;
$cart_items = [];
while ($row = $cart_result->fetch_assoc()) {
    $row['total_price'] = $row['price'] * $row['quantity'];
    $total_price += $row['total_price'];
    $cart_items[] = $row;
}

// Fetch payment methods for the dropdown
$query_payment_methods = "SELECT payment_id, method_name FROM payment_method";
$result_payment_methods = $conn->query($query_payment_methods);
if (!$result_payment_methods) {
    die("Query failed: " . $conn->error);
}

// Handle the form submission when placing an order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Default payment method ID for 'cash' (assuming payment_id 1 for cash)
    $payment_id = isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : 1;

    // Insert into the transactions table (only once, outside the loop)
    $transaction_date = date('Y-m-d H:i:s');
    $status = 'Pending'; // Default status
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, total_amount, payment_id, status, transaction_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $user_id, $total_price, $payment_id, $status, $transaction_date);
    $stmt->execute();

    // Get the transaction ID of the newly inserted transaction
    $transaction_id = $stmt->insert_id;

    // Insert each item into the transaction_items table
    foreach ($cart_items as $item) {
        $stmt = $conn->prepare("INSERT INTO transaction_items (transaction_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiii", $transaction_id, $item['product_id'], $item['quantity'], $item['price']);
        $stmt->execute();
    }

    // Clear the cart after the order is placed
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Redirect to a confirmation or order page
    echo "<script>alert('Purchase Successfully! Thank you.'); window.location.href='index.php'</script>";
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Your Shopping Cart</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/design.css">
</head>

<body>

    <?php include('navbar.php'); ?>

    <header class="py-5" style="background:  #3B3030;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Your Shopping Cart</h1>
                <p class="lead fw-normal text-white-50 mb-0">Review your items before proceeding to checkout.</p>
            </div>
        </div>
    </header>

    <section class="py-5" style="background-color: white;">
        <section class="container my-5">
            <div class="row">
                <!-- Shopping Cart Table -->
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-header text-white" style="background:  #3B3030;">
                            <h5 class="card-title text-center">Your Cart</h5>
                        </div>
                        <div class="card-body shadow">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Product</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Total Price</th>
                                        <th class="text-center">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($cart_items) > 0): ?>
                                        <?php foreach ($cart_items as $item): ?>
                                            <tr>
                                                <td class="text-center"><?php echo htmlspecialchars($item['product_name']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($item['quantity']); ?></td>
                                                <td class="text-center">₱<?php echo number_format($item['total_price'], 2); ?></td>
                                                <td class="d-flex justify-content-center">
                                                    <form action="remove_from_cart.php" method="POST">
                                                        <input type="hidden" name="transaction_item_id" value="<?php echo $item['cart_id']; ?>">
                                                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i> Remove</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No items in your cart</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Summary Section -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header text-white" style="background: #3B3030;">
                            <h5 class="card-title">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <h6>Total Sum: <span class="float-end">₱<?php echo number_format($total_price, 2); ?></span></h6>
                            <form method="POST">
                                <select id="paymentMethod" name="paymentMethod" class="form-select">
                                    <option value="" disabled selected>Select Payment Method</option>
                                    <?php while ($payment_method = $result_payment_methods->fetch_assoc()): ?>
                                        <option value="<?php echo htmlspecialchars($payment_method['payment_id']); ?>">
                                            <?php echo htmlspecialchars($payment_method['method_name']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                                <br>
                                <button type="submit" class="btn btn-success w-100">Place Order</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>