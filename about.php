<?php
require_once 'config/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Laptop Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .about-hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.pexels.com/photos/3183150/pexels-photo-3183150.jpeg');
            background-size: cover;
            background-position: center;
            height: 50vh;
        }
        .team-member img {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="about-hero text-white d-flex align-items-center">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">About Our Laptop Store</h1>
            <p class="lead">Delivering quality technology solutions since 2010</p>
        </div>
    </section>

    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-lg-6">
                <h2 class="mb-4">Our Story</h2>
                <p>Founded in 2010, Laptop Store began as a small tech shop with a big vision: to provide high-quality laptops at affordable prices. What started as a single storefront has grown into a trusted online destination for tech enthusiasts and professionals alike.</p>
                <p>We pride ourselves on our curated selection of laptops, from budget-friendly options to high-performance machines for gamers and creators. Our team of tech experts carefully tests and reviews every product we sell to ensure it meets our high standards.</p>
            </div>
            <div class="col-lg-6">
                <img src="https://images.pexels.com/photos/3184465/pexels-photo-3184465.jpeg" class="img-fluid rounded" alt="Our store">
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <h2 class="text-center mb-5">Why Choose Us</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-award fa-3x text-primary mb-3"></i>
                                <h5>Quality Products</h5>
                                <p>We only sell laptops from trusted brands that meet our rigorous quality standards.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                                <h5>Expert Support</h5>
                                <p>Our tech specialists are available 24/7 to help you choose the perfect laptop.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-truck fa-3x text-primary mb-3"></i>
                                <h5>Fast Shipping</h5>
                                <p>Get your new laptop quickly with our express shipping options.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-5">Meet Our Team</h2>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-4 col-lg-3">
                        <div class="card border-0 text-center team-member">
                            <img src="https://randomuser.me/api/portraits/women/43.jpg" class="rounded-circle mx-auto mt-3" alt="Team member">
                            <div class="card-body">
                                <h5>Sarah Johnson</h5>
                                <p class="text-muted">CEO & Founder</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="card border-0 text-center team-member">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-circle mx-auto mt-3" alt="Team member">
                            <div class="card-body">
                                <h5>Michael Chen</h5>
                                <p class="text-muted">Tech Specialist</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="card border-0 text-center team-member">
                            <img src="https://randomuser.me/api/portraits/women/65.jpg" class="rounded-circle mx-auto mt-3" alt="Team member">
                            <div class="card-body">
                                <h5>Emily Rodriguez</h5>
                                <p class="text-muted">Customer Support</p>
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