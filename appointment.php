<?php
require_once __DIR__.'/includes/patient-auth.php';
if (patientLoggedIn()) header('Location: /hospital-management-system-modern/patient/appointment.php');
else header('Location: /hospital-management-system-modern/patient/login.php');
exit;
