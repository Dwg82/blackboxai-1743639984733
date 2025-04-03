<?php
require_once '../config/db.php';
require_once 'includes/header.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Get user details
$user_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: users.php');
    exit;
}

// Get user's orders
$orders = $pdo->prepare("
    SELECT o.*, p.name as product_name 
    FROM orders o
    JOIN products p ON o.product_id = p.id
    WHERE o.user_id = ?
    ORDER BY o.created_at DESC
");
$orders->execute([$user_id]);
$orders = $orders->fetchAll(PDO::FETCH_ASSOC);

// Get user's reviews
$reviews = $pdo->prepare("
    SELECT r.*, p.name as product_name 
    FROM reviews r
    JOIN products p ON r.product_id = p.id
    WHERE r.user_id = ?
    ORDER BY r.created_at DESC
");
$reviews->execute([$user_id]);
$reviews = $reviews->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">User Details</h1>
                <a href="users.php" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Users
                </a>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">User Information</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>ID:</strong> <?= $user['id'] ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Username:</strong> <?= $user['username'] ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Email:</strong> <?= $user['email'] ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Registered:</strong> <?= date('M d, Y H:i', strtotime($user['created_at'])) ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h4>Order History</h4>
                    <?php if (empty($orders)): ?>
                        <div class="alert alert-info">No orders found for this user.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?= $order['id'] ?></td>
                                        <td><?= $order['product_name'] ?></td>
                                        <td><?= $order['quantity'] ?></td>
                                        <td>$<?= number_format($order['total_price'], 2) ?></td>
                                        <td><?= ucfirst($order['status']) ?></td>
                                        <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Product Reviews</h4>
                    <?php if (empty($reviews)): ?>
                        <div class="alert alert-info">No reviews found for this user.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Rating</th>
                                        <th>Review</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reviews as $review): ?>
                                    <tr>
                                        <td><?= $review['product_name'] ?></td>
                                        <td>
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fas fa-star<?= $i <= $review['rating'] ? '' : '-empty' ?> text-warning"></i>
                                            <?php endfor; ?>
                                        </td>
                                        <td><?= $review['content'] ?></td>
                                        <td><?= date('M d, Y', strtotime($review['created_at'])) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>