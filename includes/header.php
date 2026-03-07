<?php
$pageTitle = $pageTitle ?? 'Campus Skill Exchange';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> - Campus Skill Exchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= url('assets/css/app.css') ?>" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-cse">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= url('/') ?>">
            <i class="bi bi-mortarboard-fill"></i>
            Campus Skill Exchange
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= url('/') ?>"><i class="bi bi-house-door me-1"></i>Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('/courses') ?>"><i class="bi bi-book me-1"></i>Courses</a></li>
                <?php if (Auth::isLoggedIn()): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('/my-courses') ?>"><i class="bi bi-collection-play me-1"></i>My Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('/profile') ?>"><i class="bi bi-person me-1"></i>Profile</a></li>
                <?php endif; ?>
                <?php if (Auth::isAdmin()): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('/admin') ?>"><i class="bi bi-gear me-1"></i>Admin</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav align-items-center gap-2">
                <?php if (Auth::isLoggedIn()): ?>
                    <li class="nav-item"><span class="navbar-text btn-pill"><?= e($_SESSION['user_name'] ?? 'User') ?></span></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('/logout') ?>"><i class="bi bi-box-arrow-right me-1"></i>Logout</a></li>
                <?php elseif (Auth::isAdmin()): ?>
                    <li class="nav-item"><span class="navbar-text btn-pill"><?= e($_SESSION['admin_username'] ?? 'Admin') ?></span></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('/logout') ?>"><i class="bi bi-box-arrow-right me-1"></i>Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('/login') ?>"><i class="bi bi-box-arrow-in-right me-1"></i>Login</a></li>
                    <li class="nav-item"><a class="btn btn-light btn-sm rounded-pill px-3" href="<?= url('/signup') ?>">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="container my-4 py-2">
<?php if ($_err = flash('error')): ?>
<div class="alert alert-danger"><?= e($_err) ?></div>
<?php endif; ?>
