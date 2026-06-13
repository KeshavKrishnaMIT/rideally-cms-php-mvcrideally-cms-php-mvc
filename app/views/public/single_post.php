<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">

            <?php showFlash(); ?>

            <!-- Post Header -->
            <div class="mb-3">
                <a href="<?= BASE_URL ?>posts/category/<?= e($post['category_slug']) ?>"
                   class="badge category-badge text-decoration-none fs-6">
                    <?= e($post['category_name']) ?>
                </a>
            </div>
            <h1 class="display-5 fw-bold lh-sm mb-3"><?= e($post['title']) ?></h1>
            <div class="d-flex align-items-center gap-3 text-muted small mb-4">
                <span><i class="bi bi-person-fill me-1"></i><?= e($post['author_name']) ?></span>
                <span><i class="bi bi-calendar3 me-1"></i><?= formatDate($post['created_at']) ?></span>
            </div>

            <?php if ($post['featured_image']): ?>
                <img src="<?= UPLOAD_URL . e($post['featured_image']) ?>"
                     alt="<?= e($post['title']) ?>"
                     class="img-fluid rounded-3 mb-4 w-100 post-featured-img">
            <?php endif; ?>

            <!-- Post Content -->
            <div class="post-content">
                <?= nl2br(e($post['content'])) ?>
            </div>

            <hr class="my-5">

            <!-- COMMENTS SECTION -->
            <div id="comments">
                <h4 class="fw-bold mb-4">
                    <i class="bi bi-chat-dots me-2 text-primary"></i>
                    Comments (<?= count($comments) ?>)
                </h4>

                <?php if (empty($comments)): ?>
                    <p class="text-muted">No comments yet. Be the first to comment!</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment-card">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="comment-avatar">
                                    <?= strtoupper(substr($comment['full_name'], 0, 1)) ?>
                                </div>
                                <div>
                                    <span class="fw-semibold"><?= e($comment['full_name']) ?></span>
                                    <span class="text-muted small ms-2">
                                        <?= date('M j, Y \a\t g:i a', strtotime($comment['created_at'])) ?>
                                    </span>
                                </div>
                            </div>
                            <p class="mb-0 ps-5"><?= nl2br(e($comment['content'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Comment Form -->
                <div class="mt-4">
                    <?php if (isLoggedIn()): ?>
                        <h5 class="fw-semibold mb-3">Leave a Comment</h5>
                        <form method="POST" action="<?= BASE_URL ?>comments/store">
                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                            <input type="hidden" name="slug" value="<?= e($post['slug']) ?>">
                            <div class="mb-3">
                                <textarea name="content" class="form-control" rows="4"
                                          placeholder="Share your thoughts..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-2"></i>Post Comment
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-light border text-center py-4">
                            <i class="bi bi-chat-square-text fs-2 text-muted mb-2 d-block"></i>
                            <p class="mb-3">Please sign in or register to leave a comment.</p>
                            <a href="<?= BASE_URL ?>auth/login" class="btn btn-primary me-2">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Sign In
                            </a>
                            <a href="<?= BASE_URL ?>auth/register" class="btn btn-outline-primary">
                                <i class="bi bi-person-plus me-1"></i>Register
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4 mt-5 mt-lg-0">
            <div class="sticky-top" style="top:80px;">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-tag me-2 text-primary"></i>Categories</h6>
                        <?php foreach ($categories as $cat): ?>
                            <a href="<?= BASE_URL ?>posts/category/<?= e($cat['slug']) ?>"
                               class="d-block text-decoration-none mb-2 text-muted category-link">
                                <i class="bi bi-chevron-right me-1 small"></i><?= e($cat['name']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-search me-2 text-primary"></i>Search</h6>
                        <form action="<?= BASE_URL ?>search" method="GET">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Search...">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>