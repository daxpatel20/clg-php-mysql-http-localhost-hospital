<?php
declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
function patientLoggedIn(): bool { return isset($_SESSION['patient_user']); }
function currentPatientUser(): ?array { return $_SESSION['patient_user'] ?? null; }
function requirePatientLogin(): void {
    if (!patientLoggedIn()) {
        $next = urlencode($_SERVER['REQUEST_URI'] ?? '/hospital-management-system-modern/patient/dashboard.php');
        header('Location: /hospital-management-system-modern/patient/login.php?next=' . $next);
        exit;
    }
}
