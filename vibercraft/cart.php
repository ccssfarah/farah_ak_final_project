<?php
require_once 'includes/header.php';

// Handle Database Logging on Cart Checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order'])) {$name    = sanitize($conn,$_POST['customer_name']);
    $phone   = sanitize($conn, $_POST['phone']);$address = sanitize($conn,$_POST['address']);
    $total   = (float)$_POST['cart_total'];

    $sql = "INSERT INTO orders (customer_name, phone, address, total, status) 
            VALUES ('$name', '$phone', '$address',$total, 'pending')";

    if (mysqli_query($conn, $sql)) {$order_id = mysqli_insert_id($conn);$redirect_wa = sanitize($conn,$_POST['wa_redirect_url']);
        
        echo "<script>
                localStorage.removeItem('vibecraft_cart');
                window.location.href = '$redirect_wa';
              </script>";
        exit;
    }
}
?>

<div class="container py-5">
    <h2 class="fw-bold mb-4">Your Shopping Cart</h2>

    <div class="row g-4">
        <!-- Cart Items Table -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-3">
                <div class="table-responsive">
                    <table class="table align-middle" id="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="cart-items-container">
                            <!-- Populated dynamically via JS -->
                        </tbody>
                    </table>
                </div>
                <div id="empty-cart-msg" class="text-center py-4 d-none">
                    <p class="text-muted mb-0">Your cart is currently empty.</p>
                    <a href="shop.php" class="btn btn-outline-dark btn-sm mt-2">Explore Shop</a>
                </div>
            </div>
        </div>

        <!-- Checkout & WhatsApp Dispatch -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-3">Order Summary</h5>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span>Estimated Total:</span>
                    <strong class="fs-5 text-slate" id="cart-total">$0.00</strong>
                </div>

                <form id="checkout-form" method="POST">
                    <input type="hidden" name="cart_total" id="input-cart-total" value="0">
                    <input type="hidden" name="wa_redirect_url" id="input-wa-url" value="">

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" name="customer_name" id="cust-name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Phone Number</label>
                        <input type="tel" name="phone" id="cust-phone" class="form-control" placeholder="+961..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Delivery Address</label>
                        <textarea name="address" id="cust-address" class="form-control" rows="2" required></textarea>
                    </div>

                    <button type="submit" name="submit_order" id="dispatch-btn" class="btn btn-whatsapp w-100 fw-bold py-2" disabled>
                        <i class="fab fa-whatsapp me-2"></i> Confirm & Order via WhatsApp
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const waPhone = "<?php echo $wa_phone; ?>";
    const container = document.getElementById('cart-items-container');
    const emptyMsg = document.getElementById('empty-cart-msg');
    const totalEl = document.getElementById('cart-total');
    const inputTotal = document.getElementById('input-cart-total');
    const inputWaUrl = document.getElementById('input-wa-url');
    const dispatchBtn = document.getElementById('dispatch-btn');

    function renderCart() {
        let cart = JSON.parse(localStorage.getItem('vibecraft_cart')) || [];
        container.innerHTML = '';

        if (cart.length === 0) {
            emptyMsg.classList.remove('d-none');
            totalEl.textContent = '$0.00';
            inputTotal.value = 0;
            dispatchBtn.disabled = true;
            return;
        }

        emptyMsg.classList.add('d-none');
        dispatchBtn.disabled = false;
        let total = 0;

        cart.forEach((item, index) => {
            let itemTotal = item.price * item.qty;
            total += itemTotal;

            let tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="fw-bold">${item.name}</td>
                <td>$${item.price.toFixed(2)}</td>
                <td>${item.qty}</td>
                <td class="fw-bold">$${itemTotal.toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-outline-danger" onclick="removeItem(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            `;
            container.appendChild(tr);
        });

        totalEl.textContent = `$${total.toFixed(2)}`;
        inputTotal.value = total.toFixed(2);
        updateWaUrl(cart, total);
    }

    window.removeItem = function(index) {
        let cart = JSON.parse(localStorage.getItem('vibecraft_cart')) || [];
        cart.splice(index, 1);
        localStorage.setItem('vibecraft_cart', JSON.stringify(cart));
        renderCart();
    };

    function updateWaUrl(cart, total) {
        let name = document.getElementById('cust-name').value;
        let address = document.getElementById('cust-address').value;

        let msg = `Hello VibeCraft Studio! I'd like to place an order:\n\n`;
        cart.forEach(item => {
            msg += `- ${item.name} (x${item.qty}) : $${(item.price * item.qty).toFixed(2)}\n`;
        });
        msg += `\nTotal: $${total.toFixed(2)}\n`;
        msg += `Customer: ${name}\n`;
        msg += `Address: ${address}`;

        inputWaUrl.value = `https://wa.me/${waPhone}?text=` + encodeURIComponent(msg);
    }

    document.getElementById('checkout-form').addEventListener('input', function() {
        let cart = JSON.parse(localStorage.getItem('vibecraft_cart')) || [];
        let total = parseFloat(inputTotal.value) || 0;
        updateWaUrl(cart, total);
    });

    renderCart();
});
</script>

<?php require_once 'includes/footer.php'; ?>