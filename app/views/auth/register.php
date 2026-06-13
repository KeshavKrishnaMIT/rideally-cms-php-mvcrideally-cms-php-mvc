<?php
// LOCATION: app/views/auth/register.php
include dirname(__DIR__) . '/layouts/header.php';
?>

<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="auth-card">
                    <div class="auth-card-header">
                        <div class="auth-logo-wrap mb-3">
                            <i class="bi bi-journal-richtext"></i>
                        </div>
                        <h3 class="mb-1">Create Your Account</h3>
                        <p class="auth-sub mb-0">Join the RideAlly CMS community</p>
                    </div>
                    <div class="auth-card-body">

                        <?php showFlash(); ?>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger rounded-3">
                                <ul class="mb-0 ps-3">
                                    <?php foreach ($errors as $err): ?>
                                        <li><?= e($err) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label class="form-label auth-label">Full Name</label>
                                <div class="input-group auth-input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" name="full_name" class="form-control"
                                           placeholder="Your full name"
                                           value="<?= e($oldData['full_name'] ?? '') ?>"
                                           required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label auth-label">Email Address</label>
                                <div class="input-group auth-input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control"
                                           placeholder="your@email.com"
                                           value="<?= e($oldData['email'] ?? '') ?>"
                                           required>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="mb-3">
                                <label class="form-label auth-label">Select Your Role</label>
                                <div class="input-group auth-input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-shield-check"></i>
                                    </span>
                                    <select name="role_id" class="form-select" required>
                                        <option value="">— Choose a Role —</option>
                                        <?php foreach ($roles as $role): ?>
                                            <option value="<?= $role['id'] ?>"
                                                <?= (($oldData['role_id'] ?? '') == $role['id']) ? 'selected' : '' ?>>
                                                <?= e($role['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Choose the role that matches your intended access level.
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label auth-label">Password</label>
                                <div class="input-group auth-input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control"
                                           placeholder="At least 6 characters"
                                           required>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label class="form-label auth-label">Confirm Password</label>
                                <div class="input-group auth-input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock-check"></i>
                                    </span>
                                    <input type="password" name="confirm_password" class="form-control"
                                           placeholder="Repeat your password"
                                           required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-auth w-100 btn-lg">
                                <i class="bi bi-person-check me-2"></i>Create Account
                            </button>
                        </form>

                        <div class="auth-divider">
                            <span>Already have an account?</span>
                        </div>
                        <a href="<?= BASE_URL ?>auth/login" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In Instead
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>