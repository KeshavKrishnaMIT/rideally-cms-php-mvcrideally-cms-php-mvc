<?php
// We check if BASE_URL is defined (it should be, since index.php includes config first).
// This header is included by every page.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RideAlly CMS</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= BASE_URL ?>assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- ============================================================
     NAVIGATION
     Shows different links based on whether user is logged in.
     ============================================================ -->
<nav class="navbar navbar-expand-lg navbar-dark cms-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>">
            <i class="bi bi-journal-richtext me-1"></i>RideAlly CMS
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>posts">Posts</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center">
    <?php if (
        isLoggedIn() &&
        isset($_SESSION['user_name']) &&
        isset($_SESSION['user_role'])
    ): ?>
        <li class="nav-item me-2">
            <span class="nav-link text-warning">
                <i class="bi bi-person-fill me-1"></i>
                <?= e($_SESSION['user_name']) ?>

                <span class="badge bg-secondary ms-1">
                    <?= e($_SESSION['user_role']) ?>
                </span>
            </span>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>dashboard">
                <i class="bi bi-speedometer2 me-1"></i>Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>auth/logout">
                <i class="bi bi-box-arrow-right me-1"></i>Logout
            </a>
        </li>

    <?php else: ?>

        <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>auth/login">
                <i class="bi bi-box-arrow-in-right me-1"></i>Login
            </a>
        </li>

        <li class="nav-item">
            <a class="btn btn-outline-light btn-sm ms-2"
               href="<?= BASE_URL ?>auth/register">
                Register
            </a>
        </li>

    <?php endif; ?>
</ul>
        </div>
    </div>
</nav>

<main>