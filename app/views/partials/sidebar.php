<div class="col-md-3 col-lg-2">
    <div class="dashboard-sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-journal-richtext me-2"></i>CMS Panel
        </div>
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>dashboard"
               class="sidebar-link <?= (strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false && strpos($_SERVER['REQUEST_URI'], 'posts') === false && strpos($_SERVER['REQUEST_URI'], 'categories') === false && strpos($_SERVER['REQUEST_URI'], 'users') === false) ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <?php if (hasRole(['Super Admin', 'Admin', 'Editor', 'Author'])): ?>
                <div class="sidebar-section-label">Content</div>
                <a href="<?= BASE_URL ?>dashboard/posts"
                   class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'], 'dashboard/posts') !== false ? 'active' : '' ?>">
                    <i class="bi bi-file-text"></i>
                    <?= hasRole(['Author']) ? 'My Posts' : 'Posts' ?>
                </a>
                <?php if (hasRole(['Super Admin', 'Admin', 'Author'])): ?>
                    <a href="<?= BASE_URL ?>dashboard/posts/create" class="sidebar-link">
                        <i class="bi bi-plus-square"></i> New Post
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (hasRole(['Super Admin', 'Admin'])): ?>
                <div class="sidebar-section-label">Manage</div>
                <a href="<?= BASE_URL ?>dashboard/categories"
                   class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'], 'categories') !== false ? 'active' : '' ?>">
                    <i class="bi bi-tags"></i> Categories
                </a>
                <a href="<?= BASE_URL ?>dashboard/users"
                   class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'], 'users') !== false ? 'active' : '' ?>">
                    <i class="bi bi-people"></i> Users
                </a>
            <?php endif; ?>

            <div class="sidebar-section-label">Account</div>
            <a href="<?= BASE_URL ?>" class="sidebar-link">
                <i class="bi bi-globe"></i> View Site
            </a>
            <a href="<?= BASE_URL ?>auth/logout" class="sidebar-link text-danger-soft">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </nav>
    </div>
</div>