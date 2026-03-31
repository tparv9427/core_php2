<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light pb-5">
    <?php include '../header.php'; ?>
    <div class="container bg-white p-5 rounded-4 shadow-sm border">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h1 class="h3 fw-bold text-dark m-0">Customers</h1>
                <p class="text-muted small">Manage your customer database and group assignments.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="form.php" class="btn btn-primary d-inline-flex align-items-center gap-2 px-4 shadow-sm">
                    <i class="bi bi-person-plus"></i>
                    <span>New Customer</span>
                </a>
            </div>
        </div>

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
                            <th>Customer Name</th>
                            <th>Email Address</th>
                            <th>Group</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($customers)): ?>
                            <tr><td colspan="7" class="text-center py-5 text-muted">No customers found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($customers as $c): ?>
                            <tr>
                                <td><input type="checkbox" name="selected_ids[]" value="<?php echo $c['customer_id']; ?>" class="form-check-input rowCheckbox"></td>
                                <td class="fw-bold text-secondary">#<?php echo $c['customer_id']; ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?php echo $c['first_name'] . ' ' . $c['last_name']; ?></div>
                                </td>
                                <td>
                                    <div class="text-primary small"><i class="bi bi-envelope me-1"></i><?php echo $c['email']; ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border rounded-pill px-3">
                                        <i class="bi bi-people me-1"></i><?php echo $c['group_name'] ?? 'General'; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if ($c['status'] == 1): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                        <a href="form.php?id=<?php echo $c['customer_id']; ?>" class="btn btn-sm btn-outline-primary shadow-sm" title="Edit">
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
        document.getElementById('selectAll').addEventListener('change', function(){
            var checkboxes = document.getElementsByClassName('rowCheckbox');
            for(var i=0; i< checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
        });
    </script>
</body>
</html>
