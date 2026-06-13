<?php
// LOCATION: app/views/dashboard/posts/list.php
// GOES UP 2 levels: posts → dashboard → views
include dirname(__DIR__, 2) . '/layouts/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">

        <?php include dirname(__DIR__, 2) . '/partials/sidebar.php'; ?>

        <div class="col-md-9 col-lg-10">
            <?php showFlash(); ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1">
                        <?= hasRole(['Author']) ? 'My Posts' : 'All Posts' ?>
                    </h3>
                    <p class="text-muted mb-0 small"><?= count($posts) ?> total posts</p>
                </div>
                <?php if (hasRole(['Super Admin', 'Admin', 'Author'])): ?>
                    <a href="<?= BASE_URL ?>dashboard/posts/create" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>New Post
                    </a>
                <?php endif; ?>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($posts)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            No posts found.
                                            <?php if (hasRole(['Author', 'Admin', 'Super Admin'])): ?>
                                                <a href="<?= BASE_URL ?>dashboard/posts/create">
                                                    Create one now.
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($posts as $i => $post): ?>
                                        <tr>
                                            <td class="text-muted small"><?= $i + 1 ?></td>
                                            <td>
                                                <span class="fw-medium"><?= e($post['title']) ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border">
                                                    <?= e($post['category_name']) ?>
                                                </span>
                                            </td>
                                            <td class="small text-muted">
                                                <?= e($post['author_name']) ?>
                                            </td>
                                            <td>
                                                <?php
                                                $statusClass = match($post['status']) {
                                                    'approved' => 'bg-success',
                                                    'pending'  => 'bg-warning text-dark',
                                                    'rejected' => 'bg-danger',
                                                    default    => 'bg-secondary',
                                                };
                                                ?>
                                                <span class="badge <?= $statusClass ?>">
                                                    <?= ucfirst($post['status']) ?>
                                                </span>
                                            </td>
                                            <td class="small text-muted">
                                                <?= formatDate($post['created_at']) ?>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1 flex-wrap">
                                                    <?php if (hasRole(['Super Admin', 'Admin', 'Editor'])
                                                              && $post['status'] === 'pending'): ?>
                                                        <a href="<?= BASE_URL ?>dashboard/posts/approve/<?= $post['id'] ?>"
                                                           class="btn btn-xs btn-success"
                                                           onclick="return confirm('Approve this post?')">
                                                            <i class="bi bi-check-lg"></i>
                                                        </a>
                                                        <a href="<?= BASE_URL ?>dashboard/posts/reject/<?= $post['id'] ?>"
                                                           class="btn btn-xs btn-warning"
                                                           onclick="return confirm('Reject this post?')">
                                                            <i class="bi bi-x-lg"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php
                                                    $canEdit = hasRole(['Super Admin', 'Admin', 'Editor']) ||
                                                               (hasRole(['Author']) &&
                                                                $post['author_id'] == ($_SESSION['user_id'] ?? 0));
                                                    ?>
                                                    <?php if ($canEdit): ?>
                                                        <a href="<?= BASE_URL ?>dashboard/posts/edit/<?= $post['id'] ?>"
                                                           class="btn btn-xs btn-outline-primary">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php
                                                    $canDelete = hasRole(['Super Admin', 'Admin']) ||
                                                                 (hasRole(['Author']) &&
                                                                  $post['author_id'] == ($_SESSION['user_id'] ?? 0) &&
                                                                  $post['status'] === 'draft');
                                                    ?>
                                                    <?php if ($canDelete): ?>
                                                        <a href="<?= BASE_URL ?>dashboard/posts/delete/<?= $post['id'] ?>"
                                                           class="btn btn-xs btn-outline-danger"
                                                           onclick="return confirm('Delete this post permanently?')">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php if ($post['status'] === 'approved'): ?>
                                                        <a href="<?= BASE_URL ?>posts/view/<?= e($post['slug']) ?>"
                                                           class="btn btn-xs btn-outline-secondary"
                                                           target="_blank">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
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
</div>

<?php include dirname(__DIR__, 2) . '/layouts/footer.php'; ?>