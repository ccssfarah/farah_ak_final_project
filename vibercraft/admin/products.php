<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    die('Database connection is not available.');
}
// Handle Product Deletion
if (isset($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $delete_id");
    header("Location: products.php?msg=deleted");
    exit;
}

$query = "SELECT p.*, c.name as category_name FROM products p 
          JOIN categories c ON p.category_id = c.id 
          ORDER BY p.id DESC";
$products = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products | VibeCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Inventory & Products</h3>
        <div>
            <a href="product-add.php" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Add Product</a>
            <a href="dashboard.php" class="btn btn-outline-secondary">Dashboard</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($products)): ?>
                        <tr>
                            <td>
                                <img src="../assets/images/products/<?php echo htmlspecialchars($row['image']); ?>" 
                                     onerror="this.src='https://via.placeholder.com/50';" 
                                     width="50" height="50" class="rounded object-fit-cover">
                            </td>
                            <td class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                            <td><?php echo format_price($row['price']); ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td>
                                <?php if($row['is_featured']): ?>
                                    <span class="badge bg-success">Yes</span>
                                <?php else: ?>
                                    <span class="badge bg-light text-dark">No</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="product-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <a href="products.php?delete=<?php echo $row['id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this product?');" 
                                   class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>