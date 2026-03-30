<?php
require_once '../Database.php';
require_once 'Product.php';

$db = (new Database())->connect();
$productModel = new Product($db);
$isEdit = false;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    if ($productModel->load($_GET['id'])) {
        $isEdit = true;
    } else {
        header("Location: list.php?error=Product not found");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isEdit ? 'Edit' : 'New'; ?> Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light pb-5">
    <?php include '../header.php'; ?>
    <div class="row justify-content-center mx-3 mt-4">
        <div class="col-md-7 bg-white p-5 rounded-4 shadow-sm border">
            <div class="text-center mb-4">
                <i class="bi bi-box-seam d-block text-primary display-4 mb-2"></i>
                <h1 class="h3 fw-bold text-dark"><?php echo $isEdit ? 'Edit Product' : 'Create New Product'; ?></h1>
                <p class="text-muted small">Fill in the information below to <?php echo $isEdit ? 'update' : 'add'; ?> your product.</p>
            </div>
        
        <?php 
        $error = $_GET['error'] ?? null;
        if ($error): ?>
            <div class="alert alert-danger border-0 shadow-sm" role="alert">
                <i class="bi bi-exclamation-octagon-fill me-2"></i><?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo $isEdit ? 'edit.php' : 'add.php'; ?>" class="row g-3">
            <?php if ($isEdit): ?>
                <input type="hidden" name="product_id" value="<?php echo $productModel->value('product_id'); ?>">
            <?php endif; ?>

            <div class="col-12">
                <label for="name" class="form-label fw-semibold text-secondary small text-uppercase">Product Name</label>
                <input type="text" class="form-control" id="name" name="product[name]" value="<?php echo $productModel->value('name' ?? ''); ?>" placeholder="e.g. Wireless Mouse" required>
            </div>

            <div class="col-md-6">
                <label for="quantity" class="form-label fw-semibold text-secondary small text-uppercase">Quantity In Stock</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-boxes"></i></span>
                    <input type="number" class="form-control" id="quantity" name="product[quantity]" value="<?php echo $productModel->value('quantity') ?? 0; ?>" required>
                </div>
            </div>

            <div class="col-md-6">
                <label for="price" class="form-label fw-semibold text-secondary small text-uppercase">Unit Price</label>
                <div class="input-group">
                    <span class="input-group-text bg-light font-monospace fw-bold">$</span>
                    <input type="number" class="form-control" id="price" name="product[price]" step="0.01" value="<?php echo $productModel->value('price') ?? 0.00; ?>" required>
                </div>
            </div>

            <div class="col-12">
                <label for="description" class="form-label fw-semibold text-secondary small text-uppercase">Product Description</label>
                <textarea class="form-control" id="description" name="product[description]" rows="4" placeholder="Brief details about your product..."><?php echo $productModel->value('description' ?? ''); ?></textarea>
            </div>

            <div class="col-12">
                <label for="status" class="form-label fw-semibold text-secondary small text-uppercase">Publication Status</label>
                <select class="form-select" id="status" name="product[status]">
                    <option value="1" <?php echo ($productModel->value('status') == 1) ? 'selected' : ''; ?>>Enabled - Visible to Customers</option>
                    <option value="2" <?php echo ($productModel->value('status') == 2) ? 'selected' : ''; ?>>Disabled - Hidden from Catalog</option>
                </select>
            </div>

            <div class="col-12 pt-3">
                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3">
                    <a href="list.php" class="btn btn-link text-muted text-decoration-none small">
                        <i class="bi bi-arrow-left me-1"></i>Discard Changes
                    </a>
                    <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2 px-4 shadow-sm">
                        <i class="bi bi-check-circle"></i>
                        <span><?php echo $isEdit ? 'Update Product' : 'Create Product'; ?></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

    </body>
</html>
