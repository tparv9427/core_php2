<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Media Grid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light pb-5">
    <?php include '../header.php'; ?>
    <div class="container bg-white p-5 rounded-4 shadow-sm border">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h1 class="h3 fw-bold text-dark m-0">Product Media</h1>
                <p class="text-muted small">Manage images and videos associated with your products.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="form.php" class="btn btn-primary d-inline-flex align-items-center gap-2 px-4 shadow-sm">
                    <i class="bi bi-image"></i>
                    <span>New Media</span>
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
                            <th>Media Info</th>
                            <th>Sort Order</th>
                            <th class="text-center">Dates</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($product_medias)): ?>
                            <tr><td colspan="6" class="text-center py-5 text-muted">No product media found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($product_medias as $pm): ?>
                            <tr>
                                <td><input type="checkbox" name="selected_ids[]" value="<?php echo $pm['product_media_id']; ?>" class="form-check-input rowCheckbox"></td>
                                <td class="fw-bold text-secondary">#<?php echo $pm['product_media_id']; ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?php echo $pm['product_name'] ?? 'Unassigned'; ?></div>
                                    <div class="small text-muted"><i class="bi bi-link-45deg me-1"></i><?php echo $pm['file_path']; ?></div>
                                    <div class="small text-muted fst-italic">Alt: <?php echo $pm['alt_text'] ?? '-'; ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-3 rounded-pill"><?php echo number_format($pm['sort_order'], 2); ?></span>
                                </td>
                                <td class="small text-muted text-center" style="font-size: 0.75rem;">
                                    <div><i class="bi bi-calendar-event me-1"></i><?php echo $pm['created_date']; ?></div>
                                    <?php if ($pm['updated_date']): ?>
                                        <div class="mt-1"><i class="bi bi-pencil-square me-1"></i><?php echo $pm['updated_date']; ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                        <a href="form.php?id=<?php echo $pm['product_media_id']; ?>" class="btn btn-sm btn-outline-primary shadow-sm" title="Edit">
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
