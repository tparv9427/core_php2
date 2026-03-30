<?php 
require_once '../Database.php';
require_once 'Category.php';

$db = (new Database())->connect();
$categoryModel =  new Category($db);
$isEdit = false;

if(isset($_GET['id']) && !empty($_GET['id'])) {
    if($categoryModel->load($_GET['id'])){
        $isEdit = true;
    }else{
        header('Location: list.php?error=Category not found');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isEdit ? 'Edit' : 'New'; ?> Category</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light pb-5">
    <?php include '../header.php'; ?>
    <div class="row justify-content-center mx-3 mt-4">
        <div class="col-md-7 bg-white p-5 rounded-4 shadow-sm border">
            <div class="text-center mb-4">
                <i class="bi bi-tags d-block text-primary display-4 mb-2"></i>
                <h1 class="h3 fw-bold text-dark"><?php echo $isEdit ? 'Edit Category' : 'Create New Category'; ?></h1>
                <p class="text-muted small">Group your products effectively to help customers find what they need.</p>
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
                <input type="hidden" name="category_id" value="<?php echo $categoryModel->value('category_id'); ?>">
            <?php endif; ?>

            <div class="col-12">
                <label for="name" class="form-label fw-semibold text-secondary small text-uppercase">Category Name</label>
                <input type="text" class="form-control" id="name" name="category[name]" value="<?php echo $categoryModel->value('name' ?? ''); ?>" placeholder="e.g. Electronics" required>
            </div>

            <div class="col-12">
                <label for="description" class="form-label fw-semibold text-secondary small text-uppercase">Description</label>
                <textarea class="form-control" id="description" name="category[description]" rows="4" placeholder="Describe this category..."><?php echo $categoryModel->value('description' ?? ''); ?></textarea>
            </div>

            <div class="col-12">
                <label for="status" class="form-label fw-semibold text-secondary small text-uppercase">Initial Status</label>
                <select class="form-select" id="status" name="category[status]">
                    <option value="1" <?php echo ($categoryModel->value('status') == 1 || $categoryModel->value('status') === null) ? 'selected' : ''; ?>>Active - Visible on Storefront</option>
                    <option value="0" <?php echo ($categoryModel->value('status') !== null && $categoryModel->value('status') == 0) ? 'selected' : ''; ?>>Inactive - Hidden from Menu</option>
                </select>
            </div>

            <div class="col-12 pt-3">
                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3">
                    <a href="list.php" class="btn btn-link text-muted text-decoration-none small">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2 px-4 shadow-sm">
                        <i class="bi bi-save"></i>
                        <span><?php echo $isEdit ? 'Update Category' : 'Save Category'; ?></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

    </body>
</html>