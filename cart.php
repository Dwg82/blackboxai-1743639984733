<?php
require_once 'config/db.php';
session_start();

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'] ?? 1;

    // Check if product already in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    // If not found, add new item
    if (!$found) {
        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'quantity' => $quantity
        ];
    }

    header('Location: cart.php');
    exit;
}

// Handle remove from cart
if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
    }
    header('Location: cart.php');
    exit;
}

// Handle quantity update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $index => $quantity) {
        if (isset($_SESSION['cart'][$index])) {
            $_SESSION['cart'][$index]['quantity'] = max(1, (int)$quantity);
        }
    }
    header('Location: cart.php');
    exit;
}

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Laptop Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container py-5">
        <h1 class="mb-4">Shopping Cart</h1>

        <?php if (empty($cartProducts)): ?>
            <div class="alert alert-info">
                Your cart is empty. <a href="products.php" class="alert-link">Continue shopping</a>
            </div>
        <?php else: ?>
            <form method="POST" action="cart.php">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartProducts as $index => $product): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= $product['image_url'] ?>" class="img-thumbnail me-3" width="80" alt="<?= $product['name'] ?>">
                                        <div>
                                            <h5 class="mb-1"><?= $product['name'] ?></h5>
                                            <small class="text-muted">SKU: <?= $product['id'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>$<?= number_format($product['price'], 2) ?></td>
                                <td>
                                    <input type="number" name="quantities[<?= $index ?>]" 
                                           class="form-control" min="1" 
                                           value="<?= $product['quantity'] ?>" style="width: 70px;">
                                </td>
                                <td>$<?= number_format($product['subtotal'], 2) ?></td>
                                <td>
                                    <a href="cart.php?remove=<?= $index ?>" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td colspan="2"><strong>$<?= number_format($total, 2) ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="products.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                    </a>
                    <div>
                        <button type="submit" name="update_cart" class="btn btn-outline-primary me-2">
                            <i class="fas fa-sync-alt me-2"></i>Update Cart
                        </button>
                        <a href="checkout.php" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Proceed to Checkout
                        </a>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>