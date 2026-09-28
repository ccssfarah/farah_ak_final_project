<?php
require_once 'includes/header.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    die('Database connection is not available.');
}


// Query categories along with the count of active products in each category
$query_categories = "
    SELECT c.*, COUNT(p.id) AS product_count 
    FROM categories c 
    LEFT JOIN products p ON c.id = p.category_id 
    GROUP BY c.id 
    ORDER BY c.name ASC
";

$categories_result = mysqli_query($conn,$query_categories);
?>

<style>
    .category-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #e2e8f0;
        background-color: #ffffff;
    }
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08) !important;
        border-color: #0d9488 !important;
    }
    .category-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background-color: rgba(13, 148, 136, 0.1);
        color: #0d9488;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .badge-teal {
        background-color: #0d9488;
        color: #ffffff;
    }
</style>

<section class="py-5 bg-light">
    <div class="container">
        <!-- Section Header -->
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-teal-soft text-teal text-uppercase px-3 py-2 rounded-pill fw-bold mb-2">
                    Browse Catalog
                </span>
                <h2 class="fw-bold text-slate mb-0">Shop by Category</h2>
            </div>
            <a href="shop.php" class="btn btn-outline-dark rounded-pill px-4 btn-sm fw-bold">
                View All Products <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>

        <!-- Categories Grid -->
        <div class="row g-4">
            <?php if ($categories_result && mysqli_num_rows($categories_result) > 0): ?>
                <?php while ($cat = mysqli_fetch_assoc($categories_result)): ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="shop.php?category=<?php echo $cat['id']; ?>" class="text-decoration-none">
                            <div class="card category-card h-100 rounded-4 p-3 shadow-sm text-center">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center p-2">
                                    
                                    <!-- Category Icon / Fallback -->
                                    <div class="category-icon-wrapper mb-3">
                                        <i class="<?php echo !empty($cat['icon']) ? htmlspecialchars($cat['icon']) : 'fas fa-tags'; ?>"></i>
                                    </div>

                                    <!-- Category Name -->
                                    <h5 class="fw-bold text-dark mb-1">
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </h5>

                                    <!-- Category Description (if available) -->
                                    <?php if (!empty($cat['description'])): ?>
                                        <p class="text-muted small mb-2 text-truncate w-100" style="max-width: 180px;">
                                            <?php echo htmlspecialchars($cat['description']); ?>
                                        </p>
                                    <?php endif; ?>

                                    <!-- Product Count Badge -->
                                    <span class="badge bg-light text-secondary rounded-pill border px-3 py-1 mt-auto">
                                        <?php echo $cat['product_count']; ?> Products
                                    </span>

                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-folder-open fs-1 d-block mb-3 text-secondary"></i>
                        <p class="mb-0">No product categories found.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
