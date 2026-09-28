<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

// Store target WhatsApp number for the business
$wa_phone = "96178812447"; // Replace with real business line
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VibeCraft Studio | Curated Goods & Custom Print</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="sticky-top bg-white border-bottom shadow-sm">
    <!-- Top Announcement Bar -->
    <div class="bg-dark text-white text-center py-1 fs-7">
        <small><i class="fab fa-whatsapp me-1 text-success"></i> Order directly via WhatsApp. Fast delivery across Lebanon!</small>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-slate fs-3" href="index.php">
                Vibe<span class="text-teal">Craft</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-medium">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="offers.php">Special Offers</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <a href="shop.php" class="btn btn-outline-dark btn-sm"><i class="fas fa-search me-1"></i> Search</a>
                    <a href="https://wa.me/<?php echo $wa_phone; ?>" target="_blank" class="btn btn-whatsapp btn-sm fw-bold">
                        <i class="fab fa-whatsapp me-1"></i> Direct Chat
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>
<main></main>