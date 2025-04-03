<?php
require_once 'config/db.php';
session_start();

// Get featured products
$featuredProducts = $pdo->query("
    SELECT p.*, c.name as category_name 
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    ORDER BY RAND() LIMIT 8
")->fetchAll(PDO::FETCH_ASSOC);

// Get all categories
$categories = $pdo->query("SELECT * FROM categories LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptop Store - Best Laptops Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.pexels.com/photos/18105/pexels-photo.jpg');
            background-size: cover;
            background-position: center;
            height: 60vh;
        }
        .product-card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section text-white d-flex align-items-center">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Premium Laptops for Every Need</h1>
            <p class="lead mb-5">Discover our wide range of high-performance laptops at competitive prices</p>
            <a href="products.php" class="btn btn-primary btn-lg px-4 me-2">Shop Now</a>
            <a href="#featured" class="btn btn-outline-light btn-lg px-4">Featured Products</a>
        </div>
    </section>

    <!-- Categories -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Shop by Category</h2>
            <div class="row g-4">
                <?php foreach ($categories as $category): ?>
                <div class="col-md-4 col-lg-2">
                    <a href="products.php?category=<?= $category['id'] ?>" class="text-decoration-none">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-laptop fa-3x mb-3 text-primary"></i>
                                <h5 class="card-title"><?= $category['name'] ?></h5>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="featured" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Featured Products</h2>
            <div class="row g-4">
                <?php foreach ($featuredProducts as $product): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="<?= $product['image_url'] ?>" class="card-img-top p-3" alt="<?= $product['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <p class="text-muted"><?= $product['category_name'] ?? 'Uncategorized' ?></p>
                            <h5 class="text-primary">$<?= number_format($product['price'], 2) ?></h5>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <a href="product.php?id=<?= $product['id'] ?>" class="btn btn-outline-primary w-100">View Details</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-4">
                <a href="products.php" class="btn btn-primary">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>