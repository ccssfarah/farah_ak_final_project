<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    die('Database connection is not available.');
}

// Fetch Core Dashboard Statistics
$count_products   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products"))['total'];
$count_categories = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM categories"))['total'];
$count_orders     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders"))['total'];
$pending_orders   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE status='pending'"))['total'];
$count_messages   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM messages"))['total'];

// Recent Orders Query
$recent_orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | VibeCraft Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark sticky-top p-3">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="dashboard.php">VibeCraft Admin Panel</a>
        <div class="d-flex align-items-center text-white gap-3">
            <span><i class="fas fa-user-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['admin_user']); ?></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container-fluid my-4">
    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-md-2 mb-4">
            <div class="list-group shadow-sm">
                <a href="dashboard.php" class="list-group-item list-group-item-action active"><i class="fas fa-chart-line me-2"></i> Overview</a>
                <a href="products.php" class="list-group-item list-group-item-action"><i class="fas fa-box me-2"></i> Products</a>
                <a href="product-add.php" class="list-group-item list-group-item-action"><i class="fas fa-plus-circle me-2"></i> Add Product</a>
                <a href="categories.php" class="list-group-item list-group-item-action"><i class="fas fa-tags me-2"></i> Categories</a>
                <a href="orders.php" class="list-group-item list-group-item-action"><i class="fas fa-shopping-cart me-2"></i> Orders</a>
                <a href="messages.php" class="list-group-item list-group-item-action"><i class="fas fa-envelope me-2"></i> Messages</a>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="col-md-10">
            <h3 class="fw-bold mb-4">System Overview</h3>

            <!-- Key Metric Statistics -->
            <div class="row g-3 mb-4">
                <div class="col-md-2">
                    <div class="card border-0 shadow-sm p-3 bg-white">
                        <small class="text-muted fw-bold">PRODUCTS</small>
                        <h2 class="fw-bold mb-0 text-primary"><?php echo $count_products; ?></h2>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-0 shadow-sm p-3 bg-white">
                        <small class="text-muted fw-bold">CATEGORIES</small>
                        <h2 class="fw-bold mb-0 text-success"><?php echo $count_categories; ?></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm p-3 bg-white">
                        <small class="text-muted fw-bold">TOTAL ORDERS</small>
                        <h2 class="fw-bold mb-0 text-dark"><?php echo $count_orders; ?></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm p-3 bg-white">
                        <small class="text-muted fw-bold">PENDING ORDERS</small>
                        <h2 class="fw-bold mb-0 text-warning"><?php echo $pending_orders; ?></h2>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-0 shadow-sm p-3 bg-white">
                        <small class="text-muted fw-bold">MESSAGES</small>
                        <h2 class="fw-bold mb-0 text-info"><?php echo $count_messages; ?></h2>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-3">Recent Direct Orders</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($recent_orders) > 0): ?>
                                <?php while($ord = mysqli_fetch_assoc($recent_orders)): ?>
                                    <tr>
                                        <td>#<?php echo $ord['id']; ?></td>
                                        <td><?php echo htmlspecialchars($ord['customer_name']); ?></td>
                                        <td><?php echo htmlspecialchars($ord['phone']); ?></td>
                                        <td><?php echo format_price($ord['total']); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $ord['status'] === 'completed' ? 'success' : ($ord['status'] === 'pending' ? 'warning' : 'danger'); ?>">
                                                <?php echo ucfirst($ord['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('M d, Y', strtotime($ord['order_date'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center text-muted">No recent orders recorded.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>