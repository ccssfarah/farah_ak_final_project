<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

$message = "";
$error = "";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$id = (int)$_GET['id'];

// Fetch Existing Product Data
$product_query = "SELECT * FROM products WHERE id = $id";
$product_res = mysqli_query($conn, $product_query);

if (mysqli_num_rows($product_res) === 0) {
    header("Location: products.php");
    exit;
}

$product = mysqli_fetch_assoc($product_res);

// Handle Update Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = sanitize($conn, $_POST['name']);
    $category_id = (int)$_POST['category_id'];
    $price       = (float)$_POST['price'];
    $old_price   = !empty($_POST['old_price']) ? (float)$_POST['old_price'] : "NULL";
    $quantity    = (int)$_POST['quantity'];
    $description = sanitize($conn, $_POST['description']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $status      = sanitize($conn, $_POST['status']);

    $image_name = $product['image']; // Default to current image

    // Handle Image Replacement
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp  = $_FILES['image']['tmp_name'];
        $file_name = time() . '_' . basename($_FILES['image']['name']);
        $target    = "../assets/images/products/" . $file_name;

        if (move_uploaded_file($file_tmp, $target)) {
            $image_name = $file_name;
        } else {
            $error = "Failed to upload new image.";
        }
    }

    if (empty($error)) {
        $sql = "UPDATE products SET 
                category_id = $category_id, 
                name = '$name', 
                description = '$description', 
                price = $price, 
                old_price = $old_price, 
                quantity = $quantity, 
                image = '$image_name', 
                is_featured = $is_featured,
                status = '$status'
                WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            $message = "Product updated successfully!";
            // Refresh local product array
            $product_res = mysqli_query($conn, $product_query);
            $product = mysqli_fetch_assoc($product_res);
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
    <title>Edit Product | VibeCraft Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white fw-bold">Edit Product #<?php echo $product['id']; ?></div>
                <div class="card-body p-4">
                    
                    <?php if($message): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>
                    <?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select" required>
                                    <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                                        <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Price ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Old Price ($)</label>
                                <input type="number" step="0.01" name="old_price" class="form-control" value="<?php echo $product['old_price']; ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Stock</label>
                                <input type="number" name="quantity" class="form-control" value="<?php echo $product['quantity']; ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active" <?php echo ($product['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo ($product['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Image</label>
                            <div class="d-flex align-items-center gap-3">
                                <img src="../assets/images/products/<?php echo htmlspecialchars($product['image']); ?>" 
                                     onerror="this.src='https://via.placeholder.com/60';" width="60" height="60" class="rounded object-fit-cover border">
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <small class="text-muted">Leave empty to keep the existing image.</small>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_featured" class="form-check-input" id="feat" <?php echo ($product['is_featured'] == 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="feat">Mark as Featured Item</label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="products.php" class="btn btn-outline-secondary">Back to Products</a>
                            <button type="submit" class="btn btn-primary px-4">Update Product</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>