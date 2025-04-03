<?php
require_once 'config/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returns Policy - Laptop Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .returns-hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.pexels.com/photos/4391481/pexels-photo-4391481.jpeg');
            background-size: cover;
            background-position: center;
            height: 40vh;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="returns-hero text-white d-flex align-items-center">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Returns Policy</h1>
            <p class="lead">Our hassle-free return and refund process</p>
        </div>
    </section>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h2 class="mb-4">30-Day Return Policy</h2>
                        <p>We offer a 30-day return policy for most items. To be eligible for a return:</p>
                        <ul>
                            <li>Item must be unused and in original condition</li>
                            <li>All original packaging and accessories must be included</li>
                            <li>Proof of purchase is required</li>
                        </ul>

                        <h2 class="mb-4 mt-5">Non-Returnable Items</h2>
                        <p>The following items cannot be returned:</p>
                        <ul>
                            <li>Opened software and digital downloads</li>
                            <li>Personalized or custom-configured products</li>
                            <li>Gift cards</li>
                            <li>Clearance or final sale items</li>
                        </ul>

                        <h2 class="mb-4 mt-5">How to Return an Item</h2>
                        <ol>
                            <li>Contact our customer service to initiate a return</li>
                            <li>You will receive a Return Merchandise Authorization (RMA) number</li>
                            <li>Package the item securely with the RMA number visible</li>
                            <li>Ship using a trackable method to our returns center</li>
                        </ol>

                        <h2 class="mb-4 mt-5">Refund Process</h2>
                        <p>Once we receive and inspect your return:</p>
                        <ul>
                            <li>Refunds will be processed within 5 business days</li>
                            <li>Original shipping costs are non-refundable</li>
                            <li>Refunds will be issued to the original payment method</li>
                            <li>Restocking fees may apply for certain items (up to 15%)</li>
                        </ul>

                        <h2 class="mb-4 mt-5">Exchanges</h2>
                        <p>We currently don't offer direct exchanges. To exchange an item:</p>
                        <ol>
                            <li>Return the original item following our return process</li>
                            <li>Place a new order for the desired item</li>
                        </ol>

                        <h2 class="mb-4 mt-5">Damaged or Defective Items</h2>
                        <p>If you receive a damaged or defective item:</p>
                        <ul>
                            <li>Contact us within 7 days of delivery</li>
                            <li>Provide photos of the damage/defect</li>
                            <li>We will arrange for a replacement or refund</li>
                        </ul>

                        <div class="mt-5">
                            <p>Last updated: <?= date('F j, Y') ?></p>
                            <p>For any return questions, please <a href="contact.php">contact our support team</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>