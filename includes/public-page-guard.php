<?php
require_once __DIR__ . '/patient-auth.php';
// Public visitors can see only the landing page. Logged-in patients use their private panel.
if (patientLoggedIn()) {
    header('Location: /hospital-management-system-modern/patient/dashboard.php');
} else {
    header('Location: /hospital-management-system-modern/index.php');
}
exit;
