<?php
require_once 'config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get user's most recent order
$user_id = $_SESSION['user_id'];
$order = $pdo->prepare("
    SELECT o.*, p.name as product_name 
    FROM orders o
    JOIN products p ON o.product_id = p.id
    WHERE o.user_id = ?
    ORDER BY o.id DESC
    LIMIT 1
");
$order->execute([$user_id]);
$order = $order->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Laptop Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success fa-5x mb-3"></i>
                            <h1 class="h2 mb-3">Thank You for Your Order!</h1>
                            <p class="lead">Your order has been placed successfully.</p>
                        </div>

                        <?php if ($order): ?>
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Order Details</h5>
                            </div>
                            <div class="card-body text-start">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p><strong>Order ID:</strong> #<?= $order['id'] ?></p>
                                        <p><strong>Date:</strong> <?= date('M d, Y H:i', strtotime($order['created_at'])) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Status:</strong> <span class="badge bg-warning"><?= ucfirst($order['status']) ?></span></p>
                                        <p><strong>Payment Method:</strong> <?= ucfirst(str_replace('_', ' ', $order['payment_method'])) ?></p>
                                    </div>
                                </div>
                                <hr>
                                <p><strong>Product:</strong> <?= $order['product_name'] ?></p>
                                <p><strong>Quantity:</strong> <?= $order['quantity'] ?></p>
                                <p><strong>Total:</strong> $<?= number_format($order['total_price'], 2) ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="products.php" class="btn btn-outline-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                            </a>
                            <a href="profile.php" class="btn btn-primary">
                                <i class="fas fa-user me-2"></i>View Order History
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>