<?php
// LOCATION: app/views/auth/login.php
include dirname(__DIR__) . '/layouts/header.php';
?>

<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card">
                    <div class="auth-card-header">
                        <div class="auth-logo-wrap mb-3">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <h3 class="mb-1">Welcome Back</h3>
                        <p class="auth-sub mb-0">Sign in to RideAlly CMS</p>
                    </div>
                    <div class="auth-card-body">

                        <?php showFlash(); ?>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger rounded-3">
                                <?php foreach ($errors as $err): ?>
                                    <p class="mb-0"><i class="bi bi-exclamation-circle me-2"></i><?= e($err) ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">

                            <!-- Role -->
                            <div class="mb-3">
                                <label class="form-label auth-label">Your Role</label>
                                <div class="input-group auth-input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-shield-check"></i>
                                    </span>
                                    <select name="role_id" class="form-select" required>
                                        <option value="">— Select Your Role —</option>
                                        <?php foreach ($roles as $role): ?>
                                            <option value="<?= $role['id'] ?>"
                                                <?= (($oldData['role_id'] ?? '') == $role['id']) ? 'selected' : '' ?>>
                                                <?= e($role['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
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

                            <!-- Password -->
                            <div class="mb-4">
                                <label class="form-label auth-label">Password</label>
                                <div class="input-group auth-input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control"
                                           placeholder="Your password"
                                           required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-auth w-100 btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                            </button>
                        </form>

                        <div class="auth-divider">
                            <span>New to RideAlly CMS?</span>
                        </div>
                        <a href="<?= BASE_URL ?>auth/register" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-person-plus me-2"></i>Create an Account
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>