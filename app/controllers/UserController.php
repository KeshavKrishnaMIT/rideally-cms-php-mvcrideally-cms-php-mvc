<?php
// ============================================================
// CONTROLLER: UserController
// Handles user management in the dashboard.
// ============================================================

class UserController {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // ----------------------------------------------------------
    // LIST ALL USERS
    // ----------------------------------------------------------
    public function index() {
        requireRole(['Super Admin', 'Admin']);
        $users = $this->userModel->getAll();
        $roles = $this->userModel->getRoles();
        include dirname(__DIR__) . '/views/dashboard/users/list.php';
    }

    // ----------------------------------------------------------
    // CREATE USER (Super Admin only)
    // GET  → show form
    // POST → validate + insert + redirect
    // ----------------------------------------------------------
    public function createUser() {
        requireRole(['Super Admin']);

        $roles  = $this->userModel->getRoles();
        $errors = [];
        $old    = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName        = trim($_POST['full_name']        ?? '');
            $email           = trim($_POST['email']            ?? '');
            $roleId          = (int)($_POST['role_id']         ?? 0);
            $password        = $_POST['password']              ?? '';
            $confirmPassword = $_POST['confirm_password']      ?? '';

            $old = [
                'full_name' => $fullName,
                'email'     => $email,
                'role_id'   => $roleId,
            ];

            // ── Validation ────────────────────────────────────
            if (empty($fullName)) {
                $errors[] = 'Full name is required.';
            }
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'A valid email address is required.';
            }
            if ($roleId < 1 || !$this->userModel->roleExists($roleId)) {
                $errors[] = 'Please select a valid role.';
            }
            if (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters.';
            }
            if ($password !== $confirmPassword) {
                $errors[] = 'Passwords do not match.';
            }
            if (empty($errors) && $this->userModel->emailExists($email)) {
                $errors[] = 'That email address is already registered.';
            }

            // ── Save ──────────────────────────────────────────
            if (empty($errors)) {
                $hashed = password_hash($password, PASSWORD_BCRYPT);
                $this->userModel->create($fullName, $email, $hashed, $roleId);
                setFlash('success', 'User "' . $fullName . '" created successfully.');
                redirect(BASE_URL . 'dashboard/users');
            }
        }

        include dirname(__DIR__) . '/views/dashboard/users/create.php';
    }

    // ----------------------------------------------------------
    // EDIT USER ROLE (inline role change from the list page)
    // ----------------------------------------------------------
    public function edit($id) {
        requireRole(['Super Admin', 'Admin']);

        $user  = $this->userModel->findById($id);
        $roles = $this->userModel->getRoles();
        $users = $this->userModel->getAll();

        if (!$user) {
            setFlash('danger', 'User not found.');
            redirect(BASE_URL . 'dashboard/users');
        }

        // Admins cannot modify Super Admins
        if (hasRole(['Admin']) && $user['role_name'] === 'Super Admin') {
            setFlash('danger', 'You cannot modify a Super Admin account.');
            redirect(BASE_URL . 'dashboard/users');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $roleId = (int)($_POST['role_id'] ?? 0);

            if ($roleId < 1 || !$this->userModel->roleExists($roleId)) {
                setFlash('danger', 'Invalid role selected.');
                redirect(BASE_URL . 'dashboard/users');
            }

            // Only Super Admin can assign Super Admin role
            if ($roleId === 1 && !hasRole(['Super Admin'])) {
                setFlash('danger', 'Only Super Admins can grant the Super Admin role.');
                redirect(BASE_URL . 'dashboard/users');
            }

            $this->userModel->updateRole($id, $roleId);
            setFlash('success', 'User role updated successfully.');
            redirect(BASE_URL . 'dashboard/users');
        }

        include dirname(__DIR__) . '/views/dashboard/users/list.php';
    }

    // ----------------------------------------------------------
    // DELETE USER (Super Admin only)
    // ----------------------------------------------------------
    public function delete($id) {
        requireRole(['Super Admin']);

        // Cannot delete yourself
        if ((int)$id === (int)($_SESSION['user_id'] ?? 0)) {
            setFlash('danger', 'You cannot delete your own account.');
            redirect(BASE_URL . 'dashboard/users');
        }

        $user = $this->userModel->findById($id);
        if (!$user) {
            setFlash('danger', 'User not found.');
            redirect(BASE_URL . 'dashboard/users');
        }

        $this->userModel->delete($id);
        setFlash('success', 'User "' . $user['full_name'] . '" has been deleted.');
        redirect(BASE_URL . 'dashboard/users');
    }
}