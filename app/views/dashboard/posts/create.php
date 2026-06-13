<?php
// LOCATION: app/views/dashboard/posts/create.php
// GOES UP 2 levels: posts → dashboard → views
include dirname(__DIR__, 2) . '/layouts/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">

        <?php include dirname(__DIR__, 2) . '/partials/sidebar.php'; ?>

        <div class="col-md-9 col-lg-10">
            <?php showFlash(); ?>

            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="<?= BASE_URL ?>dashboard/posts" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Back
                </a>
                <h3 class="fw-bold mb-0">Create New Post</h3>
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

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label fw-medium">
                                    Post Title <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="title" class="form-control form-control-lg"
                                       placeholder="Enter a compelling title..."
                                       value="<?= e($_POST['title'] ?? '') ?>" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-medium">
                                    Content <span class="text-danger">*</span>
                                </label>
                                <textarea name="content" class="form-control" rows="12"
                                          placeholder="Write your post content here..."
                                          required><?= e($_POST['content'] ?? '') ?></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium">
                                    Category <span class="text-danger">*</span>
                                </label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">— Select Category —</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"
                                            <?= (($_POST['category_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                                            <?= e($cat['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium">Featured Image</label>
                                <input type="file" name="featured_image" class="form-control"
                                       accept="image/jpeg,image/png,image/gif,image/webp">
                                <div class="form-text">JPG, PNG, GIF, WebP — max 2MB</div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex gap-2 flex-wrap">
                                    <?php if (hasRole(['Super Admin', 'Admin'])): ?>
                                        <button type="submit" name="action" value="draft"
                                                class="btn btn-outline-secondary">
                                            <i class="bi bi-save me-1"></i>Save as Draft
                                        </button>
                                        <button type="submit" name="action" value="publish"
                                                class="btn btn-success">
                                            <i class="bi bi-globe me-1"></i>Publish Now
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" name="action" value="draft"
                                                class="btn btn-outline-secondary">
                                            <i class="bi bi-save me-1"></i>Save Draft
                                        </button>
                                        <button type="submit" name="action" value="submit"
                                                class="btn btn-primary">
                                            <i class="bi bi-send me-1"></i>Submit for Review
                                        </button>
                                    <?php endif; ?>
                                </div>
                                <?php if (hasRole(['Author'])): ?>
                                    <p class="text-muted small mt-2">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Submitted posts are reviewed before going live.
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/layouts/footer.php'; ?>