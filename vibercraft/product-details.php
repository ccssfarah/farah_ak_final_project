<?php 
require_once 'includes/header.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    die('Database connection is not available.');
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: shop.php");
    exit;
}

$id = (int)$_GET['id'];$query = "SELECT p.*, c.name as category_name FROM products p 
          JOIN categories c ON p.category_id = c.id 
          WHERE p.id = $id AND p.status = 'active'";
$result = mysqli_query($conn,$query);

if (mysqli_num_rows($result) === 0) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Product not found.</div></div>";
    require_once 'includes/footer.php';
    exit;
}

$product = mysqli_fetch_assoc($result);

// Generate initial pre-filled string for single-click order
$initial_msg = "Hello VibeCraft Studio! I'm interested in ordering:\n" .
               "- Item: " . $product['name'] . "\n" .
               "- Unit Price: $" . $product['price'] . "\n" .
               "- Quantity: 1\n" .
               "Please confirm availability!";
$wa_url = get_whatsapp_link($wa_phone,$initial_msg);
?>

<div class="container py-5">
    <div class="row g-5">
        <!-- Product Image -->
        <div class="col-md-6">
            <div class="bg-light rounded-4 p-4 text-center border">
                <img id="mainImage" src="assets/images/products/<?php echo htmlspecialchars($product['image']); ?>" 
                     onerror="this.src='https://via.placeholder.com/500x400?text=VibeCraft';" 
                     class="img-fluid rounded" style="max-height: 400px; object-fit: contain;">
            </div>
        </div>

        <!-- Product Actions -->
        <div class="col-md-6">
            <span class="badge bg-teal mb-2"><?php echo htmlspecialchars($product['category_name']); ?></span>
            <h2 class="fw-bold mb-2"><?php echo htmlspecialchars($product['name']); ?></h2>
            
            <div class="mb-3">
                <span class="fs-3 fw-bold text-slate"><?php echo format_price($product['price']); ?></span>
                <?php if (!empty($product['old_price'])): ?>
                    <span class="fs-5 text-decoration-line-through text-muted ms-2"><?php echo format_price($product['old_price']); ?></span>
                <?php endif; ?>
            </div>

            <p class="text-secondary mb-4"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

            <div class="p-3 bg-white rounded border mb-4">
                <label class="form-label fw-bold">Select Quantity:</label>
                <div class="input-group style-qty-input mb-3" style="width: 140px;">
                    <button class="btn btn-outline-secondary" type="button" id="btn-minus">-</button>
                    <input type="number" id="item-qty" class="form-control text-center" value="1" min="1" max="<?php echo $product['quantity']; ?>">
                    <button class="btn btn-outline-secondary" type="button" id="btn-plus">+</button>
                </div>

                <p class="small text-muted mb-0">
                    <i class="fas fa-check-circle text-success me-1"></i> In Stock: <?php echo $product['quantity']; ?> units available
                </p>
            </div>

            <!-- WhatsApp Action -->
            <a id="wa-order-btn" href="<?php echo $wa_url; ?>" target="_blank" class="btn btn-whatsapp btn-lg w-100 fw-bold py-3 shadow-sm">
                <i class="fab fa-whatsapp me-2 fs-5"></i> Order via WhatsApp
            </a>
            
            <small class="text-muted text-center d-block mt-2">
                Clicking redirects you directly to WhatsApp with your pre-filled inquiry.
            </small>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const qtyInput = document.getElementById('item-qty');
    const btnMinus = document.getElementById('btn-minus');
    const btnPlus = document.getElementById('btn-plus');
    const waBtn = document.getElementById('wa-order-btn');

    const productName = "<?php echo addslashes($product['name']); ?>";
    const productPrice = "<?php echo $product['price']; ?>";
    const waPhone = "<?php echo $wa_phone; ?>";

    function updateWaLink() {
        let qty = parseInt(qtyInput.value) || 1;
        let msg = `Hello VibeCraft Studio! I am interested in ordering:\n` +
                  `- Item: ${productName}\n` +
                  `- Unit Price: $${productPrice}\n` +
                  `- Quantity: ${qty}\n` +
                  `- Total Estimated: $${(qty * parseFloat(productPrice)).toFixed(2)}\n\n` +
                  `Please confirm availability!`;
        
        waBtn.href = `https://wa.me/${waPhone}?text=` + encodeURIComponent(msg);
    }

    btnMinus.addEventListener('click', () => {
        if (qtyInput.value > 1) {
            qtyInput.value = parseInt(qtyInput.value) - 1;
            updateWaLink();
        }
    });

    btnPlus.addEventListener('click', () => {
        qtyInput.value = parseInt(qtyInput.value) + 1;
        updateWaLink();
    });

    qtyInput.addEventListener('change', updateWaLink);
});
</script>

<?php require_once 'includes/footer.php'; ?>