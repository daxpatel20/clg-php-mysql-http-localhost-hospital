<?php
declare(strict_types=1);

function e(?string $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function redirectWithMessage(string $path, string $message, string $type = 'success'): never {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
    header("Location: {$path}");
    exit;
}

function flashMessage(): ?array {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function statusClass(string $status): string {
    $s = strtolower($status);
    return match ($s) {
        'completed','paid','active','confirmed','discharged','available' => 'success',
        'pending','upcoming','admitted','low stock' => 'warning',
        'cancelled','unpaid','inactive','expired' => 'danger',
        default => 'secondary',
    };
}

function post(string $key, string $default = ''): string {
    return trim($_POST[$key] ?? $default);
}

function money($value): string {
    return '₹' . number_format((float)$value, 2);
}
