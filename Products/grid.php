
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Grid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light pb-5">
    <?php include '../header.php'; ?>
    <div class="container bg-white p-5 rounded-4 shadow-sm border">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h1 class="h3 fw-bold text-dark m-0">Products</h1>
                <p class="text-muted small">Manage your inventory, pricing, and product details.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="form.php" class="btn btn-primary d-inline-flex align-items-center gap-2 px-4 shadow-sm">
                    <i class="bi bi-plus-circle"></i>
                    <span>New Product</span>
                </a>
            </div>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?php echo $_GET['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?php echo $_GET['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="delete.php" id="gridForm">
            <div class="mb-3">
                <button type="submit" name="action" value="delete" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1 px-3">
                    <i class="bi bi-trash"></i>
                    <span>Delete Selected</span>
                </button>
            </div>

            <div class="table-responsive border rounded-3 overflow-hidden">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary small text-uppercase">
                        <tr>
                            <th width="40"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                            <th>ID</th>
                            <th>Product Info</th>
                            <th>Inventory</th>
                            <th>Pricing</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Dates</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr><td colspan="8" class="text-center py-5 text-muted">No products found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($products as $p): ?>
                            <tr>
                                <td><input type="checkbox" name="selected_ids[]" value="<?php echo $p['product_id']; ?>" class="form-check-input rowCheckbox"></td>
                                <td class="fw-bold text-secondary">#<?php echo $p['product_id']; ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?php echo $p['name']; ?></div>
                                    <div class="small text-muted text-truncate" style="max-width: 200px;"><?php echo $p['description'] ?? ''; ?></div>
                                </td>
                                <td>
                                    <span class="badge <?php echo ($p['quantity'] > 10) ? 'bg-info-subtle text-info' : 'bg-warning-subtle text-warning'; ?> border rounded-pill px-3">
                                        <?php echo $p['quantity']; ?> Unit(s)
                                    </span>
                                </td>
                                <td class="fw-bold text-dark">$<?php echo number_format($p['price'], 2); ?></td>
                                <td class="text-center">
                                    <?php if ($p['status'] == 1): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Enabled</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">Disabled</span>
                                    <?php endif; ?>
                                </td>
                                <td class="small text-muted text-center" style="font-size: 0.75rem;">
                                    <div><i class="bi bi-calendar-event me-1"></i><?php echo $p['created_date']; ?></div>
                                    <?php if ($p['updated_date']): ?>
                                        <div class="mt-1"><i class="bi bi-pencil-square me-1"></i><?php echo $p['updated_date']; ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                        <a href="form.php?id=<?php echo $p['product_id']; ?>" class="btn btn-sm btn-outline-primary shadow-sm" title="Edit">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            var checkboxes = document.getElementsByClassName('rowCheckbox');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
        });
    </script>
</body>
</html>
