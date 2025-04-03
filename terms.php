<?php
require_once 'config/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions - Laptop Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .terms-hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.pexels.com/photos/669615/pexels-photo-669615.jpeg');
            background-size: cover;
            background-position: center;
            height: 40vh;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="terms-hero text-white d-flex align-items-center">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Terms & Conditions</h1>
            <p class="lead">The rules governing use of our website and services</p>
        </div>
    </section>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h2 class="mb-4">1. General Terms</h2>
                        <p>By accessing and using this website, you accept and agree to be bound by these Terms and Conditions. If you do not agree, you must not use our website or services.</p>

                        <h2 class="mb-4 mt-5">2. Product Information</h2>
                        <p>We make every effort to display our products as accurately as possible. However, we cannot guarantee that your device's display will be perfectly accurate. Product specifications are subject to change without notice.</p>

                        <h2 class="mb-4 mt-5">3. Pricing and Payments</h2>
                        <p>All prices are in USD and subject to change without notice. We reserve the right to modify or discontinue any product at any time. We are not liable to you or any third-party for any modification, price change, suspension or discontinuance.</p>

                        <h2 class="mb-4 mt-5">4. Order Acceptance</h2>
                        <p>Your receipt of an order confirmation does not signify our acceptance of your order. We reserve the right to refuse or cancel any order for any reason at any time. We may require additional verification before accepting any order.</p>

                        <h2 class="mb-4 mt-5">5. Shipping Policy</h2>
                        <p>Shipping times are estimates only and not guaranteed. We are not responsible for any delays caused by shipping carriers or customs. Risk of loss passes to you upon delivery to the carrier.</p>

                        <h2 class="mb-4 mt-5">6. Returns & Refunds</h2>
                        <p>Please review our return policy on the product pages. Refunds will be issued to the original payment method. We reserve the right to refuse returns that don't meet our return policy requirements.</p>

                        <h2 class="mb-4 mt-5">7. Intellectual Property</h2>
                        <p>All content on this website, including text, graphics, logos, and images, is our property and protected by copyright laws. You may not use our trademarks or content without our express written permission.</p>

                        <h2 class="mb-4 mt-5">8. Limitation of Liability</h2>
                        <p>We shall not be liable for any damages resulting from your use of our products or services. In no event shall our liability exceed the price paid for the product giving rise to the claim.</p>

                        <h2 class="mb-4 mt-5">9. Governing Law</h2>
                        <p>These Terms shall be governed by and construed in accordance with the laws of the State of California, without regard to its conflict of law provisions.</p>

                        <h2 class="mb-4 mt-5">10. Changes to Terms</h2>
                        <p>We reserve the right to modify these terms at any time. Your continued use of the website after changes constitutes acceptance of the new terms.</p>

                        <div class="mt-5">
                            <p>Last updated: <?= date('F j, Y') ?></p>
                            <p>If you have any questions about these terms, please <a href="contact.php">contact us</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>