<?php
require_once '../config/db.php';
require_once 'includes/header.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Handle review deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: reviews.php?deleted=1');
    exit;
}

// Fetch all reviews with user and product details
$reviews = $pdo->query("
    SELECT r.*, u.username, p.name as product_name 
    FROM reviews r
    JOIN users u ON r.user_id = u.id
    JOIN products p ON r.product_id = p.id
    ORDER BY r.created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Product Reviews</h1>
            </div>

            <?php if (isset($_GET['deleted'])): ?>
                <div class="alert alert-success">Review deleted successfully!</div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>User</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $review): ?>
                        <tr>
                            <td><?= $review['id'] ?></td>
                            <td><?= $review['product_name'] ?></td>
                            <td><?= $review['username'] ?></td>
                            <td>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star<?= $i <= $review['rating'] ? '' : '-empty' ?> text-warning"></i>
                                <?php endfor; ?>
                            </td>
                            <td><?= substr($review['content'], 0, 50) ?><?= strlen($review['content']) > 50 ? '...' : '' ?></td>
                            <td><?= date('M d, Y', strtotime($review['created_at'])) ?></td>
                            <td>
                                <a href="reviews.php?delete=<?= $review['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure? This will permanently delete the review.')">
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