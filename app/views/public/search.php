<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<section class="py-4 bg-light border-bottom">
    <div class="container">
        <h2 class="fw-bold mb-1">Search Results</h2>
        <?php if ($keyword !== ''): ?>
            <p class="text-muted mb-0">
                Showing results for: <strong>"<?= e($keyword) ?>"</strong>
                — <?= count($posts) ?> result(s) found
            </p>
        <?php endif; ?>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <form action="<?= BASE_URL ?>search" method="GET" class="d-flex gap-2">
                    <input type="text" name="q" class="form-control"
                           placeholder="Search posts..." value="<?= e($keyword) ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Search
                    </button>
                </form>
            </div>
        </div>

        <?php if ($keyword === ''): ?>
            <p class="text-center text-muted">Enter a keyword above to search.</p>
        <?php elseif (empty($posts)): ?>
            <div class="text-center py-4">
                <i class="bi bi-search fs-1 text-muted"></i>
                <p class="text-muted mt-3">No posts matched your search.</p>
                <a href="<?= BASE_URL ?>posts" class="btn btn-primary btn-sm">Browse All Posts</a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="post-card h-100">
                            <?php if ($post['featured_image']): ?>
                                <img src="<?= UPLOAD_URL . e($post['featured_image']) ?>"
                                     alt="<?= e($post['title']) ?>" class="post-card-img">
                            <?php else: ?>
                                <div class="post-card-img-placeholder">
                                    <i class="bi bi-image fs-1 text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <div class="post-card-body">
                                <span class="badge category-badge mb-2"><?= e($post['category_name']) ?></span>
                                <h5 class="post-card-title">
                                    <a href="<?= BASE_URL ?>posts/view/<?= e($post['slug']) ?>">
                                        <?= e($post['title']) ?>
                                    </a>
                                </h5>
                                <p class="post-card-excerpt"><?= truncate($post['content'], 100) ?></p>
                                <a href="<?= BASE_URL ?>posts/view/<?= e($post['slug']) ?>"
                                   class="btn btn-sm btn-primary mt-2 w-100">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>