<?php
// LOCATION: app/views/dashboard/users/list.php
// UP 2 levels: users → dashboard → views
include dirname(__DIR__, 2) . '/layouts/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">

        <?php include dirname(__DIR__, 2) . '/partials/sidebar.php'; ?>

        <div class="col-md-9 col-lg-10">
            <?php showFlash(); ?>

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1">User Management</h3>
                    <p class="text-muted mb-0 small">
                        <?= count($users) ?> registered user<?= count($users) !== 1 ? 's' : '' ?>
                    </p>
                </div>
                <?php if (hasRole(['Super Admin'])): ?>
                    <a href="<?= BASE_URL ?>dashboard/users/create"
                       class="btn btn-primary">
                        <i class="bi bi-person-plus-fill me-2"></i>Create User
                    </a>
                <?php endif; ?>
            </div>

            <!-- Role Filter Pills (visual only, could extend to filtering) -->
            <div class="d-flex gap-2 flex-wrap mb-3">
                <?php
                // Count users per role for the summary badges
                $roleCounts = [];
                foreach ($users as $u) {
                    $roleCounts[$u['role_name']] = ($roleCounts[$u['role_name']] ?? 0) + 1;
                }
                $roleColors = [
                    'Super Admin' => 'danger',
                    'Admin'       => 'warning',
                    'Editor'      => 'info',
                    'Author'      => 'primary',
                    'User'        => 'secondary',
                ];
                foreach ($roleCounts as $roleName => $count):
                    $color = $roleColors[$roleName] ?? 'secondary';
                ?>
                    <span class="badge bg-<?= $color ?> px-3 py-2 rounded-pill">
                        <?= e($roleName) ?>: <?= $count ?>
                    </span>
                <?php endforeach; ?>
            </div>

            <!-- Users Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead>
                                <tr class="table-header-teal">
                                    <th class="ps-3">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="bi bi-people fs-1 d-block mb-2 opacity-25"></i>
                                            No users found.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($users as $i => $u): ?>
                                        <tr>
                                            <td class="ps-3 text-muted small"><?= $i + 1 ?></td>

                                            <!-- Name + Avatar -->
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="user-avatar-sm">
                                                        <?= strtoupper(substr($u['full_name'], 0, 1)) ?>
                                                    </div>
                                                    <span class="fw-semibold">
                                                        <?= e($u['full_name']) ?>
                                                        <?php if ((int)$u['id'] === (int)($_SESSION['user_id'] ?? 0)): ?>
                                                            <span class="badge bg-light text-muted ms-1"
                                                                  style="font-size:0.65rem;">You</span>
                                                        <?php endif; ?>
                                                    </span>
                                                </div>
                                            </td>

                                            <!-- Email -->
                                            <td class="text-muted small"><?= e($u['email']) ?></td>

                                            <!-- Role Badge -->
                                            <td>
                                                <?php
                                                $roleBadgeClass = match($u['role_name']) {
                                                    'Super Admin' => 'bg-danger',
                                                    'Admin'       => 'bg-warning text-dark',
                                                    'Editor'      => 'bg-info text-dark',
                                                    'Author'      => 'bg-primary',
                                                    default       => 'bg-secondary',
                                                };
                                                ?>
                                                <span class="badge <?= $roleBadgeClass ?> rounded-pill px-3">
                                                    <?= e($u['role_name']) ?>
                                                </span>
                                            </td>

                                            <!-- Joined Date -->
                                            <td class="small text-muted">
                                                <?= formatDate($u['created_at']) ?>
                                            </td>

                                            <!-- Actions -->
                                            <td>
                                                <?php
                                                $isSelf      = ((int)$u['id'] === (int)($_SESSION['user_id'] ?? 0));
                                                $isProtected = ($u['role_name'] === 'Super Admin' && !hasRole(['Super Admin']));
                                                ?>
                                                <div class="d-flex align-items-center gap-2 flex-wrap">

                                                    <!-- Inline Role Change Form -->
                                                    <?php if (!$isProtected && !$isSelf): ?>
                                                        <form method="POST"
                                                              action="<?= BASE_URL ?>dashboard/users/edit/<?= $u['id'] ?>"
                                                              class="d-flex gap-1 align-items-center">
                                                            <select name="role_id"
                                                                    class="form-select form-select-sm role-select"
                                                                    title="Change role">
                                                                <?php foreach ($roles as $role): ?>
                                                                    <option value="<?= $role['id'] ?>"
                                                                        <?= ($role['name'] === $u['role_name']) ? 'selected' : '' ?>>
                                                                        <?= e($role['name']) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <button type="submit"
                                                                    class="btn btn-xs btn-outline-success"
                                                                    title="Save role change">
                                                                <i class="bi bi-check-lg"></i>
                                                            </button>
                                                        </form>
                                                    <?php elseif ($isSelf): ?>
                                                        <span class="text-muted small fst-italic">
                                                            <i class="bi bi-lock me-1"></i>Your account
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted small fst-italic">
                                                            <i class="bi bi-shield me-1"></i>Protected
                                                        </span>
                                                    <?php endif; ?>

                                                    <!-- Delete Button (Super Admin only, not self) -->
                                                    <?php if (hasRole(['Super Admin']) && !$isSelf): ?>
                                                        <a href="<?= BASE_URL ?>dashboard/users/delete/<?= $u['id'] ?>"
                                                           class="btn btn-xs btn-outline-danger"
                                                           title="Delete user"
                                                           onclick="return confirm('Permanently delete <?= e($u['full_name']) ?>? This cannot be undone.')">
                                                            <i class="bi bi-trash"></i>
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