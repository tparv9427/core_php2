<?php 
require_once '../Database.php';
require_once 'Customers.php';

$db = (new Database())->connect();
$customerModel = new Customers($db);
$isEdit = false;

// Fetch Customer Groups for the dropdown
$groupQuery = "SELECT customer_group_id, group_name FROM customer_group ORDER BY group_name ASC";
$customerGroups = $db->fetchPair($groupQuery) ?: [];

if(isset($_GET['id']) && !empty($_GET['id'])) {
    if($customerModel->load($_GET['id'])){
        $isEdit = true;
    } else {
        header('Location: list.php?error=Customer not found');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isEdit ? 'Edit' : 'New'; ?> Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light pb-5">
    <?php include '../header.php'; ?>
    <div class="row justify-content-center mx-3 mt-4">
        <div class="col-md-7 bg-white p-5 rounded-4 shadow-sm border">
            <div class="text-center mb-4">
                <i class="bi bi-person-badge d-block text-primary display-4 mb-2"></i>
                <h1 class="h3 fw-bold text-dark"><?php echo $isEdit ? 'Edit Customer' : 'Create New Customer'; ?></h1>
                <p class="text-muted small">Manage profile information and account status for your customers.</p>
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
                <input type="hidden" name="customer_id" value="<?php echo $customerModel->value('customer_id'); ?>">
            <?php endif; ?>

            <div class="col-md-6">
                <label for="first_name" class="form-label fw-semibold text-secondary small text-uppercase">First Name</label>
                <input type="text" class="form-control" id="first_name" name="customer[first_name]" value="<?php echo $customerModel->value('first_name' ?? ''); ?>" placeholder="John" required>
            </div>

            <div class="col-md-6">
                <label for="last_name" class="form-label fw-semibold text-secondary small text-uppercase">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="customer[last_name]" value="<?php echo $customerModel->value('last_name' ?? ''); ?>" placeholder="Doe" required>
            </div>

            <div class="col-12">
                <label for="email" class="form-label fw-semibold text-secondary small text-uppercase">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="customer[email]" value="<?php echo $customerModel->value('email' ?? ''); ?>" placeholder="john.doe@example.com" required>
                </div>
            </div>

            <div class="col-12">
                <label for="phone" class="form-label fw-semibold text-secondary small text-uppercase">Phone Number</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                    <input type="text" class="form-control" id="phone" name="customer[phone]" value="<?php echo $customerModel->value('phone' ?? ''); ?>" placeholder="+1 (555) 000-0000">
                </div>
            </div>

            <div class="col-md-6">
                <label for="customer_group_id" class="form-label fw-semibold text-secondary small text-uppercase">Group Assignment</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-people"></i></span>
                    <select class="form-select" id="customer_group_id" name="customer[customer_group_id]">
                        <option value="">-- Select Group --</option>
                        <?php foreach ($customerGroups as $id => $name): ?>
                            <option value="<?php echo $id; ?>" <?php echo ($customerModel->value('customer_group_id') == $id) ? 'selected' : ''; ?>>
                                <?php echo $name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label fw-semibold text-secondary small text-uppercase">Account Status</label>
                <select class="form-select" id="status" name="customer[status]">
                    <option value="1" <?php echo ($customerModel->value('status') == 1) ? 'selected' : ''; ?>>Active - Allowed Access</option>
                    <option value="2" <?php echo ($customerModel->value('status') == 2) ? 'selected' : ''; ?>>Inactive - Account Locked</option>
                </select>
            </div>

            <div class="col-12 pt-3">
                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3">
                    <a href="list.php" class="btn btn-link text-muted text-decoration-none small">
                        <i class="bi bi-arrow-left me-1"></i>Back to List
                    </a>
                    <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2 px-4 shadow-sm">
                        <i class="bi bi-person-check"></i>
                        <span><?php echo $isEdit ? 'Update Profile' : 'Create Account'; ?></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

    </body>
</html>
