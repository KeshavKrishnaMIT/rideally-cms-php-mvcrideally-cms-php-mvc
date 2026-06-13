<?php
// LOCATION: app/views/dashboard/categories/form.php
// GOES UP 2 levels: categories → dashboard → views
include dirname(__DIR__, 2) . '/layouts/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">

        <?php include dirname(__DIR__, 2) . '/partials/sidebar.php'; ?>

        <div class="col-md-9 col-lg-10">
            <?php showFlash(); ?>

            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="<?= BASE_URL ?>dashboard/categories" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Back
                </a>
                <h3 class="fw-bold mb-0">
                    <?= ($editing ?? false) ? 'Edit Category' : 'New Category' ?>
                </h3>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        <?php foreach ($errors as $err): ?>
                            <li><?= e($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm" style="max-width:500px;">
                <div class="card-body p-4">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label fw-medium">Category Name</label>
                            <input type="text" name="name" class="form-control"
                                   placeholder="e.g. Technology"
                                   value="<?= e($old['name'] ?? '') ?>" required>
                            <div class="form-text">The slug will be auto-generated from the name.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>
                            <?= ($editing ?? false) ? 'Update Category' : 'Create Category' ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/layouts/footer.php'; ?>