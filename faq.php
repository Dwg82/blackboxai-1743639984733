<?php
require_once 'config/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs - Laptop Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .faq-hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.pexels.com/photos/380769/pexels-photo-380769.jpeg');
            background-size: cover;
            background-position: center;
            height: 40vh;
        }
        .accordion-button:not(.collapsed) {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="faq-hero text-white d-flex align-items-center">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Frequently Asked Questions</h1>
            <p class="lead">Find answers to common questions about our products and services</p>
        </div>
    </section>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item mb-3 border rounded">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers. All payments are processed securely through our encrypted payment gateway.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item mb-3 border rounded">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                How long does shipping take?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Standard shipping typically takes 3-5 business days within the continental US. We also offer expedited shipping options (1-2 business days) for an additional fee. International shipping times vary by destination.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item mb-3 border rounded">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                What is your return policy?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We offer a 30-day return policy for most items. Products must be in original condition with all packaging and accessories. Refunds will be issued to the original payment method. Some exclusions apply for opened software and special order items.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item mb-3 border rounded">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                Do you offer technical support?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes! We provide free technical support for all products purchased from our store. Our support team is available Monday-Friday from 9am to 5pm EST via phone, email, or live chat. For complex issues, we can also arrange remote desktop support.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item mb-3 border rounded">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                Can I upgrade my laptop after purchase?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Many of our laptops can be upgraded after purchase. We offer RAM, SSD, and battery upgrade services. Please contact our support team with your laptop model and desired upgrades for a quote. Some newer ultrabooks have soldered components that cannot be upgraded.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item mb-3 border rounded">
                        <h2 class="accordion-header" id="headingSix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
                                Do you offer student discounts?
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, we offer a 10% discount for students with valid .edu email addresses. Simply register with your school email and the discount will be automatically applied at checkout. Some exclusions may apply for already discounted items.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-5">
                    <div class="card-body text-center">
                        <h5 class="card-title">Still have questions?</h5>
                        <p class="card-text">Our customer service team is happy to help with any other questions you may have.</p>
                        <a href="contact.php" class="btn btn-primary">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>