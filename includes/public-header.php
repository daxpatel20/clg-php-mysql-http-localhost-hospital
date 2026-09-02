<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/patient-auth.php';
$publicTitle = $publicTitle ?? 'MediCore Hospital';
$current = basename($_SERVER['PHP_SELF'] ?? 'index.php');
$patientUser = currentPatientUser();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= e($publicTitle) ?> | MediCore Hospital</title>
  <meta name="description" content="MediCore Hospital patient portal and appointment tracking.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
  <link href="/hospital-management-system-modern/assets/css/public.css" rel="stylesheet">
</head>
<body class="public-site">
<div class="public-topbar"><div class="container d-flex justify-content-between align-items-center gap-3 flex-wrap"><div class="d-flex gap-3"><span><i class="fa-regular fa-envelope"></i> care@medicore.local</span><span><i class="fa-solid fa-phone"></i> +91 98765 43210</span></div><div><span><i class="fa-regular fa-clock"></i> 24/7 Emergency Support</span></div></div></div>
<nav class="navbar navbar-expand-lg public-nav sticky-top"><div class="container">
<a class="navbar-brand" href="/hospital-management-system-modern/index.php"><span class="logo-mark"><i class="fa-solid fa-heart-pulse"></i></span><span>MediCore<small>Hospital & Care</small></span></a>
<button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#publicMenu"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="publicMenu"><ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
<?php if ($patientUser): ?>
  <li class="nav-item"><a class="nav-link" href="/hospital-management-system-modern/patient/dashboard.php">My Panel</a></li>
  <li class="nav-item"><a class="nav-link" href="/hospital-management-system-modern/patient/appointment.php">Book Appointment</a></li>
  <li class="nav-item ms-lg-2"><a class="btn nav-appointment" href="/hospital-management-system-modern/patient/logout.php">Logout <i class="fa-solid fa-arrow-right-from-bracket ms-1"></i></a></li>
<?php else: ?>
  <li class="nav-item"><a class="nav-link active" href="/hospital-management-system-modern/index.php">Home</a></li>
  <li class="nav-item"><a class="nav-link" href="/hospital-management-system-modern/patient/login.php">Patient Login</a></li>
  <li class="nav-item ms-lg-2"><a class="btn nav-appointment" href="/hospital-management-system-modern/patient/register.php">Create Account <i class="fa-solid fa-user-plus ms-1"></i></a></li>
<?php endif; ?>
</ul></div></div></nav>
