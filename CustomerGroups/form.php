<?php
require_once '../Database.php';
require_once 'CustomerGroups.php';

$db = (new Database())->connect();
$customerGroupModel = new CustomerGroups($db);
$isEdit = false;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    if ($customerGroupModel->load($_GET['id'])) {
        $isEdit = true;
    } else {
        header("Location: list.php?error=Customer Group not found");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isEdit ? 'Edit' : 'New'; ?> Customer Group</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light pb-5">
    <?php include '../header.php'; ?>
    <div class="row justify-content-center mx-3 mt-4">
        <div class="col-md-7 bg-white p-5 rounded-4 shadow-sm border">
            <div class="text-center mb-4">
                <i class="bi bi-people d-block text-primary display-4 mb-2"></i>
                <h1 class="h3 fw-bold text-dark"><?php echo $isEdit ? 'Edit Group' : 'New Group'; ?></h1>
                <p class="text-muted small">Define customer categories for targeted discounts and permissions.</p>
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
                <input type="hidden" name="customer_group_id" value="<?php echo $customerGroupModel->value('customer_group_id'); ?>">
            <?php endif; ?>

            <div class="col-12">
                <label for="name" class="form-label fw-semibold text-secondary small text-uppercase">Group Name</label>
                <input type="text" class="form-control" id="name" name="customer_group[group_name]" value="<?php echo $customerGroupModel->value('group_name' ?? ''); ?>" placeholder="e.g. VIP Customers" required>
            </div>

            <div class="col-12">
                <label for="description" class="form-label fw-semibold text-secondary small text-uppercase">Description</label>
                <textarea class="form-control" id="description" name="customer_group[description]" rows="4" placeholder="Briefly explain the purpose of this group..."><?php echo $customerGroupModel->value('description' ?? ''); ?></textarea>
            </div>

            <div class="col-12">
                <label for="status" class="form-label fw-semibold text-secondary small text-uppercase">Group Availability</label>
                <select class="form-select" id="status" name="customer_group[status]">
                    <option value="1" <?php echo ($customerGroupModel->value('status') == 1) ? 'selected' : ''; ?>>Active - Available for Assignment</option>
                    <option value="0" <?php echo ($customerGroupModel->value('status') == 0) ? 'selected' : ''; ?>>Inactive - Archived</option>
                </select>
            </div>

            <div class="col-12 pt-3">
                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3">
                    <a href="list.php" class="btn btn-link text-muted text-decoration-none small">
                        <i class="bi bi-chevron-left me-1"></i>Back to Groups
                    </a>
                    <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2 px-4 shadow-sm">
                        <i class="bi bi-save2"></i>
                        <span><?php echo $isEdit ? 'Update Group' : 'Create Group'; ?></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

    </body>
</html>
