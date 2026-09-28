</main>
<footer class="bg-slate text-white pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold text-white mb-3">VibeCraft Studio</h5>
                <p class="text-secondary fs-6">
                    Delivering custom drinkware, apparel, promotional items, and personalized gifts crafted to elevate your daily routine.
                </p>
                <div class="d-flex gap-3 fs-5 mt-3">
                    <a href="#" class="text-secondary text-hover-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-secondary text-hover-white"><i class="fab fa-facebook"></i></a>
                    <a href="https://wa.me/<?php echo $wa_phone; ?>" class="text-secondary text-hover-white"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold text-white mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="shop.php" class="text-secondary text-decoration-none">All Products</a></li>
                    <li><a href="offers.php" class="text-secondary text-decoration-none">Current Deals</a></li>
                    <li><a href="about.php" class="text-secondary text-decoration-none">Our Story</a></li>
                    <li><a href="contact.php" class="text-secondary text-decoration-none">Support & FAQ</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-white mb-3">Categories</h6>
                <ul class="list-unstyled">
                    <li><a href="shop.php?category=drinkware" class="text-secondary text-decoration-none">Drinkware & Flasks</a></li>
                    <li><a href="shop.php?category=fashion" class="text-secondary text-decoration-none">Custom Apparel</a></li>
                    <li><a href="shop.php?category=business-posters" class="text-secondary text-decoration-none">Business & Banners</a></li>
                    <li><a href="shop.php?category=customized" class="text-secondary text-decoration-none">Customized Gifts</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-white mb-3">Order directly</h6>
                <p class="text-secondary small">Browse our catalogue online and dispatch your orders straight to our WhatsApp sales line for quick confirmation.</p>
                <a href="https://wa.me/<?php echo $wa_phone; ?>" target="_blank" class="btn btn-whatsapp w-100 fw-bold">
                    <i class="fab fa-whatsapp me-2"></i> Join VIP WhatsApp Catalog
                </a>
            </div>
        </div>
        
        <hr class="border-secondary my-4">
        <div class="text-center text-secondary small">
            &copy; <?php echo date('Y'); ?> VibeCraft Studio. All Rights Reserved. Built for Web Dev Final Project.
        </div>
    </div>
</footer>

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/<?php echo $wa_phone; ?>?text=Hello%20VibeCraft%20team,%20I%20have%20an%20inquiry!" 
   class="floating-whatsapp" target="_blank" title="Chat with us">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>