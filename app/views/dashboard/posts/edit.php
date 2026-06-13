<?php
// LOCATION: app/views/dashboard/posts/edit.php
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
                <h3 class="fw-bold mb-0">Edit Post</h3>
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
                                <label class="form-label fw-medium">Post Title</label>
                                <input type="text" name="title" class="form-control form-control-lg"
                                       value="<?= e($_POST['title'] ?? $post['title']) ?>" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-medium">Content</label>
                                <textarea name="content" class="form-control" rows="12"
                                          required><?= e($_POST['content'] ?? $post['content']) ?></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium">Category</label>
                                <select name="category_id" class="form-select" required>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"
                                            <?= ($cat['id'] == $post['category_id']) ? 'selected' : '' ?>>
                                            <?= e($cat['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium">Featured Image</label>
                                <?php if (!empty($post['featured_image'])): ?>
                                    <div class="mb-2">
                                        <img src="<?= UPLOAD_URL . e($post['featured_image']) ?>"
                                             alt="Current" class="img-thumbnail" style="height:80px;">
                                        <span class="text-muted small ms-2">Current image</span>
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="featured_image" class="form-control"
                                       accept="image/jpeg,image/png,image/gif,image/webp">
                                <div class="form-text">Upload new image to replace current.</div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex gap-2 flex-wrap">
                                    <?php if (hasRole(['Super Admin', 'Admin'])): ?>
                                        <button type="submit" name="action" value="draft"
                                                class="btn btn-outline-secondary">
                                            <i class="bi bi-save me-1"></i>Save as Draft
                                        </button>
                                        <button type="submit" name="action" value="approved"
                                                class="btn btn-success">
                                            <i class="bi bi-globe me-1"></i>Save &amp; Publish
                                        </button>
                                        <button type="submit" name="action" value="pending"
                                                class="btn btn-outline-warning">
                                            Save as Pending
                                        </button>
                                    <?php elseif (hasRole(['Editor'])): ?>
                                        <button type="submit" name="action" value="save"
                                                class="btn btn-primary">
                                            <i class="bi bi-save me-1"></i>Save Changes
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
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/layouts/footer.php'; ?>