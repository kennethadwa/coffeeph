<?php

include('connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 2) {
    header("Location: login.php");
    exit;
}

// Query to fetch all categories
$categoryQuery = "SELECT * FROM category";
$categoryResult = $conn->query($categoryQuery);

?>

<section id="popular" style="padding: 40px 20px; text-align: center;">
    <h2 style="font-size: 2rem; margin-bottom: 20px;">Our Menu</h2>

    <?php if ($categoryResult->num_rows > 0): ?>
        <?php while ($category = $categoryResult->fetch_assoc()): ?>
            <div class="category-section" style="margin-bottom: 40px;">
                <h3 class="mt-5 mb-3 fw-bold" style="font-size: 1.5rem; margin-bottom: 20px;"><?php echo htmlspecialchars($category['category_name']); ?></h3>

                <?php
                // Pagination logic
                $categoryId = $category['category_id'];
                $limit = 8;
                $page = isset($_GET["page_$categoryId"]) ? (int)$_GET["page_$categoryId"] : 1;
                $offset = ($page - 1) * $limit;

                // Query to fetch paginated products for the category
                $productQuery = "SELECT * FROM products WHERE category_id = $categoryId AND stock > 0 LIMIT $limit OFFSET $offset";
                $productResult = $conn->query($productQuery);

                // Query to count total products in this category
                $countQuery = "SELECT COUNT(*) as total FROM products WHERE category_id = $categoryId AND stock > 0";
                $countResult = $conn->query($countQuery);
                $totalProducts = $countResult->fetch_assoc()['total'];
                $totalPages = ceil($totalProducts / $limit);
                ?>

                <div class="popular-container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin-top: 20px;">
                    <?php if ($productResult->num_rows > 0): ?>
                        <?php while ($product = $productResult->fetch_assoc()): ?>
                            <div class="product-box" style="width: 250px; border: 1px solid #ddd; border-radius: 10px; overflow: hidden; text-align: left; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                                <a href="#" class="product-box-img" style="display: block; overflow: hidden;">
                                    <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" style="width: 100%; height: 200px; object-fit: cover;">
                                </a>
                                <div class="product-box-text" style="padding: 15px;">
                                    <a href="#" class="product-text-title" style="font-size: 1.1rem; font-weight: bold; color: #333; text-decoration: none;"><?php echo htmlspecialchars($product['product_name']); ?></a>
                                    <p style="margin: 10px 0; font-size: 0.9rem; color: #777;"><?php echo htmlspecialchars($product['description']); ?></p>
                                    <p style="margin: 10px 0; font-size: 1rem; color: #555;">₱<?php echo number_format($product['price'], 2); ?></p>
                                    <a href="product_details.php?id=<?php echo $product['product_id']; ?>" class="btn btn-primary mt-3 d-flex align-items-center justify-content-center" style="border: none;">
                                        <i class="bi bi-cart-plus me-2"></i>Add To Cart
                                    </a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p style="font-size: 1.2rem; color: #999;">No products available in this category.</p>
                    <?php endif; ?>
                </div>

                <!-- Pagination links -->
                <nav>
                    <ul class="pagination justify-content-center mt-4">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                <a class="page-link" href="?page_<?php echo $categoryId; ?>=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>

            <div class="divider" style="border: 1px solid black;"></div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="font-size: 1.2rem; color: #999;">No categories available.</p>
    <?php endif; ?>
</section>
