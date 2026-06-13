<?php
// LOCATION: app/views/dashboard/categories/list.php
// GOES UP 2 levels: categories → dashboard → views
// layouts = dirname(__DIR__, 2) . '/layouts/...'
// partials = dirname(__DIR__, 2) . '/partials/...'
include dirname(__DIR__, 2) . '/layouts/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">

        <?php include dirname(__DIR__, 2) . '/partials/sidebar.php'; ?>

        <div class="col-md-9 col-lg-10">
            <?php showFlash(); ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">Categories</h3>
                <a href="<?= BASE_URL ?>dashboard/categories/create" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>New Category
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($categories)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        No categories yet.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($categories as $i => $cat): ?>
                                    <tr>
                                        <td class="text-muted small"><?= $i + 1 ?></td>
                                        <td class="fw-medium"><?= e($cat['name']) ?></td>
                                        <td><code><?= e($cat['slug']) ?></code></td>
                                        <td class="small text-muted"><?= formatDate($cat['created_at']) ?></td>
                                        <td>
                                            <a href="<?= BASE_URL ?>dashboard/categories/edit/<?= $cat['id'] ?>"
                                               class="btn btn-xs btn-outline-primary me-1">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= BASE_URL ?>dashboard/categories/delete/<?= $cat['id'] ?>"
                                               class="btn btn-xs btn-outline-danger"
                                               onclick="return confirm('Delete this category? Posts in it may be affected.')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/layouts/footer.php'; ?>