<?php
require_once 'config/db.php';
session_start();

// Get search and filter parameters
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$minPrice = $_GET['min_price'] ?? '';
$maxPrice = $_GET['max_price'] ?? '';

// Build SQL query with filters
$sql = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
$params = [];

if (!empty($search)) {
    $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($category)) {
    $sql .= " AND p.category_id = ?";
    $params[] = $category;
}

if (!empty($minPrice)) {
    $sql .= " AND p.price >= ?";
    $params[] = $minPrice;
}

if (!empty($maxPrice)) {
    $sql .= " AND p.price <= ?";
    $params[] = $maxPrice;
}

// Add sorting
$sort = $_GET['sort'] ?? 'newest';
switch ($sort) {
    case 'price_asc':
        $sql .= " ORDER BY p.price ASC";
        break;
    case 'price_desc':
        $sql .= " ORDER BY p.price DESC";
        break;
    case 'name':
        $sql .= " ORDER BY p.name ASC";
        break;
    default:
        $sql .= " ORDER BY p.id DESC";
}

// Prepare and execute query
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get all categories for filter
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Laptop Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container py-5">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Filters</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET">
                            <div class="mb-3">
                                <label class="form-label">Search</label>
                                <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($search) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    <option value="">All Categories</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" <?= $category == $cat['id'] ? 'selected' : '' ?>>
                                            <?= $cat['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price Range</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="min_price" class="form-control" placeholder="Min" value="<?= htmlspecialchars($minPrice) ?>">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="max_price" class="form-control" placeholder="Max" value="<?= htmlspecialchars($maxPrice) ?>">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Products Listing -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>All Products</h2>
                    <div>
                        <label class="me-2">Sort by:</label>
                        <select class="form-select d-inline-block w-auto" onchange="window.location.href='?<?= http_build_query(array_merge($_GET, ['sort' => ''])) ?>&sort='+this.value">
                            <option value="newest" <?= $sort == 'newest' ? 'selected' : '' ?>>Newest</option>
                            <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                            <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
                            <option value="name" <?= $sort == 'name' ? 'selected' : '' ?>>Name: A-Z</option>
                        </select>
                    </div>
                </div>

                <?php if (empty($products)): ?>
                    <div class="alert alert-info">No products found matching your criteria.</div>
                <?php else: ?>
                    <div class="row g-4">
                        <?php foreach ($products as $product): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm product-card">
                                <img src="<?= $product['image_url'] ?>" class="card-img-top p-3" alt="<?= $product['name'] ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $product['name'] ?></h5>
                                    <p class="text-muted"><?= $product['category_name'] ?? 'Uncategorized' ?></p>
                                    <h5 class="text-primary">$<?= number_format($product['price'], 2) ?></h5>
                                    <p class="card-text"><?= substr($product['description'], 0, 100) ?><?= strlen($product['description']) > 100 ? '...' : '' ?></p>
                                </div>
                                <div class="card-footer bg-white">
                                    <a href="product.php?id=<?= $product['id'] ?>" class="btn btn-outline-primary w-100">View Details</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>