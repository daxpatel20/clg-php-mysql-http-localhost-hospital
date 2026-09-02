<?php
$currentPath = $_SERVER['PHP_SELF'] ?? '';
function navActive(string $needle, string $path): string {
    return str_contains($path, $needle) ? 'active' : '';
}
?>
<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="brand-mark"><i class="fa-solid fa-heart-pulse"></i></div>
        <div>
            <strong>MediCore</strong>
            <span>Hospital System</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Overview</div>
        <a class="<?= navActive('dashboard.php', $currentPath) ?>" href="/hospital-management-system-modern/dashboard.php">
            <i class="fa-solid fa-grid-2"></i><span>Dashboard</span>
        </a>

        <div class="nav-label">Management</div>
        <a class="<?= navActive('/patients/', $currentPath) ?>" href="/hospital-management-system-modern/patients/list.php">
            <i class="fa-solid fa-hospital-user"></i><span>Patients</span>
        </a>
        <a class="<?= navActive('/doctors/', $currentPath) ?>" href="/hospital-management-system-modern/doctors/list.php">
            <i class="fa-solid fa-user-doctor"></i><span>Doctors</span>
        </a>
        <a class="<?= navActive('/appointments/', $currentPath) ?>" href="/hospital-management-system-modern/appointments/list.php">
            <i class="fa-solid fa-calendar-check"></i><span>Appointments</span>
        </a>
        <a class="<?= navActive('/departments/', $currentPath) ?>" href="/hospital-management-system-modern/departments/list.php">
            <i class="fa-solid fa-building"></i><span>Departments</span>
        </a>
        <a class="<?= navActive('/admissions/', $currentPath) ?>" href="/hospital-management-system-modern/admissions/list.php">
            <i class="fa-solid fa-bed-pulse"></i><span>Admissions</span>
        </a>

        <div class="nav-label">Finance & Stock</div>
        <a class="<?= navActive('/pharmacy/', $currentPath) ?>" href="/hospital-management-system-modern/pharmacy/list.php">
            <i class="fa-solid fa-pills"></i><span>Pharmacy</span>
        </a>
        <a class="<?= navActive('/billing/', $currentPath) ?>" href="/hospital-management-system-modern/billing/list.php">
            <i class="fa-solid fa-file-invoice-dollar"></i><span>Billing</span>
        </a>
        <a class="<?= navActive('/enquiries/', $currentPath) ?>" href="/hospital-management-system-modern/enquiries/list.php">
            <i class="fa-solid fa-envelope-open-text"></i><span>Enquiries</span>
        </a>

        <div class="nav-label">Account</div>
        <a href="/hospital-management-system-modern/logout.php">
            <i class="fa-solid fa-arrow-right-from-bracket"></i><span>Logout</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="support-card">
            <i class="fa-solid fa-shield-heart"></i>
            <div><strong>Secure System</strong><span>Session & role protected</span></div>
        </div>
    </div>
</aside>
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
