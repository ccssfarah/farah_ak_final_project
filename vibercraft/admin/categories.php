<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    die('Database connection is not available.');
}

$message = "";
$error = "";

// --- HANDLE CATEGORY CREATION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $name        = sanitize($conn, $_POST['name']);
    $slug        = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    $description = sanitize($conn, $_POST['description']);
    $icon        = sanitize($conn, $_POST['icon'] ?? 'fas fa-folder');

    if (!empty($name)) {
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO categories (name, slug, description, icon) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $slug, $description, $icon);

        if ($stmt->execute()) {
            $message = "Category added successfully!";
        } else {
            $error = "Error: Category name or slug already exists.";
        }
        $stmt->close();
    } else {
        $error = "Please enter a valid category name.";
    }
}

// --- HANDLE CATEGORY DELETION ---
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $del_id);
    $stmt->execute();
    $stmt->close();

    header("Location: categories.php");
    exit;
}

// --- FETCH CATEGORIES ---
$query = "SELECT c.*, COUNT(p.id) AS product_count 
          FROM categories c 
          LEFT JOIN products p ON c.id = p.category_id 
          GROUP BY c.id 
          ORDER BY c.id DESC";
$categories = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories | VibeCraft Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Category Management</h3>
        <a href="dashboard.php" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i> <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Add Category Form -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-3">Add Category</h5>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g., Hoodies & Apparel" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Icon Class (FontAwesome)</label>
                        <input type="text" name="icon" class="form-control" placeholder="e.g., fas fa-shirt">
                        <small class="text-muted">Example: <code>fas fa-shirt</code>, <code>fas fa-mug-hot</code></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Brief category description..."></textarea>
                    </div>
                    <button type="submit" name="add_category" class="btn btn-primary w-100 fw-bold">
                        <i class="fas fa-plus me-1"></i> Save Category
                    </button>
                </form>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Products</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($categories && mysqli_num_rows($categories) > 0): ?>
                                <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                                    <tr>
                                        <td>
                                            <i class="<?php echo !empty($cat['icon']) ? htmlspecialchars($cat['icon']) : 'fas fa-folder'; ?> fs-5 text-primary"></i>
                                        </td>
                                        <td class="fw-bold"><?php echo htmlspecialchars($cat['name']); ?></td>
                                        <td><code><?php echo htmlspecialchars($cat['slug']); ?></code></td>
                                        <td>
                                            <span class="badge bg-secondary"><?php echo $cat['product_count']; ?></span>
                                        </td>
                                        <td>
                                            <a href="categories.php?delete=<?php echo $cat['id']; ?>" 
                                               onclick="return confirm('Deleting this category will affect associated products!');" 
                                               class="btn btn-sm btn-outline-danger" title="Delete Category">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No categories found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>