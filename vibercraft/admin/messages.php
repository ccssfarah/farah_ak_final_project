<?php
// Include admin authentication guard, database connection, and helper functions
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// --- HANDLE MESSAGE DELETION ---
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    
    // Use prepared statement for security
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bind_param("i", $del_id);
    
    if ($stmt->execute()) {
        header("Location: messages.php?status=deleted");
    } else {
        header("Location: messages.php?status=error");
    }
    $stmt->close();
    exit;
}

// --- FETCH MESSAGES ---
// Order by ID descending so newest messages appear at the top
$query = "SELECT * FROM messages ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Messages | Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .table-responsive { min-height: 300px; }
        .msg-text { max-width: 350px; word-wrap: break-word; white-space: pre-line; }
    </style>
</head>
<body class="bg-light">

<div class="container-fluid py-4 px-md-5">
    
    <!-- Top Bar Navigation & Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Customer Messages</h2>
            <p class="text-muted mb-0">Manage customer inquiries sent through the website contact form.</p>
        </div>
        <a href="dashboard.php" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>

    <!-- Alert Notifications -->
    <?php if (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> Message successfully deleted.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> An error occurred while attempting to delete the message.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Messages Data Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="ps-3" style="width: 140px;">Date & Time</th>
                            <th scope="col">Sender Name</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Phone / WhatsApp</th>
                            <th scope="col">Message Content</th>
                            <th scope="col" class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && mysqli_num_rows($result) > 0): ?>
                            <?php while ($msg = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <!-- Received Timestamp -->
                                    <td class="ps-3">
                                        <div class="fw-semibold text-dark">
                                            <?php echo date('M d, Y', strtotime($msg['created_at'])); ?>
                                        </div>
                                        <div class="text-muted small">
                                            <?php echo date('h:i A', strtotime($msg['created_at'])); ?>
                                        </div>
                                    </td>

                                    <!-- Sender Name -->
                                    <td class="fw-bold text-capitalize">
                                        <?php echo htmlspecialchars($msg['name']); ?>
                                    </td>

                                    <!-- Email Link -->
                                    <td>
                                        <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>" class="text-decoration-none">
                                            <i class="fas fa-envelope text-muted me-1"></i>
                                            <?php echo htmlspecialchars($msg['email']); ?>
                                        </a>
                                    </td>

                                    <!-- WhatsApp/Phone Link -->
                                    <td>
                                        <?php if (!empty($msg['phone'])): ?>
                                            <?php 
                                                // Clean phone string to numeric digits for wa.me URL
                                                $clean_phone = preg_replace('/[^0-9]/', '', $msg['phone']); 
                                            ?>
                                            <a href="https://wa.me/<?php echo $clean_phone; ?>" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="fab fa-whatsapp me-1"></i> <?php echo htmlspecialchars($msg['phone']); ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">Not provided</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Message Text Body -->
                                    <td class="msg-text small text-secondary">
                                        <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                                    </td>

                                    <!-- Action Buttons -->
                                    <td class="text-center">
                                        <a href="messages.php?delete=<?php echo $msg['id']; ?>" 
                                           onclick="return confirm('Are you sure you want to permanently delete this message?');" 
                                           class="btn btn-sm btn-outline-danger" 
                                           title="Delete Message">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fs-1 d-block mb-3 text-secondary"></i>
                                    No customer messages found in the database.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>