<?php

if ($_SERVER['HTTP_HOST'] === 'localhost' || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {

    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'cms_dbnew');

    define('BASE_URL', 'http://localhost/mini_pro_rideally_v2/public/');

} else {

    define('DB_HOST', 'sql210.infinityfree.com');
    define('DB_USER', 'if0_42173113');
    define('DB_PASS', 'vtJ1PzQzCwy');
    define('DB_NAME', 'if0_42173113_cms');

    define('BASE_URL', 'https://rideallycms.infinityfreeapp.com/public/');
}

define('UPLOAD_PATH', dirname(__DIR__) . '/public/assets/uploads/');
define('UPLOAD_URL', BASE_URL . 'assets/uploads/');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');