<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'cms_dbnew');

define('BASE_URL', 'http://localhost/mini_pro_rideally_v2/public/');
define('UPLOAD_PATH', dirname(__DIR__) . '/public/assets/uploads/');
define('UPLOAD_URL', BASE_URL . 'assets/uploads/');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');