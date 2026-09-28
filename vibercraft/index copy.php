<?php 
require_once 'includes/header.php'; 

// Fetch Categories
$cat_query = "SELECT * FROM categories LIMIT 6";
$cat_result = mysqli_query($conn, $cat_query);

// Fetch Featured Products
$feat_query = "SELECT p.*, c.name as category_name FROM products p 
              JOIN categories c ON p.category_id = c.id 
              WHERE p.is_featured = 1 AND p.status = 'active' LIMIT 4";
$feat_result = mysqli_query($conn, $feat_query);
?>

<!-- Hero Section -->
<section class="bg-slate text-white py-5 position-relative">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="badge bg-teal mb-3 px-3 py-2 text-uppercase tracking-wider">Custom Printing & Retail</span>
                <h1 class="display-4 fw-bold mb-3">Elevate Your Everyday Essentials.</h1>
                <p class="lead text-secondary mb-4">Discover curated drinkware, apparel, and customized promotional gifts crafted for personal and corporate use.</p>
                <div class="d-flex gap-3">
                    <a href="shop.php" class="btn btn-primary btn-lg px-4">Browse Shop</a>
                    <a href="https://wa.me/<?php echo $wa_phone; ?>?text=Hello!%20I'd%20like%20to%20inquire%20about%20custom%20branding." class="btn btn-outline-light btn-lg px-4">Custom Orders</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="rounded-4 overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1517256064527-09c73fc73e38?auto=format&fit=crop&w=800&q=80" alt="VibeCraft Products" class="img-fluid">
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