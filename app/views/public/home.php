<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<!-- ============================================================
     HERO SECTION
     ============================================================ -->
<section class="cms-hero">
    <div class="container text-center">
        <span class="badge bg-warning text-dark mb-3 px-3 py-2">Welcome to RideAlly CMS</span>
        <h1 class="hero-title">Discover, Learn &amp; Share</h1>
        <p class="hero-subtitle">A modern platform for thoughtful content. Explore articles, insights, and stories crafted by our community.</p>
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="<?= BASE_URL ?>posts" class="btn btn-primary btn-lg px-4">
                <i class="bi bi-grid me-2"></i>Browse Posts
            </a>
            <?php if (!isLoggedIn()): ?>
                <a href="<?= BASE_URL ?>auth/register" class="btn btn-outline-light btn-lg px-4">
                    <i class="bi bi-person-plus me-2"></i>Join Us
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ============================================================
     CATEGORY FILTER BAR
     ============================================================ -->
<section class="py-3 bg-light border-bottom">
    <div class="container">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="text-muted small fw-medium me-2"><i class="bi bi-tag me-1"></i>Topics:</span>
            <a href="<?= BASE_URL ?>posts" class="btn btn-sm btn-outline-secondary">All</a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?= BASE_URL ?>posts/category/<?= e($cat['slug']) ?>" class="btn btn-sm btn-outline-primary">
                    <?= e($cat['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================================================
     RECENT POSTS GRID
     ============================================================ -->
<section class="py-5">
    <div class="container">

        <?php showFlash(); ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Latest Articles</h2>
                <p class="text-muted mb-0 small">Fresh content from our contributors</p>
            </div>
            <a href="<?= BASE_URL ?>posts" class="btn btn-outline-primary btn-sm">View All</a>
        </div>

        <?php if (empty($recentPosts)): ?>
            <div class="text-center py-5">
                <i class="bi bi-journal-x fs-1 text-muted"></i>
                <p class="text-muted mt-3">No posts yet. Check back soon!</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($recentPosts as $post): ?>
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
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge category-badge">
                                        <?= e($post['category_name']) ?>
                                    </span>
                                </div>
                                <h5 class="post-card-title">
                                    <a href="<?= BASE_URL ?>posts/view/<?= e($post['slug']) ?>">
                                        <?= e($post['title']) ?>
                                    </a>
                                </h5>
                                <p class="post-card-excerpt"><?= truncate($post['content'], 110) ?></p>
                                <div class="post-card-meta">
                                    <span><i class="bi bi-person me-1"></i><?= e($post['author_name']) ?></span>
                                    <span><i class="bi bi-calendar3 me-1"></i><?= formatDate($post['created_at']) ?></span>
                                </div>
                                <a href="<?= BASE_URL ?>posts/view/<?= e($post['slug']) ?>"
                                   class="btn btn-sm btn-primary mt-3 w-100">
                                    Read More <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>