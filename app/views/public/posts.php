<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<section class="py-4 bg-light border-bottom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="fw-bold mb-1">
                    <?php if (isset($category)): ?>
                        <i class="bi bi-tag me-2 text-primary"></i><?= e($category['name']) ?>
                    <?php else: ?>
                        <i class="bi bi-grid me-2 text-primary"></i>All Posts
                    <?php endif; ?>
                </h2>
                <p class="text-muted small mb-0">Browse the latest published articles</p>
            </div>
            <div class="col-auto">
                <!-- Search bar -->
                <form action="<?= BASE_URL ?>search" method="GET" class="d-flex gap-2">
                    <input type="text" name="q" class="form-control form-control-sm"
                           placeholder="Search posts..." style="width:200px;">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>
        <!-- Category filters -->
        <div class="d-flex gap-2 mt-3 flex-wrap">
            <a href="<?= BASE_URL ?>posts"
               class="btn btn-sm <?= !isset($category) ? 'btn-primary' : 'btn-outline-secondary' ?>">All</a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?= BASE_URL ?>posts/category/<?= e($cat['slug']) ?>"
                   class="btn btn-sm <?= (isset($category) && $category['id'] == $cat['id']) ? 'btn-primary' : 'btn-outline-primary' ?>">
                    <?= e($cat['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <?php if (empty($posts)): ?>
            <div class="text-center py-5">
                <i class="bi bi-journal-x fs-1 text-muted"></i>
                <p class="text-muted mt-3">No posts found in this category.</p>
                <a href="<?= BASE_URL ?>posts" class="btn btn-primary btn-sm">View All Posts</a>
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

            <!-- Pagination -->
            <?php if (isset($totalPages) && $totalPages > 1): ?>
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                            <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>