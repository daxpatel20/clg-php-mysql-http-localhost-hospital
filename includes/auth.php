<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function isLoggedIn(): bool {
    return isset($_SESSION['user']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: /hospital-management-system-modern/login.php');
        exit;
    }
}

function requireRole(array $roles): void {
    requireLogin();
    $role = $_SESSION['user']['role'] ?? '';
    if (!in_array($role, $roles, true)) {
        http_response_code(403);
        exit('Access denied');
    }
}

function currentUser(): ?array {
    return $_SESSION['user'] ?? null;
}
