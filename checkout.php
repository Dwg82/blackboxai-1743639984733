<?php
require_once 'config/db.php';
session_start();

// Redirect if cart is empty or user not logged in
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_to'] = 'checkout.php';
    header('Location: login.php');
    exit;
}

// Get user details
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Get cart products with details
$cartProducts = [];
$total = 0;

foreach ($_SESSION['cart'] as $item) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$item['product_id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $product['quantity'] = $item['quantity'];
        $product['subtotal'] = $product['price'] * $item['quantity'];
        $total += $product['subtotal'];
        $cartProducts[] = $product;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process payment (simulated)
    $payment_method = $_POST['payment_method'];
    $shipping_address = $_POST['shipping_address'];
    $billing_address = $_POST['billing_address'] ?? $shipping_address;
    
    // Create order for each product
    foreach ($cartProducts as $product) {
        $stmt = $pdo->prepare("
            INSERT INTO orders 
            (user_id, product_id, quantity, total_price, status, shipping_address, billing_address, payment_method) 
            VALUES (?, ?, ?, ?, 'pending', ?, ?, ?)
        ");
        $stmt->execute([
            $user_id,
            $product['id'],
            $product['quantity'],
            $product['subtotal'],
            $shipping_address,
            $billing_address,
            $payment_method
        ]);
    }
    
    // Clear cart
    $_SESSION['cart'] = [];
    
    // Redirect to success page
    header('Location: order_success.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Laptop Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Shipping Information</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="full_name" 
                                       value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" 
                                       value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Shipping Address</label>
                                <textarea class="form-control" name="shipping_address" rows="3" required></textarea>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="same-billing" checked>
                                <label class="form-check-label" for="same-billing">
                                    Billing address same as shipping
                                </label>
                            </div>
                            <div class="mb-3" id="billing-address-group" style="display: none;">
                                <label class="form-label">Billing Address</label>
                                <textarea class="form-control" name="billing_address" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <select class="form-select" name="payment_method" required>
                                    <option value="">Select Payment Method</option>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                </select>
                            </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Order Summary</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush mb-3">
                            <?php foreach ($cartProducts as $product): ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <h6 class="my-0"><?= $product['name'] ?></h6>
                                    <small class="text-muted">Qty: <?= $product['quantity'] ?></small>
                                </div>
                                <span class="text-muted">$<?= number_format($product['subtotal'], 2) ?></span>
                            </li>
                            <?php endforeach; ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Subtotal</span>
                                <strong>$<?= number_format($total, 2) ?></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Shipping</span>
                                <strong>$0.00</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total</span>
                                <strong>$<?= number_format($total, 2) ?></strong>
                            </li>
                        </ul>
                        <button type="submit" class="btn btn-primary w-100">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        // Toggle billing address visibility
        document.getElementById('same-billing').addEventListener('change', function() {
            const billingGroup = document.getElementById('billing-address-group');
            billingGroup.style.display = this.checked ? 'none' : 'block';
        });
    </script>
</body>
</html>