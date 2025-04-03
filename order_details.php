<?php
require_once 'config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$order_id = $_GET['id'] ?? null;
if (!$order_id) {
    header('Location: profile.php');
    exit;
}

// Get order details
$stmt = $pdo->prepare("
    SELECT o.*, p.name as product_name, p.image_url, u.username, u.email 
    FROM orders o
    JOIN products p ON o.product_id = p.id
    JOIN users u ON o.user_id = u.id
    WHERE o.id = ? AND o.user_id = ?
");
$stmt->execute([$order_id, $_SESSION['user_id']]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header('Location: profile.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #<?= $order_id ?> - Laptop Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Order #<?= $order_id ?></h1>
                    <a href="profile.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Profile
                    </a>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6>Order Information</h6>
                                <p class="mb-1"><strong>Date:</strong> <?= date('M d, Y H:i', strtotime($order['created_at'])) ?></p>
                                <p class="mb-1"><strong>Status:</strong> 
                                    <span class="badge bg-<?= $order['status'] == 'completed' ? 'success' : 'warning' ?>">
                                        <?= ucfirst($order['status']) ?>
                                    </span>
                                </p>
                                <p><strong>Payment Method:</strong> <?= ucfirst(str_replace('_', ' ', $order['payment_method'])) ?></p>
                            </div>
                            <div class="col-md-6">
                                <h6>Shipping Information</h6>
                                <p class="mb-1"><strong>Customer:</strong> <?= $order['username'] ?></p>
                                <p class="mb-1"><strong>Email:</strong> <?= $order['email'] ?></p>
                                <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= $order['image_url'] ?>" class="img-thumbnail me-3" width="80" alt="<?= $order['product_name'] ?>">
                                                <div>
                                                    <h6 class="mb-1"><?= $order['product_name'] ?></h6>
                                                    <small class="text-muted">Order #<?= $order_id ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>$<?= number_format($order['total_price'] / $order['quantity'], 2) ?></td>
                                        <td><?= $order['quantity'] ?></td>
                                        <td>$<?= number_format($order['total_price'], 2) ?></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td><strong>$<?= number_format($order['total_price'], 2) ?></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Shipping & Billing</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Shipping Address</h6>
                                <p><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
                            </div>
                            <div class="col-md-6">
                                <h6>Billing Address</h6>
                                <p><?= nl2br(htmlspecialchars($order['billing_address'] ?? $order['shipping_address'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>