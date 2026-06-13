<?php

function redirect($url) {
    header('Location: ' . $url);
    exit();
}

/**
 * Safely escape output to prevent XSS attacks.
 * Always use this when printing user-supplied data in HTML.
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Generate a URL-friendly slug from a title.
 * Example: "Hello World!" → "hello-world"
 */
function makeSlug($string) {
    $string = strtolower(trim($string));
    $string = preg_replace('/[^a-z0-9\s\-]/', '', $string);
    $string = preg_replace('/[\s\-]+/', '-', $string);
    return trim($string, '-');
}

/**
 * Check if a user is logged in.
 * Returns true/false.
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Get the current logged-in user's role name.
 */
function getUserRole() {
    return $_SESSION['user_role'] ?? null;
}

/**
 * Check if the current user has one of the allowed roles.
 * Usage: hasRole(['Super Admin', 'Admin'])
 */
function hasRole(array $roles) {
    return in_array(getUserRole(), $roles);
}

/**
 * Require login — redirect to login page if not logged in.
 */
function requireLogin() {
    if (!isLoggedIn()) {
        redirect(BASE_URL . 'auth/login');
    }
}

/**
 * Require a specific role — show 403 if not authorized.
 */
function requireRole(array $roles) {
    requireLogin();
    if (!hasRole($roles)) {
        http_response_code(403);
        include dirname(__DIR__) . '/app/views/layouts/header.php';
        echo '<div class="container mt-5"><div class="alert alert-danger"><h4>Access Denied</h4><p>You do not have permission to access this page.</p></div></div>';
        include dirname(__DIR__) . '/app/views/layouts/footer.php';
        exit();
    }
}

/**
 * Display a flash message stored in session.
 * Call setFlash() to set, showFlash() to display.
 */
function setFlash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function showFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        $type = $flash['type']; // 'success', 'danger', 'warning', 'info'
        $msg  = e($flash['message']);
        echo "<div class='alert alert-{$type} alert-dismissible fade show' role='alert'>
                {$msg}
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    }
}

/**
 * Format a MySQL datetime string into a human-readable format.
 */
function formatDate($datetime) {
    return date('F j, Y', strtotime($datetime));
}

/**
 * Truncate a string to a given length, appending '...'
 */
function truncate($string, $length = 120) {
    if (strlen(strip_tags($string)) <= $length) return strip_tags($string);
    return substr(strip_tags($string), 0, $length) . '...';
}

/**
 * Handle image upload. Returns filename on success, false on failure.
 * Only allows jpg, jpeg, png, gif, webp.
 */
function uploadImage($fileInput) {
    if (!isset($fileInput) || $fileInput['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    $mime    = mime_content_type($fileInput['tmp_name']);

    if (!in_array($mime, $allowed)) {
        return false;
    }

    if ($fileInput['size'] > 2 * 1024 * 1024) { // 2MB limit
        return false;
    }

    $ext      = pathinfo($fileInput['name'], PATHINFO_EXTENSION);
    $filename = uniqid('img_', true) . '.' . strtolower($ext);
    $dest     = UPLOAD_PATH . $filename;

    if (move_uploaded_file($fileInput['tmp_name'], $dest)) {
        return $filename;
    }

    return false;
}