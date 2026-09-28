<?php 
require_once 'includes/header.php'; 

if (!isset($conn) || !($conn instanceof mysqli)) {
    die('Database connection is not available.');
}

// Fetch Categories
$cat_query = "SELECT * FROM categories LIMIT 6";
$cat_result = mysqli_query($conn, $cat_query);

// Fetch Featured Products
$feat_query = "SELECT p.*, c.name as category_name FROM products p 
              JOIN categories c ON p.category_id = c.id 
              WHERE p.is_featured = 1 AND p.status = 'active' LIMIT 4";
$feat_result = mysqli_query($conn, $feat_query);
?>

<style>
    /* Modern Light Hero Styling */
    .hero-wrapper {
        background: radial-gradient(circle at 10% 20%, rgba(13, 148, 136, 0.08) 0%, rgba(248, 250, 252, 1) 90%);
        position: relative;
        overflow: hidden;
    }
    .hero-badge-glass {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(13, 148, 136, 0.2);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }
    .pulse-indicator {
        width: 10px;
        height: 10px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulse-ring 1.8s infinite;
    }
    @keyframes pulse-ring {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
    .hero-btn-primary {
        background-color: #0d9488;
        color: #ffffff;
        border: none;
        transition: all 0.3s ease;
    }
    .hero-btn-primary:hover {
        background-color: #0f766e;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(13, 148, 136, 0.4);
    }
    .hero-btn-whatsapp {
        background-color: #25d366;
        color: #ffffff;
        border: none;
        transition: all 0.3s ease;
    }
    .hero-btn-whatsapp:hover {
        background-color: #1da851;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(37, 211, 102, 0.4);
    }
    .showcase-card {
        border-radius: 24px;
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08);
        transition: transform 0.4s ease;
    }
    .showcase-card:hover {
        transform: translateY(-6px);
    }
</style>

