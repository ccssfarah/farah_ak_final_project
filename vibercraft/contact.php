<?php
require_once 'includes/header.php';

// // Ensure database connection and functions exist
if (!isset($conn)) {
    require_once __DIR__ . '/includes/db.php';
}
if (!isset($wa_phone)) {
    require_once __DIR__ . '/includes/functions.php';

}
if (!isset($conn) || !($conn instanceof mysqli)) {
    die('Database connection is not available.');
}


$contact_success = "";
$contact_error = "";

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact_form'])) {
    $name    = sanitize($conn, $_POST['name'] ?? '');
    $email   = sanitize($conn, $_POST['email'] ?? '');
    $phone   = sanitize($conn, $_POST['phone'] ?? '');
    $message = sanitize($conn, $_POST['message'] ?? '');

    if (!empty($name) && !empty($email) && !empty($message)) {
        // Prepared statement for security
        $stmt = $conn->prepare("INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $message);

        if ($stmt->execute()) {
            $contact_success = "Thank you! Your inquiry has been received. We will get back to you shortly.";
        } else {
            $contact_error = "An error occurred while saving your message. Please try again.";
        }
        $stmt->close();
    } else {
        $contact_error = "Please fill in all required fields (Name, Email, Message).";
    }
}
?>

<section class="py-5 bg-light" id="contact-section">
    <div class="container py-lg-3">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-5">
            <span class="badge bg-teal-soft text-teal text-uppercase px-3 py-2 rounded-pill fw-bold mb-2">
                Get In Touch
            </span>
            <h2 class="fw-bold text-slate">Have Questions or Custom Order Requests?</h2>
            <p class="text-muted">Reach out via WhatsApp for immediate quotes or send us an inquiry below.</p>
        </div>

        <div class="row g-4 g-lg-5">
            <!-- Sidebar Info -->
            <div class="col-lg-5">
                <div class="bg-slate text-white p-4 p-md-5 rounded-4 shadow-sm h-100 d-flex flex-column justify-content-between" style="background-color: #0f172a;">
                    <div>
                        <h4 class="fw-bold text-white mb-4">Contact Details</h4>

                        <div class="d-flex align-items-start mb-4">
                            <div class="p-2 bg-teal-soft rounded-3 text-teal me-3" style="color: #0d9488;">
                                <i class="fab fa-whatsapp fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-white mb-1">WhatsApp Orders & Support</h6>
                                <a href="https://wa.me/<?php echo isset($wa_phone) ? preg_replace('/[^0-9]/', '', $wa_phone) : ''; ?>" 
                                   target="_blank" 
                                   class="text-teal text-decoration-none fw-semibold" style="color: #0d9488;">
                                    +<?php echo isset($wa_phone) ? htmlspecialchars($wa_phone) : ''; ?>
                                </a>
                                <small class="d-block text-secondary">Instant customer support</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <div class="p-2 bg-teal-soft rounded-3 text-teal me-3" style="color: #0d9488;">
                                <i class="fas fa-envelope fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-white mb-1">Email Inquiry</h6>
                                <a href="mailto:info@vibecraftstudio.com" class="text-secondary text-decoration-none">
                                    info@vibecraftstudio.com
                                </a>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <div class="p-2 bg-teal-soft rounded-3 text-teal me-3" style="color: #0d9488;">
                                <i class="fas fa-location-dot fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-white mb-1">Location & Service Area</h6>
                                <p class="text-secondary small mb-0">Beirut & Mount Lebanon (Nationwide Delivery)</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-top border-secondary pt-4 mt-4">
                        <h6 class="fw-bold text-white mb-2"><i class="fas fa-clock me-2 text-teal" style="color: #0d9488;"></i> Working Hours</h6>
                        <p class="text-secondary small mb-0">Monday – Saturday: 9:00 AM – 7:00 PM<br>Sunday: Closed</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4 bg-white">
                    <h4 class="fw-bold text-dark mb-4">Send Us a Message</h4>

                    <?php if (!empty($contact_success)): ?>
                        <div class="alert alert-success d-flex align-items-center rounded-3 mb-4" role="alert">
                            <i class="fas fa-check-circle fs-5 me-2"></i>
                            <div><?php echo $contact_success; ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($contact_error)): ?>
                        <div class="alert alert-danger d-flex align-items-center rounded-3 mb-4" role="alert">
                            <i class="fas fa-exclamation-circle fs-5 me-2"></i>
                            <div><?php echo $contact_error; ?></div>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="#contact-section">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. John Doe" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Phone / WhatsApp Number</label>
                            <input type="tel" name="phone" class="form-control" placeholder="+961 70 000 000">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Message / Custom Order Details <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control" rows="4" placeholder="Describe the item, print size, or custom request..." required></textarea>
                        </div>

                        <button type="submit" name="submit_contact_form" class="btn btn-teal btn-lg w-100 fw-bold rounded-3 shadow-sm" style="background-color: #0d9488; color: #fff;">
                            <i class="fas fa-paper-plane me-2"></i> Submit Inquiry
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
<?php require_once 'includes/footer.php'; ?>