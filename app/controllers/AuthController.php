<?php
// ============================================================
// CONTROLLER: AuthController
// ============================================================

class AuthController {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // ----------------------------------------------------------
    // REGISTER
    // ----------------------------------------------------------
    public function register() {
        if (isLoggedIn()) {
            redirect(BASE_URL . 'dashboard');
        }

        $errors  = [];
        $oldData = [];
        $roles   = $this->userModel->getRoles();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName        = trim($_POST['full_name'] ?? '');
            $email           = trim($_POST['email'] ?? '');
            $roleId          = (int)($_POST['role_id'] ?? 0);
            $password        = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            $oldData = [
                'full_name' => $fullName,
                'email'     => $email,
                'role_id'   => $roleId,
            ];

            // Validate
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

            if (empty($errors)) {
                $hashed = password_hash($password, PASSWORD_BCRYPT);
                $this->userModel->create($fullName, $email, $hashed, $roleId);

                // Auto-login after registration
                $newUserId = $this->userModel->getLastInsertId();
                $newUser   = $this->userModel->findById($newUserId);

                $_SESSION['user_id']   = $newUser['id'];
                $_SESSION['user_name'] = $newUser['full_name'];
                $_SESSION['user_role'] = $newUser['role_name'];

                setFlash('success', 'Welcome to RideAlly CMS, ' . $newUser['full_name'] . '!');
                redirect(BASE_URL);
            }
        }

        include dirname(__DIR__) . '/views/auth/register.php';
    }

    // ----------------------------------------------------------
    // LOGIN
    // ----------------------------------------------------------
    public function login() {
        if (isLoggedIn()) {
            $this->redirectByRole();
        }

        $errors  = [];
        $oldData = [];
        $roles   = $this->userModel->getRoles();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $roleId   = (int)($_POST['role_id'] ?? 0);
            $password = $_POST['password'] ?? '';
            $oldData  = ['email' => $email, 'role_id' => $roleId];

            if (empty($email) || empty($password)) {
                $errors[] = 'Email and password are required.';
            } elseif ($roleId < 1) {
                $errors[] = 'Please select your role.';
            } else {
                $user = $this->userModel->findByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    // Check selected role matches actual role
                    if ((int)$user['role_id'] !== $roleId) {
                        $errors[] = 'Selected role does not match this account.';
                    } else {
                        $_SESSION['user_id']   = $user['id'];
                        $_SESSION['user_name'] = $user['full_name'];
                        $_SESSION['user_role'] = $user['role_name'];

                        setFlash('success', 'Welcome back, ' . $user['full_name'] . '!');
                        $this->redirectByRole($user['role_name']);
                    }
                } else {
                    $errors[] = 'Incorrect email or password.';
                }
            }
        }

        include dirname(__DIR__) . '/views/auth/login.php';
    }

    // ----------------------------------------------------------
    // LOGOUT
    // ----------------------------------------------------------
    public function logout() {
        session_destroy();
        redirect(BASE_URL . 'auth/login');
    }

    // ----------------------------------------------------------
    // REDIRECT BY ROLE
    // ----------------------------------------------------------
    private function redirectByRole($role = null) {
        $role = $role ?? ($_SESSION['user_role'] ?? 'User');
        if (in_array($role, ['Super Admin', 'Admin', 'Editor', 'Author'])) {
            redirect(BASE_URL . 'dashboard');
        } else {
            redirect(BASE_URL);
        }
    }
}