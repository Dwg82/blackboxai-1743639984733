<?php
require_once 'config/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Policy - Laptop Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .shipping-hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.pexels.com/photos/4391481/pexels-photo-4391481.jpeg');
            background-size: cover;
            background-position: center;
            height: 40vh;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="shipping-hero text-white d-flex align-items-center">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Shipping Policy</h1>
            <p class="lead">Information about our shipping methods and delivery times</p>
        </div>
    </section>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h2 class="mb-4">Shipping Methods</h2>
                        <p>We offer the following shipping options for domestic orders:</p>
                        <ul>
                            <li><strong>Standard Shipping:</strong> 3-5 business days ($5.99)</li>
                            <li><strong>Expedited Shipping:</strong> 2 business days ($12.99)</li>
                            <li><strong>Overnight Shipping:</strong> Next business day ($24.99)</li>
                        </ul>
                        <p>Free standard shipping on all orders over $99.</p>

                        <h2 class="mb-4 mt-5">Processing Time</h2>
                        <p>All orders are processed within 1-2 business days (excluding weekends and holidays). Orders placed after 2pm EST will be processed the next business day.</p>

                        <h2 class="mb-4 mt-5">International Shipping</h2>
                        <p>We ship to most countries worldwide. International shipping rates and delivery times vary by destination. Customers are responsible for any customs fees, taxes, or import duties.</p>

                        <h2 class="mb-4 mt-5">Order Tracking</h2>
                        <p>You will receive a shipping confirmation email with tracking information once your order has shipped. Tracking updates are typically available within 24 hours of shipment.</p>

                        <h2 class="mb-4 mt-5">Shipping Restrictions</h2>
                        <p>Some products may have shipping restrictions due to size, weight, or manufacturer requirements. We cannot ship to PO boxes for certain high-value items.</p>

                        <h2 class="mb-4 mt-5">Undeliverable Packages</h2>
                        <p>If a package is returned to us as undeliverable, we will contact you to arrange reshipment. Additional shipping fees may apply.</p>

                        <h2 class="mb-4 mt-5">Damaged or Lost Shipments</h2>
                        <p>Please inspect your package upon delivery. If there is visible damage, please note it with the carrier. For lost or damaged shipments, please contact us within 7 days of delivery.</p>

                        <div class="mt-5">
                            <p>Last updated: <?= date('F j, Y') ?></p>
                            <p>For any shipping questions, please <a href="contact.php">contact our support team</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>