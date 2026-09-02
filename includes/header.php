<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/functions.php';
$user = currentUser();
$pageTitle = $pageTitle ?? 'Hospital Management';
$flash = flashMessage();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> | MediCore HMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/hospital-management-system-modern/assets/css/style.css">
</head>
<body>
<div class="app-shell">
<?php if ($user): ?>
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="main-content">
        <header class="topbar">
            <button class="btn icon-btn d-lg-none" id="sidebarToggle" aria-label="Open menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div>
                <div class="topbar-eyebrow">Hospital Operations</div>
                <h1 class="topbar-title"><?= e($pageTitle) ?></h1>
            </div>
            <div class="topbar-actions">
                <button class="btn icon-btn" id="themeToggle" title="Toggle theme">
                    <i class="fa-solid fa-moon"></i>
                </button>
                <div class="user-chip">
                    <div class="avatar"><?= e(strtoupper(substr($user['name'], 0, 1))) ?></div>
                    <div class="d-none d-sm-block">
                        <strong><?= e($user['name']) ?></strong>
                        <span><?= e(ucfirst($user['role'])) ?></span>
                    </div>
                </div>
            </div>
        </header>
        <section class="content-area">
            <?php if ($flash): ?>
                <div class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show shadow-sm border-0" role="alert">
                    <?= e($flash['message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
<?php else: ?>
    <main class="auth-shell">
<?php endif; ?>
