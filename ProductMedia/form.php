<?php
require_once '../Database.php';
require_once 'ProductMedia.php';

$db = (new Database())->connect();
$productMediaModel = new ProductMedia($db);
$isEdit = false;

$products = $db->fetchAll("SELECT product_id, name FROM product ORDER BY name ASC") ?: [];

if (isset($_GET['id']) && !empty($_GET['id'])) {
    if ($productMediaModel->load($_GET['id'])) {
        $isEdit = true;
    } else {
        header("Location: list.php?error=Product Media not found");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isEdit ? 'Edit' : 'New'; ?> Product Media</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light pb-5">
    <?php include '../header.php'; ?>
    <div class="row justify-content-center mx-3 mt-4">
        <div class="col-md-7 bg-white p-5 rounded-4 shadow-sm border">
            <div class="text-center mb-4">
                <i class="bi bi-images d-block text-primary display-4 mb-2"></i>
                <h1 class="h3 fw-bold text-dark"><?php echo $isEdit ? 'Edit Media' : 'Add Media'; ?></h1>
                <p class="text-muted small">Upload or link images and videos to showcase your products.</p>
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
                <input type="hidden" name="product_media_id" value="<?php echo $productMediaModel->value('product_media_id'); ?>">
            <?php endif; ?>

            <div class="col-12">
                <label for="product_id" class="form-label fw-semibold text-secondary small text-uppercase">Associated Product</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-box"></i></span>
                    <select class="form-select" id="product_id" name="product_media[product_id]" required>
                        <option value="">-- Select Product --</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?php echo $product['product_id']; ?>" <?php echo ($productMediaModel->value('product_id') == $product['product_id']) ? 'selected' : ''; ?>>
                                <?php echo $product['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-12">
                <label for="file_path" class="form-label fw-semibold text-secondary small text-uppercase">Resource Path / URL</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-link-45deg"></i></span>
                    <input type="text" class="form-control" id="file_path" name="product_media[file_path]" value="<?php echo $productMediaModel->value('file_path' ?? ''); ?>" placeholder="/assets/images/product-1.jpg" required>
                </div>
            </div>

            <div class="col-md-8">
                <label for="alt_text" class="form-label fw-semibold text-secondary small text-uppercase">Alternative Text</label>
                <input type="text" class="form-control" id="alt_text" name="product_media[alt_text]" value="<?php echo $productMediaModel->value('alt_text' ?? ''); ?>" placeholder="Describe the image for SEO">
            </div>

            <div class="col-md-4">
                <label for="sort_order" class="form-label fw-semibold text-secondary small text-uppercase">Display Order</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-sort-numeric-down"></i></span>
                    <input type="number" step="0.01" class="form-control" id="sort_order" name="product_media[sort_order]" value="<?php echo $productMediaModel->value('sort_order') ?? '0.00'; ?>">
                </div>
            </div>

            <div class="col-12 pt-3">
                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3">
                    <a href="list.php" class="btn btn-link text-muted text-decoration-none small">
                        <i class="bi bi-arrow-left me-1"></i>Discard
                    </a>
                    <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2 px-4 shadow-sm">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span><?php echo $isEdit ? 'Update Media' : 'Upload Media'; ?></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

    </body>
</html>
