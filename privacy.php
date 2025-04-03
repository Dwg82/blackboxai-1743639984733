<?php
require_once 'config/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Laptop Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .privacy-hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.pexels.com/photos/669615/pexels-photo-669615.jpeg');
            background-size: cover;
            background-position: center;
            height: 40vh;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="privacy-hero text-white d-flex align-items-center">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Privacy Policy</h1>
            <p class="lead">How we collect, use, and protect your information</p>
        </div>
    </section>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h2 class="mb-4">Information We Collect</h2>
                        <p>We collect information when you register on our site, place an order, subscribe to our newsletter, or fill out a form. This may include:</p>
                        <ul>
                            <li>Personal identification information (name, email address, phone number)</li>
                            <li>Shipping and billing addresses</li>
                            <li>Payment information (processed securely through our payment processor)</li>
                            <li>Technical information about your device and browsing behavior</li>
                        </ul>

                        <h2 class="mb-4 mt-5">How We Use Your Information</h2>
                        <p>We may use the information we collect for the following purposes:</p>
                        <ul>
                            <li>To process transactions and deliver purchased products</li>
                            <li>To personalize your experience and improve our website</li>
                            <li>To send periodic emails regarding your order or other products/services</li>
                            <li>To improve customer service and support needs</li>
                            <li>To comply with legal obligations</li>
                        </ul>

                        <h2 class="mb-4 mt-5">Information Protection</h2>
                        <p>We implement a variety of security measures to maintain the safety of your personal information:</p>
                        <ul>
                            <li>All transactions are processed through a secure gateway provider</li>
                            <li>Sensitive/credit information is encrypted via Secure Socket Layer (SSL) technology</li>
                            <li>Regular malware scanning and security updates</li>
                            <li>Access to personal information is restricted to authorized personnel only</li>
                        </ul>

                        <h2 class="mb-4 mt-5">Cookies</h2>
                        <p>We use cookies to:</p>
                        <ul>
                            <li>Remember and process items in your shopping cart</li>
                            <li>Understand and save your preferences for future visits</li>
                            <li>Compile aggregate data about site traffic and interactions</li>
                        </ul>
                        <p>You can choose to disable cookies through your browser settings.</p>

                        <h2 class="mb-4 mt-5">Third-Party Disclosure</h2>
                        <p>We do not sell, trade, or otherwise transfer your personally identifiable information to outside parties except:</p>
                        <ul>
                            <li>Trusted third parties who assist us in operating our website and conducting business</li>
                            <li>When required by law or to protect our rights, property, or safety</li>
                        </ul>

                        <h2 class="mb-4 mt-5">Changes to This Policy</h2>
                        <p>We may update this privacy policy from time to time. We will notify you of any changes by posting the new policy on this page.</p>

                        <div class="mt-5">
                            <p>Last updated: <?= date('F j, Y') ?></p>
                            <p>If you have any questions about this privacy policy, please <a href="contact.php">contact us</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>