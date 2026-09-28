<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    die('Database connection is not available.');
}

$message = "";
$error = "";

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = sanitize($conn, $_POST['name']);
    $category_id = (int)$_POST['category_id'];
    $price       = (float)$_POST['price'];
    $old_price   = !empty($_POST['old_price']) ? (float)$_POST['old_price'] : "NULL";
    $quantity    = (int)$_POST['quantity'];
    $description = sanitize($conn, $_POST['description']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Handle Image File Upload
    $image_name = "default-product.jpg";
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp  = $_FILES['image']['tmp_name'];
        $file_name = time() . '_' . basename($_FILES['image']['name']);
        $target    = "../assets/images/products/" . $file_name;

        if (move_uploaded_file($file_tmp, $target)) {
            $image_name = $file_name;
        } else {
            $error = "Failed to upload image.";
        }
    }

    if (empty($error)) {
        $sql = "INSERT INTO products (category_id, name, description, price, old_price, quantity, image, is_featured) 
                VALUES ($category_id, '$name', '$description', $price, $old_price, $quantity, '$image_name', $is_featured)";

        if (mysqli_query($conn, $sql)) {
            $message = "Product added successfully!";
        } else {
            $error = "Database error: " . mysqli_error($conn);
        }
    }
}

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product | VibeCraft Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white fw-bold">Add New Catalogue Item</div>
                <div class="card-body p-4">
                    
                    <?php if($message): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>
                    <?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Price ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Old Price ($) <small class="text-muted">(Optional)</small></label>
                                <input type="number" step="0.01" name="old_price" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Stock Quantity</label>
                                <input type="number" name="quantity" class="form-control" value="10" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_featured" class="form-check-input" id="feat">
                            <label class="form-check-label" for="feat">Mark as Featured Item on Home Page</label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
                            <button type="submit" class="btn btn-primary px-4">Save Product</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>