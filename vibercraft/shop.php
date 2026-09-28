<?php 
require_once 'includes/header.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    die('Database connection is not available.');
}


// Build Dynamic SQL Query based on Search & Category Filters
$where_clauses = ["p.status = 'active'"];

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = sanitize($conn, $_GET['search']);
    $where_clauses[] = "(p.name LIKE '%$search%' OR p.description LIKE '%$search%')";
}

if (isset($_GET['category']) && !empty(trim($_GET['category']))) {
    $cat_slug = sanitize($conn, $_GET['category']);
    $where_clauses[] = "c.slug = '$cat_slug'";
}

$where_sql = implode(" AND ", $where_clauses);

$query = "SELECT p.*, c.name as category_name, c.slug as category_slug 
          FROM products p 
          JOIN categories c ON p.category_id = c.id 
          WHERE $where_sql 
          ORDER BY p.id DESC";

$products = mysqli_query($conn, $query);
$all_cats = mysqli_query($conn, "SELECT * FROM categories");
?>

<div class="container py-5">
    <!-- Header Controls -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Shop Catalog</h2>
            <p class="text-muted mb-0">Discover our full product range</p>
        </div>
        <div class="col-md-6">
            <form action="shop.php" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Search products..." 
                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="btn btn-slate"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <!-- Category Sidebar -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm p-3">
                <h6 class="fw-bold mb-3">Filter Categories</h6>
                <div class="list-group list-group-flush">
                    <a href="shop.php" class="list-group-item list-group-item-action border-0 px-0 <?php echo !isset($_GET['category']) ? 'fw-bold text-teal' : ''; ?>">
                        All Categories
                    </a>
                    <?php while($cat = mysqli_fetch_assoc($all_cats)): ?>
                        <a href="shop.php?category=<?php echo $cat['slug']; ?>" 
                           class="list-group-item list-group-item-action border-0 px-0 <?php echo (isset($_GET['category']) && $_GET['category'] == $cat['slug']) ? 'fw-bold text-teal' : ''; ?>">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9">
            <?php if (mysqli_num_rows($products) > 0): ?>
                <div class="row g-4">
                    <?php while($row = mysqli_fetch_assoc($products)): ?>
                        <div class="col-md-4">
                            <div class="product-card h-100 d-flex flex-column">
                                <div class="card-img-container">
                                    <img src="assets/images/products/<?php echo htmlspecialchars($row['image']); ?>" 
                                         onerror="this.src='https://via.placeholder.com/300x220?text=VibeCraft';" 
                                         alt="<?php echo htmlspecialchars($row['name']); ?>">
                                </div>
                                <div class="p-3 d-flex flex-column flex-grow-1">
                                    <span class="badge bg-light text-dark align-self-start mb-2"><?php echo htmlspecialchars($row['category_name']); ?></span>
                                    <h6 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($row['name']); ?></h6>
                                    
                                    <div class="mt-auto pt-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-bold fs-5 text-slate"><?php echo format_price($row['price']); ?></span>
                                            <?php if ($row['old_price']): ?>
                                                <small class="text-decoration-line-through text-muted ms-1"><?php echo format_price($row['old_price']); ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <a href="product-details.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-dark">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-info-circle fs-3 mb-3 d-block"></i>
                    No products matched your specified query.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>