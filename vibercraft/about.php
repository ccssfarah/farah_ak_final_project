<?php
require_once 'includes/header.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    die('Database connection is not available.');
}

if (!isset($wa_phone)) {
    require_once __DIR__ . '/functions.php';
}
?>

<style>
    /* Creative & Professional Custom Styles for About Section */
    .about-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        position: relative;
        overflow: hidden;
    }
    .about-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(13, 148, 136, 0.15) 0%, transparent 60%);
        pointer-events: none;
    }
    .stat-card {
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease, border-color 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        border-color: #0d9488;
    }
    .feature-box {
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    .feature-box:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 24px -10px rgba(15, 23, 42, 0.12);
        border-color: #0d9488;
    }
    .icon-badge {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background-color: rgba(13, 148, 136, 0.1);
        color: #0d9488;
        font-size: 1.6rem;
    }
    .badge-teal-soft {
        background-color: rgba(13, 148, 136, 0.12);
        color: #0d9488;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
</style>

<!-- Hero / Brand Narrative Header -->
<section class="about-hero text-white py-5 my-0">
    <div class="container py-lg-4 position-relative z-1">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="badge badge-teal-soft px-3 py-2 rounded-pill text-uppercase mb-3">
                    <i class="fas fa-sparkles me-1"></i> Crafting Impressions Since Day One
                </span>
                <h1 class="display-4 fw-bold mb-3 lh-sm">
                    Where Creativity Meets <span class="text-teal" style="color: #0d9488;">Precision Print.</span>
                </h1>
                <p class="lead text-secondary mb-4">
                    At <strong>VibeCraft Studio</strong>, we turn raw ideas into high-definition branded apparel, premium merchandise, and bespoke crafts across Lebanon.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="shop.php" class="btn btn-teal btn-lg px-4 fw-bold">
                        <i class="fas fa-store me-2"></i> Explore Collection
                    </a>
                    <a href="contact.php" class="btn btn-outline-light btn-lg px-4 fw-bold">
                        <i class="fas fa-envelope me-2"></i> Get in Touch
                    </a>
                </div>
            </div>

            <!-- Stats Showcase -->
            <div class="col-lg-5">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="stat-card p-4 rounded-4 text-center">
                            <h2 class="display-6 fw-bold text-teal mb-1" style="color: #0d9488;">100%</h2>
                            <p class="small text-secondary mb-0">Custom Tailored</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card p-4 rounded-4 text-center">
                            <h2 class="display-6 fw-bold text-teal mb-1" style="color: #0d9488;">24/7</h2>
                            <p class="small text-secondary mb-0">WhatsApp Ordering</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12">
                            <div class="stat-card p-4 rounded-4 text-center">
                                <h2 class="display-6 fw-bold text-white mb-1">Fast</h2>
                                <p class="small text-secondary mb-0">Nationwide Delivery</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card p-4 rounded-4 text-center">
                            <h2 class="display-6 fw-bold text-white mb-1">5★</h2>
                            <p class="small text-secondary mb-0">Client Satisfaction</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Pillars / Core Strengths -->
<section class="py-5 bg-white">
    <div class="container py-lg-4">
        <div class="text-center max-w-2xl mx-auto mb-5">
            <span class="badge badge-teal-soft px-3 py-2 rounded-pill text-uppercase mb-2">Why VibeCraft?</span>
            <h2 class="fw-bold fs-1 text-slate">Built Around Quality & Craftsmanship</h2>
            <p class="text-muted">We combine modern print technology with premium materials to ensure every piece stands out.</p>
        </div>

        <div class="row g-4">
            <!-- Pillar 1 -->
            <div class="col-md-4">
                <div class="feature-box p-4 rounded-4 bg-white h-100">
                    <div class="icon-badge mb-4">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Premium Fabrics & Materials</h5>
                    <p class="text-muted small mb-0">
                        We source heavy-weight cottons, ultra-soft blends, and durable accessories designed to maintain color, fit, and softness through repeated washes.
                    </p>
                </div>
            </div>

            <!-- Pillar 2 -->
            <div class="col-md-4">
                <div class="feature-box p-4 rounded-4 bg-white h-100">
                    <div class="icon-badge mb-4">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Vibrant & Crisp Prints</h5>
                    <p class="text-muted small mb-0">
                        Using advanced DTF (Direct-to-Film) and screen printing technology, we ensure your logos and artwork display rich colors and sharp detail.
                    </p>
                </div>
            </div>

            <!-- Pillar 3 -->
            <div class="col-md-4">
                <div class="feature-box p-4 rounded-4 bg-white h-100">
                    <div class="icon-badge mb-4">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Seamless Direct Ordering</h5>
                    <p class="text-muted small mb-0">
                        No confusing checkout delays. Choose your items and initiate instant customization or order verification straight on WhatsApp.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Interactive Story / Process Timeline -->
<section class="py-5 bg-light">
    <div class="container py-lg-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="position-relative">
                    <div class="bg-slate p-4 p-md-5 rounded-4 text-white shadow">
                        <h3 class="fw-bold text-white mb-3">How We Craft Your Vision</h3>
                        <div class="d-flex align-items-start mb-4">
                            <span class="badge bg-teal rounded-circle p-2 me-3 fs-6">1</span>
                            <div>
                                <h6 class="fw-bold text-white mb-1">Design & Mockup</h6>
                                <p class="small text-secondary mb-0">You send us your ideas, graphics, or logos. We help refine and position them on your selected gear.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-4">
                            <span class="badge bg-teal rounded-circle p-2 me-3 fs-6">2</span>
                            <div>
                                <h6 class="fw-bold text-white mb-1">Precision Production</h6>
                                <p class="small text-secondary mb-0">We print and inspect every single item individually for durability, alignment, and color quality.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <span class="badge bg-teal rounded-circle p-2 me-3 fs-6">3</span>
                            <div>
                                <h6 class="fw-bold text-white mb-1">Nationwide Delivery</h6>
                                <p class="small text-secondary mb-0">Carefully packaged and dispatched to your doorstep anywhere across Beirut and Mount Lebanon.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="ps-lg-3">
                    <span class="badge badge-teal-soft px-3 py-2 rounded-pill text-uppercase mb-2">Our Mission</span>
                    <h2 class="fw-bold text-dark mb-3">Empowering Personal Brands & Local Businesses</h2>
                    <p class="text-muted mb-4">
                        Whether you are a startup looking to equip your team with branded uniforms, a creator launching custom merch, or an individual wanting a 1-of-1 personalized gift—we're built to scale with your needs without sacrificing quality.
                    </p>
                    <div class="p-3 border-start border-4 border-teal bg-white rounded-end shadow-sm">
                        <p class="mb-0 text-dark italic fw-semibold">
                            "Every custom garment tells a story. Our job is to make sure your story looks exceptional."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Direct Call-to-Action Banner -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="bg-slate rounded-4 p-4 p-md-5 text-white text-center shadow-lg position-relative overflow-hidden">
            <h2 class="fw-bold display-6 mb-2">Ready to bring your ideas to life?</h2>
            <p class="text-secondary mx-auto mb-4" style="max-width: 600px;">
                Chat with our team right now on WhatsApp for instant inquiries, custom bulk quotes, or design consultations.
            </p>
            <a href="https://wa.me/<?php echo isset($wa_phone) ? $wa_phone : ''; ?>?text=Hello%20VibeCraft%20Studio!%20I'd%20like%20to%20discuss%20a%20custom%20order." 
               target="_blank" 
               class="btn btn-teal btn-lg px-5 py-3 rounded-pill fw-bold shadow">
                <i class="fab fa-whatsapp fs-5 me-2"></i> Start WhatsApp Consultation
            </a>
        </div>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
