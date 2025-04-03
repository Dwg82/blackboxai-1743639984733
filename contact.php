<?php
require_once 'config/db.php';
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // In a real application, you would:
    // 1. Validate inputs
    // 2. Save to database
    // 3. Send email notification
    // For this demo, we'll just simulate success

    $success = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Laptop Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .contact-hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.pexels.com/photos/380769/pexels-photo-380769.jpeg');
            background-size: cover;
            background-position: center;
            height: 40vh;
        }
        .contact-info i {
            width: 50px;
            height: 50px;
            line-height: 50px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="contact-hero text-white d-flex align-items-center">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Contact Us</h1>
            <p class="lead">We're here to help with any questions</p>
        </div>
    </section>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h2 class="mb-4">Get In Touch</h2>
                
                <?php if (isset($success)): ?>
                    <div class="alert alert-success">
                        Thank you for your message! We'll get back to you soon.
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>

            <div class="col-lg-6">
                <h2 class="mb-4">Our Information</h2>
                <div class="contact-info">
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 bg-primary text-white rounded-circle text-center me-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h5>Address</h5>
                            <p class="mb-0">123 Tech Street, Silicon Valley, CA 94000</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 bg-primary text-white rounded-circle text-center me-3">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <h5>Phone</h5>
                            <p class="mb-0">(123) 456-7890</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 bg-primary text-white rounded-circle text-center me-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h5>Email</h5>
                            <p class="mb-0">info@laptopstore.com</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="flex-shrink-0 bg-primary text-white rounded-circle text-center me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h5>Business Hours</h5>
                            <p class="mb-0">Monday - Friday: 9am to 5pm</p>
                            <p class="mb-0">Saturday: 10am to 2pm</p>
                            <p class="mb-0">Sunday: Closed</p>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <h5 class="mb-3">Follow Us</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-primary fs-4"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-primary fs-4"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-primary fs-4"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-primary fs-4"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid p-0">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3172.45834641563!2d-121.9352469246906!3d37.334643434378!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fcb33c1732925%3A0x7e1d10c5b0f7d3c1!2sApple%20Park!5e0!3m2!1sen!2sus!4v1689876543210!5m2!1sen!2sus" 
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>