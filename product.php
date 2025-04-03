<?php
require_once 'config/db.php';
session_start();

// Get product details
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: products.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT p.*, c.name as category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    WHERE p.id = ?
");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: products.php');
    exit;
}

// Get related products (same category)
$relatedProducts = $pdo->prepare("
    SELECT p.*, c.name as category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    WHERE p.category_id = ? AND p.id != ? 
    ORDER BY RAND() LIMIT 4
");
$relatedProducts->execute([$product['category_id'], $id]);
$relatedProducts = $relatedProducts->fetchAll(PDO::FETCH_ASSOC);

// Get product reviews
$reviews = $pdo->prepare("
    SELECT r.*, u.username 
    FROM reviews r 
    JOIN users u ON r.user_id = u.id 
    WHERE r.product_id = ? 
    ORDER BY r.created_at DESC
");
$reviews->execute([$id]);
$reviews = $reviews->fetchAll(PDO::FETCH_ASSOC);

// Calculate average rating
$avgRating = $pdo->prepare("SELECT AVG(rating) as avg_rating FROM reviews WHERE product_id = ?");
$avgRating->execute([$id]);
$avgRating = $avgRating->fetch(PDO::FETCH_ASSOC)['avg_rating'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product['name'] ?> - Laptop Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container py-5">
        <!-- Product Details -->
        <div class="row mb-5">
            <div class="col-md-6">
                <img src="<?= $product['image_url'] ?>" class="img-fluid rounded" alt="<?= $product['name'] ?>">
            </div>
            <div class="col-md-6">
                <h1 class="mb-3"><?= $product['name'] ?></h1>
                <div class="d-flex align-items-center mb-3">
                    <?php if ($avgRating): ?>
                        <div class="me-3">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star<?= $i <= round($avgRating) ? '' : '-empty' ?> text-warning"></i>
                            <?php endfor; ?>
                            <span class="ms-1">(<?= count($reviews) ?> reviews)</span>
                        </div>
                    <?php endif; ?>
                    <span class="badge bg-secondary"><?= $product['category_name'] ?? 'Uncategorized' ?></span>
                </div>
                <h3 class="text-primary mb-4">$<?= number_format($product['price'], 2) ?></h3>
                
                <form method="POST" action="cart.php" class="mb-4">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-auto">
                            <label for="quantity" class="col-form-label">Quantity:</label>
                        </div>
                        <div class="col-auto">
                            <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="10">
                        </div>
                        <div class="col-auto">
                            <button type="submit" name="add_to_cart" class="btn btn-primary">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </form>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Product Details</h5>
                    </div>
                    <div class="card-body">
                        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Customer Reviews</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($reviews)): ?>
                            <p class="text-muted">No reviews yet. Be the first to review!</p>
                        <?php else: ?>
                            <?php foreach ($reviews as $review): ?>
                                <div class="mb-4 pb-3 border-bottom">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6><?= $review['username'] ?></h6>
                                        <small class="text-muted"><?= date('M d, Y', strtotime($review['created_at'])) ?></small>
                                    </div>
                                    <div class="mb-2">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star<?= $i <= $review['rating'] ? '' : '-empty' ?> text-warning"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <p><?= nl2br(htmlspecialchars($review['content'])) ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <div class="mt-4">
                                <h5>Write a Review</h5>
                                <form method="POST" action="submit_review.php">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Rating</label>
                                        <select name="rating" class="form-select" required>
                                            <option value="">Select Rating</option>
                                            <option value="5">5 - Excellent</option>
                                            <option value="4">4 - Very Good</option>
                                            <option value="3">3 - Good</option>
                                            <option value="2">2 - Fair</option>
                                            <option value="1">1 - Poor</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Review</label>
                                        <textarea name="content" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit Review</button>
                                </form>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mt-4">
                                Please <a href="login.php" class="alert-link">login</a> to write a review.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <?php if (!empty($relatedProducts)): ?>
            <div class="row">
                <div class="col-12">
                    <h3 class="mb-4">You May Also Like</h3>
                    <div class="row g-4">
                        <?php foreach ($relatedProducts as $related): ?>
                            <div class="col-md-6 col-lg-3">
                                <div class="card h-100 shadow-sm product-card">
                                    <img src="<?= $related['image_url'] ?>" class="card-img-top p-3" alt="<?= $related['name'] ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $related['name'] ?></h5>
                                        <p class="text-muted"><?= $related['category_name'] ?? 'Uncategorized' ?></p>
                                        <h5 class="text-primary">$<?= number_format($related['price'], 2) ?></h5>
                                    </div>
                                    <div class="card-footer bg-white">
                                        <a href="product.php?id=<?= $related['id'] ?>" class="btn btn-outline-primary w-100">View Details</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>