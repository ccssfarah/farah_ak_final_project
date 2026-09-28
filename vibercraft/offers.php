<?php 
require_once 'includes/header.php';

$query = "SELECT p.*, c.name as category_name FROM products p 
          JOIN categories c ON p.category_id = c.id 
          WHERE p.old_price IS NOT NULL AND p.old_price > p.price AND p.status = 'active'
          ORDER BY p.id DESC";
$offers = mysqli_query($conn, $query);
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <span class="badge bg-danger mb-2 px-3 py-2 text-uppercase">Limited Time</span>
        <h2 class="fw-bold">Exclusive Deals & Offers</h2>
        <p class="text-muted">Take advantage of discounted rates on top promotional products</p>
    </div>

    <div class="row g-4">
        <?php if(mysqli_num_rows($offers) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($offers)): 
                $discount = round((($row['old_price'] - $row['price']) / $row['old_price']) * 100);
            ?>
                <div class="col-md-6 col-lg-3">
                    <div class="product-card h-100 d-flex flex-column position-relative">
                        <span class="position-absolute top-0 end-0 bg-danger text-white px-2 py-1 m-2 rounded fw-bold fs-7 z-1">
                            -<?php echo $discount; ?>%
                        </span>
                        <div class="card-img-container">
                            <img src="assets/images/products/<?php echo htmlspecialchars($row['image']); ?>" 
                                 onerror="this.src='https://via.placeholder.com/300x220?text=Special+Offer';" 
                                 alt="<?php echo htmlspecialchars($row['name']); ?>">
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <small class="text-muted fw-bold"><?php echo htmlspecialchars($row['category_name']); ?></small>
                            <h6 class="fw-bold mt-1 mb-2"><?php echo htmlspecialchars($row['name']); ?></h6>
                            <div class="mt-auto pt-2 d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold fs-5 text-danger"><?php echo format_price($row['price']); ?></span>
                                    <small class="text-decoration-line-through text-muted"><?php echo format_price($row['old_price']); ?></small>
                                </div>
                                <a href="product-details.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-dark">Grab Deal</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">No discounted offers available right now. Check back soon!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>