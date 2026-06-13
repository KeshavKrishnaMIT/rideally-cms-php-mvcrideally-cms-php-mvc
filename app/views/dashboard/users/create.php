<?php
// LOCATION: app/views/dashboard/users/create.php
// UP 2 levels: users → dashboard → views
include dirname(__DIR__, 2) . '/layouts/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">

        <?php include dirname(__DIR__, 2) . '/partials/sidebar.php'; ?>

        <div class="col-md-9 col-lg-10">
            <?php showFlash(); ?>

            <!-- Page Header -->
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="<?= BASE_URL ?>dashboard/users"
                   class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Back to Users
                </a>
                <div>
                    <h3 class="fw-bold mb-0">Create New User</h3>
                    <p class="text-muted small mb-0">
                        Super Admin — manually create any user with any role
                    </p>
                </div>
            </div>

            <!-- Error Display -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger rounded-3 mb-4">
                    <div class="d-flex gap-2 align-items-start">
                        <i class="bi bi-exclamation-triangle-fill mt-1 flex-shrink-0"></i>
                        <ul class="mb-0 ps-2">
                            <?php foreach ($errors as $err): ?>
                                <li><?= e($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Form Card -->
            <div class="row">
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header-teal">
                            <i class="bi bi-person-plus-fill me-2"></i>User Details
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="" autocomplete="off">

                                <!-- Full Name -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Full Name <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-teal-light">
                                            <i class="bi bi-person text-teal"></i>
                                        </span>
                                        <input type="text"
                                               name="full_name"
                                               class="form-control"
                                               placeholder="e.g. Rahul Sharma"
                                               value="<?= e($old['full_name'] ?? '') ?>"
                                               required>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Email Address <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-teal-light">
                                            <i class="bi bi-envelope text-teal"></i>
                                        </span>
                                        <input type="email"
                                               name="email"
                                               class="form-control"
                                               placeholder="user@example.com"
                                               value="<?= e($old['email'] ?? '') ?>"
                                               required>
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Assign Role <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-teal-light">
                                            <i class="bi bi-shield-check text-teal"></i>
                                        </span>
                                        <select name="role_id" class="form-select" required>
                                            <option value="">— Select a Role —</option>
                                            <?php foreach ($roles as $role): ?>
                                                <option value="<?= $role['id'] ?>"
                                                    <?= (($old['role_id'] ?? '') == $role['id']) ? 'selected' : '' ?>>
                                                    <?= e($role['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        As Super Admin, you can assign any role including Super Admin.
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Password -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-teal-light">
                                            <i class="bi bi-lock text-teal"></i>
                                        </span>
                                        <input type="password"
                                               name="password"
                                               id="passwordField"
                                               class="form-control"
                                               placeholder="Minimum 6 characters"
                                               required>
                                        <button class="btn btn-outline-secondary"
                                                type="button"
                                                onclick="togglePassword('passwordField', this)"
                                                title="Show/hide password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Confirm Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-teal-light">
                                            <i class="bi bi-lock-check text-teal"></i>
                                        </span>
                                        <input type="password"
                                               name="confirm_password"
                                               id="confirmField"
                                               class="form-control"
                                               placeholder="Repeat password"
                                               required>
                                        <button class="btn btn-outline-secondary"
                                                type="button"
                                                onclick="togglePassword('confirmField', this)"
                                                title="Show/hide password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div id="passwordMatchMsg" class="form-text"></div>
                                </div>

                                <!-- Submit -->
                                <div class="d-flex gap-3">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bi bi-person-check-fill me-2"></i>Create User
                                    </button>
                                    <a href="<?= BASE_URL ?>dashboard/users"
                                       class="btn btn-outline-secondary px-4">
                                        Cancel
                                    </a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- Role Info Sidebar -->
                <div class="col-lg-5 mt-4 mt-lg-0">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header-teal">
                            <i class="bi bi-info-circle me-2"></i>Role Permissions Guide
                        </div>
                        <div class="card-body p-4">
                            <?php
                            $roleGuide = [
                                'Super Admin' => [
                                    'icon'  => 'bi-shield-fill-check',
                                    'color' => 'danger',
                                    'perms' => [
                                        'Full system access',
                                        'Manage all users & roles',
                                        'Create, edit, delete any post',
                                        'Manage categories',
                                        'View all statistics',
                                    ],
                                ],
                                'Admin' => [
                                    'icon'  => 'bi-shield-fill',
                                    'color' => 'warning',
                                    'perms' => [
                                        'Manage posts & categories',
                                        'Manage editors, authors, users',
                                        'Publish posts directly',
                                        'Cannot modify Super Admins',
                                    ],
                                ],
                                'Editor' => [
                                    'icon'  => 'bi-pencil-fill',
                                    'color' => 'info',
                                    'perms' => [
                                        'Review submitted posts',
                                        'Approve or reject posts',
                                        'Edit any post content',
                                        'Cannot manage users',
                                    ],
                                ],
                                'Author' => [
                                    'icon'  => 'bi-file-earmark-text-fill',
                                    'color' => 'primary',
                                    'perms' => [
                                        'Create and edit own posts',
                                        'Save drafts',
                                        'Submit posts for review',
                                        'Delete own drafts only',
                                    ],
                                ],
                                'User' => [
                                    'icon'  => 'bi-person-fill',
                                    'color' => 'secondary',
                                    'perms' => [
                                        'View all published posts',
                                        'Leave comments',
                                        'Manage own account',
                                        'No dashboard access',
                                    ],
                                ],
                            ];
                            foreach ($roleGuide as $roleName => $info):
                            ?>
                                <div class="role-guide-item mb-3">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <i class="bi <?= $info['icon'] ?> text-<?= $info['color'] ?>"></i>
                                        <span class="fw-semibold small"><?= $roleName ?></span>
                                    </div>
                                    <ul class="list-unstyled ms-3 mb-0">
                                        <?php foreach ($info['perms'] as $perm): ?>
                                            <li class="text-muted small mb-1">
                                                <i class="bi bi-check text-success me-1"></i><?= $perm ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php if ($roleName !== 'User'): ?>
                                    <hr class="my-2">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
function togglePassword(fieldId, btn) {
    const field = document.getElementById(fieldId);
    const icon  = btn.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        field.type = 'password';
        icon.className = 'bi bi-eye';
    }
}

// Live password match indicator
const pwd     = document.getElementById('passwordField');
const confirm = document.getElementById('confirmField');
const msg     = document.getElementById('passwordMatchMsg');

function checkMatch() {
    if (confirm.value === '') {
        msg.textContent = '';
        msg.className   = 'form-text';
        return;
    }
    if (pwd.value === confirm.value) {
        msg.textContent = '✓ Passwords match';
        msg.className   = 'form-text text-success fw-semibold';
    } else {
        msg.textContent = '✗ Passwords do not match';
        msg.className   = 'form-text text-danger fw-semibold';
    }
}

pwd.addEventListener('input',     checkMatch);
confirm.addEventListener('input', checkMatch);
</script>

<?php include dirname(__DIR__, 2) . '/layouts/footer.php'; ?>