<!-- Hero Section -->
<section class="hero-wrapper py-5 py-lg-6">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            
            <!-- Left Column: Copy & CTAs -->
            <div class="col-lg-6 text-center text-lg-start">
                
                <!-- Floating Glass Status Badge -->
                <div class="d-inline-flex align-items-center px-3 py-2 rounded-pill hero-badge-glass mb-4">
                    <span class="pulse-indicator me-2"></span>
                    <span class="text-dark small fw-semibold">Accepting Custom Orders & Nation-wide Delivery</span>
                </div>

                <!-- Catchy Headline -->
                <h1 class="display-4 fw-bold text-dark lh-sm mb-3">
                    Crafting Premium <br class="d-none d-md-inline">
                    <span style="color: #0d9488;">Custom Apparel</span> & Merchandise
                </h1>

                <!-- Subtitle -->
                <p class="lead text-secondary mb-4 pe-lg-4 fs-5">
                    Transform your logos, artwork, and personal ideas into high-definition printed hoodies, t-shirts, and custom gear.
                </p>

                <!-- Action Buttons -->
                <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3 mb-4">
                    <a href="shop.php" class="btn hero-btn-primary btn-lg px-4 py-3 rounded-pill fw-bold">
                        <i class="fas fa-bag-shopping me-2"></i> Explore Shop
                    </a>
                    <a href="https://wa.me/<?php echo isset($wa_phone) ? preg_replace('/[^0-9]/', '', $wa_phone) : ''; ?>?text=Hello!%20I%20want%20to%20ask%20about%20a%20custom%20print." 
                       target="_blank" 
                       class="btn hero-btn-whatsapp btn-lg px-4 py-3 rounded-pill fw-bold">
                        <i class="fab fa-whatsapp me-2"></i> Custom Print Quote
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-4 pt-2 text-muted small">
                    <div><i class="fas fa-check-circle text-teal me-1" style="color: #0d9488;"></i> Premium Fabrics</div>
                    <div><i class="fas fa-check-circle text-teal me-1" style="color: #0d9488;"></i> Fast Turnaround</div>
                    <div><i class="fas fa-check-circle text-teal me-1" style="color: #0d9488;"></i> High-Density Prints</div>
                </div>
            </div>

            <!-- Right Column: Card Graphic Showcase -->
            <div class="col-lg-6">
                <div class="showcase-card p-4 p-md-5 text-center position-relative">
                    
                    <!-- Decorative Soft Background Circle -->
                    <div class="position-absolute top-50 start-50 translate-middle rounded-circle" 
                         style="width: 250px; height: 250px; background: rgba(13, 148, 136, 0.1); filter: blur(40px); z-index: 0;"></div>

                    <div class="position-relative z-1">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3 p-4 shadow-sm" style="width: 100px; height: 100px;">
                            <i class="fas fa-wand-magic-sparkles fs-1" style="color: #0d9488;"></i>
                        </div>
                        
                        <h4 class="fw-bold text-dark mb-2">Have a Unique Design?</h4>
                        <p class="text-muted small mb-4 px-md-4">
                            Send us your photo or graphic on WhatsApp and we will create a high-quality print preview for your apparel.
                        </p>

                        <div class="row g-2 text-start">
                            <div class="col-6">
                                <div class="p-3 bg-light rounded-3 border">
                                    <div class="fw-bold text-dark small"><i class="fas fa-shirt text-teal me-1" style="color: #0d9488;"></i> Apparel</div>
                                    <div class="text-muted extra-small" style="font-size: 0.75rem;">Hoodies, Tees, Caps</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded-3 border">
                                    <div class="fw-bold text-dark small"><i class="fas fa-box text-teal me-1" style="color: #0d9488;"></i> Merchandise</div>
                                    <div class="text-muted extra-small" style="font-size: 0.75rem;">Mugs, Bags, Gift Sets</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Categories Bar -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-1">Browse by Category</h2>
                <p class="text-muted mb-0">Explore our curated operational departments</p>
            </div>
            <a href="categories.php" class="text-teal text-decoration-none fw-semibold">View All <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-3">
            <?php while($cat = mysqli_fetch_assoc($cat_result)): ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="shop.php?category=<?php echo $cat['slug']; ?>" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm text-center p-3 text-dark">
                            <i class="fas fa-box-open fs-2 text-teal mb-2"></i>
                            <h6 class="fw-bold mb-0 text-truncate"><?php echo htmlspecialchars($cat['name']); ?></h6>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Featured Showcase -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-center mb-1">Featured Items</h2>
        <p class="text-muted text-center mb-5">Handpicked favorites with direct-to-WhatsApp ordering</p>
        <div class="row g-4">
            <?php while($prod = mysqli_fetch_assoc($feat_result)): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="product-card h-100 d-flex flex-column">
                        <div class="card-img-container">
                            <img src="assets/images/products/<?php echo htmlspecialchars($prod['image']); ?>" 
                                 onerror="this.src='https://via.placeholder.com/300x220?text=VibeCraft';" 
                                 alt="<?php echo htmlspecialchars($prod['name']); ?>">
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <small class="text-uppercase text-muted fw-bold fs-7"><?php echo htmlspecialchars($prod['category_name']); ?></small>
                            <h6 class="fw-bold text-dark mt-1 mb-2"><?php echo htmlspecialchars($prod['name']); ?></h6>
                            <div class="mt-auto pt-2 d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-5 text-slate"><?php echo format_price($prod['price']); ?></span>
                                <a href="product-details.php?id=<?php echo $prod['id']; ?>" class="btn btn-sm btn-outline-dark">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Trust Banner -->
<section class="py-5">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <i class="fas fa-truck-fast fs-1 text-teal mb-3"></i>
                <h5 class="fw-bold">Fast Local Delivery</h5>
                <p class="text-muted small">Prompt order dispatch right to your doorstep anywhere in Lebanon.</p>
            </div>
            <div class="col-md-4">
                <i class="fas fa-paintbrush fs-1 text-teal mb-3"></i>
                <h5 class="fw-bold">Custom Personalization</h5>
                <p class="text-muted small">Add names, logos, or artworks onto your items hassle-free.</p>
            </div>
            <div class="col-md-4">
                <i class="fab fa-whatsapp fs-1 text-teal mb-3"></i>
                <h5 class="fw-bold">Direct Communication</h5>
                <p class="text-muted small">No complicated checkouts. Confirm orders in real-time via WhatsApp.</p>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>