<?php
require_once '../config/db.php';
require_once 'includes/header.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Handle product deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: products.php?deleted=1');
    exit;
}

// Fetch all products
$stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Products Management</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="add_product.php" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus"></i> Add New Product
                    </a>
                </div>
            </div>

            <?php if (isset($_GET['deleted'])): ?>
                <div class="alert alert-success">Product deleted successfully!</div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td><img src="<?= $product['image_url'] ?>" width="50" height="50" class="img-thumbnail"></td>
                            <td><?= $product['name'] ?></td>
                            <td>$<?= number_format($product['price'], 2) ?></td>
                            <td><?= $product['category_name'] ?? 'Uncategorized' ?></td>
                            <td>
                                <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="products.php?delete=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>