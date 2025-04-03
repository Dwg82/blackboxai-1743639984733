<?php
require_once 'config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $content = $_POST['content'];

    // Validate inputs
    if ($rating < 1 || $rating > 5) {
        die("Invalid rating");
    }

    // Check if user already reviewed this product
    $stmt = $pdo->prepare("SELECT id FROM reviews WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$_SESSION['user_id'], $product_id]);
    
    if ($stmt->fetch()) {
        // Update existing review
        $stmt = $pdo->prepare("UPDATE reviews SET rating = ?, content = ? WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$rating, $content, $_SESSION['user_id'], $product_id]);
    } else {
        // Create new review
        $stmt = $pdo->prepare("INSERT INTO reviews (user_id, product_id, rating, content) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $product_id, $rating, $content]);
    }

    // Redirect back to product page
    header("Location: product.php?id=$product_id&reviewed=1");
    exit;
}

// If not POST request, redirect to home
header('Location: index.php');
exit;
?>