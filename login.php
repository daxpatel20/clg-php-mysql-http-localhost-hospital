<?php
session_start();
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = post('email');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 'active' LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => (int)$user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Invalid email or password.';
}
$pageTitle = 'Login';
include __DIR__ . '/includes/header.php';
?>
<div class="auth-card">
    <div class="auth-visual">
        <div class="brand-mini"><i class="fa-solid fa-heart-pulse"></i> MediCore HMS</div>
        <h2>Smarter hospital operations, in one clean dashboard.</h2>
        <p>Manage patients, doctors, appointments, admissions, pharmacy stock and billing with a modern responsive interface.</p>
    </div>
    <div class="auth-form">
        <div class="brand-mini"><i class="fa-solid fa-heart-pulse"></i> MediCore HMS</div>
        <h3>Welcome back</h3>
        <p class="text-secondary mb-4">Sign in to continue to the hospital dashboard.</p>
        <?php if ($error): ?><div class="alert alert-danger border-0"><?= e($error) ?></div><?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input class="form-control" type="email" name="email" required placeholder="admin@hospital.local">
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input class="form-control" type="password" name="password" required placeholder="••••••••">
            </div>
            <button class="btn btn-primary w-100 py-3"><i class="fa-solid fa-right-to-bracket me-2"></i>Login</button>
        </form>
        <div class="mt-4 small text-secondary">
            First time setup? Run <code>setup.php</code> after importing the SQL file.
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
