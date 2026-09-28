<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';
if (!isset($conn) || !($conn instanceof mysqli)) {
    die('Database connection is not available.');
}

// Update Order Status
if (isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $status   = sanitize($conn, $_POST['status']);
    mysqli_query($conn, "UPDATE orders SET status = '$status' WHERE id = $order_id");
}

// Fetch Orders with Joined Details
$query = "SELECT * FROM orders ORDER BY id DESC";
$orders = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders | VibeCraft Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Client Orders</h3>
        <a href="dashboard.php" class="btn btn-outline-secondary">Dashboard</a>
    </div>

    <div class="card border-0 shadow-sm p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($orders) > 0): ?>
                        <?php while($ord = mysqli_fetch_assoc($orders)): ?>
                            <tr>
                                <td>#<?php echo $ord['id']; ?></td>
                                <td class="fw-bold"><?php echo htmlspecialchars($ord['customer_name']); ?></td>
                                <td>
                                    <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $ord['phone']); ?>" target="_blank" class="text-success text-decoration-none fw-bold">
                                        <i class="fab fa-whatsapp me-1"></i><?php echo htmlspecialchars($ord['phone']); ?>
                                    </a>
                                </td>
                                <td><small><?php echo htmlspecialchars($ord['address']); ?></small></td>
                                <td class="fw-bold"><?php echo format_price($ord['total']); ?></td>
                                <td><small><?php echo date('M d, Y H:i', strtotime($ord['order_date'])); ?></small></td>
                                <td>
                                    <form method="POST" class="d-flex gap-1">
                                        <input type="hidden" name="order_id" value="<?php echo $ord['id']; ?>">
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="pending" <?php echo ($ord['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                            <option value="completed" <?php echo ($ord['status'] === 'completed') ? 'selected' : ''; ?>>Completed</option>
                                            <option value="cancelled" <?php echo ($ord['status'] === 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                        <button type="submit" name="update_status" class="btn btn-sm btn-dark"><i class="fas fa-check"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center text-muted">No orders available.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>