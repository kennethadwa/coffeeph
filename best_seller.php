<?php
include('connection.php');

// Query to fetch the product with the cheapest price
$cheapestProductQuery = "SELECT * FROM products ORDER BY price DESC LIMIT 1";
$cheapestProductResult = $conn->query($cheapestProductQuery);
$cheapestProduct = $cheapestProductResult->fetch_assoc();
?>

<div class="main-content mb-5">
    <div class="main-content-text">
        <strong><?php echo htmlspecialchars($cheapestProduct['product_name']); ?></strong>
        <h1>Enjoy <br> Your Morning <br> Coffee</h1>
        <p><?php echo htmlspecialchars($cheapestProduct['description']); ?></p>
        <span>₱<?php echo number_format((float)$cheapestProduct['price'], 2); ?></span>
        <a href="product_details.php?id=<?php echo $cheapestProduct['product_id']; ?>" 
           class="btn mt-3" 
           style="font-size: 0.9rem; padding: 10px 20px; border-radius: 5px; background-color: #007BFF; color: white;">
            <i class="bi bi-cart-plus me-2"></i>Add To Cart
        </a>
    </div>
    <div class="main-content-img">
        <img src="uploads/<?php echo htmlspecialchars($cheapestProduct['image']); ?>" alt="<?php echo htmlspecialchars($cheapestProduct['product_name']); ?>" />
    </div>
</div>
