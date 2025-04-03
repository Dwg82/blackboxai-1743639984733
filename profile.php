<?php
require_once 'config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get user details
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

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

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    $errors = [];

    // Validate current password
    if (!password_verify($current_password, $user['password'])) {
        $errors[] = "Current password is incorrect";
    }

    // Check if email exists (excluding current user)
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->execute([$email, $user_id]);
    if ($stmt->fetch()) {
        $errors[] = "Email already in use by another account";
    }

    // Check if username exists (excluding current user)
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
    $stmt->execute([$username, $user_id]);
    if ($stmt->fetch()) {
        $errors[] = "Username already in use by another account";
    }

    if (empty($errors)) {
        $update_data = [
            'username' => $username,
            'email' => $email,
            'id' => $user_id
        ];

        // Update password if new one provided
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_data['password'] = $hashed_password;
            $sql = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
        } else {
            $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($update_data));

        // Update session
        $_SESSION['username'] = $username;

        header('Location: profile.php?updated=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Laptop Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="https://www.gravatar.com/avatar/<?= md5(strtolower(trim($user['email']))) ?>?s=200&d=mp" 
                             class="rounded-circle mb-3" width="150" alt="Profile">
                        <h4><?= $user['username'] ?></h4>
                        <p class="text-muted">Member since <?= date('M Y', strtotime($user['created_at'])) ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <?php if (isset($_GET['updated'])): ?>
                    <div class="alert alert-success">Profile updated successfully!</div>
                <?php endif; ?>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" 
                                       value="<?= htmlspecialchars($user['username']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" 
                                       value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control" name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password (leave blank to keep current)</label>
                                <input type="password" class="form-control" name="new_password">
                            </div>
                            <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order History</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($orders)): ?>
                            <p class="text-muted">You haven't placed any orders yet.</p>
                            <a href="products.php" class="btn btn-primary">Shop Now</a>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Product</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td>#<?= $order['id'] ?></td>
                                            <td><?= $order['product_name'] ?></td>
                                            <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                            <td>$<?= number_format($order['total_price'], 2) ?></td>
                                            <td>
                                                <span class="badge bg-<?= $order['status'] == 'completed' ? 'success' : 'warning' ?>">
                                                    <?= ucfirst($order['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="order_details.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>