<?php
// LOCATION: app/views/dashboard/index.php
// GOES UP 1 level: dashboard → views
// layouts = dirname(__DIR__) . '/layouts/...'
// partials = dirname(__DIR__) . '/partials/...'
include dirname(__DIR__) . '/layouts/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">

        <?php include dirname(__DIR__) . '/partials/sidebar.php'; ?>

        <div class="col-md-9 col-lg-10">
            <?php showFlash(); ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1">Dashboard</h3>
                    <p class="text-muted mb-0">
                        Welcome back,
                        <strong><?= e($_SESSION['user_name'] ?? 'User') ?></strong>!
                    </p>
                </div>
                <span class="badge bg-primary fs-6 px-3 py-2">
                    <i class="bi bi-shield-check me-1"></i>
                    <?= e($_SESSION['user_role'] ?? 'User') ?>
                </span>
            </div>

            <?php if (hasRole(['Super Admin', 'Admin'])): ?>
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="stat-card stat-blue">
                            <div class="stat-icon"><i class="bi bi-file-text"></i></div>
                            <div class="stat-info">
                                <span class="stat-number"><?= $stats['total'] ?? 0 ?></span>
                                <span class="stat-label">Total Posts</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="stat-card stat-green">
                            <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
                            <div class="stat-info">
                                <span class="stat-number"><?= $stats['approved'] ?? 0 ?></span>
                                <span class="stat-label">Published</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="stat-card stat-orange">
                            <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
                            <div class="stat-info">
                                <span class="stat-number"><?= $stats['pending'] ?? 0 ?></span>
                                <span class="stat-label">Pending</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="stat-card stat-purple">
                            <div class="stat-icon"><i class="bi bi-people"></i></div>
                            <div class="stat-info">
                                <span class="stat-number"><?= $stats['users'] ?? 0 ?></span>
                                <span class="stat-label">Total Users</span>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="fw-semibold mb-3">Quick Actions</h5>
                <div class="row g-3">
                    <div class="col-sm-6 col-lg-3">
                        <a href="<?= BASE_URL ?>dashboard/posts/create" class="quick-action-card text-decoration-none">
                            <i class="bi bi-plus-circle-fill text-primary fs-3"></i>
                            <span class="mt-2 fw-medium">New Post</span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a href="<?= BASE_URL ?>dashboard/posts" class="quick-action-card text-decoration-none">
                            <i class="bi bi-list-ul text-success fs-3"></i>
                            <span class="mt-2 fw-medium">All Posts</span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a href="<?= BASE_URL ?>dashboard/categories" class="quick-action-card text-decoration-none">
                            <i class="bi bi-tags text-warning fs-3"></i>
                            <span class="mt-2 fw-medium">Categories</span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a href="<?= BASE_URL ?>dashboard/users" class="quick-action-card text-decoration-none">
                            <i class="bi bi-people text-info fs-3"></i>
                            <span class="mt-2 fw-medium">Users</span>
                        </a>
                    </div>
                </div>

            <?php elseif (hasRole(['Editor'])): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    You are logged in as an <strong>Editor</strong>. Review and approve pending posts.
                </div>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <a href="<?= BASE_URL ?>dashboard/posts" class="quick-action-card text-decoration-none">
                            <i class="bi bi-pencil-square text-warning fs-3"></i>
                            <span class="mt-2 fw-medium">Review Posts</span>
                        </a>
                    </div>
                </div>

            <?php elseif (hasRole(['Author'])): ?>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <a href="<?= BASE_URL ?>dashboard/posts/create" class="quick-action-card text-decoration-none">
                            <i class="bi bi-plus-circle-fill text-primary fs-3"></i>
                            <span class="mt-2 fw-medium">Write New Post</span>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="<?= BASE_URL ?>dashboard/posts" class="quick-action-card text-decoration-none">
                            <i class="bi bi-journal-text text-success fs-3"></i>
                            <span class="mt-2 fw-medium">My Posts</span>
                        </a>
                    </div>
                </div>

            <?php else: ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    You are logged in as a <strong><?= e($_SESSION['user_role'] ?? 'User') ?></strong>.
                    Browse our posts and leave comments!
                    <a href="<?= BASE_URL ?>posts" class="btn btn-primary btn-sm ms-3">Browse Posts</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>