<?php
require_once __DIR__ . '/config/db.php';

$message = '';
$exists = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
if ((int)$exists === 0) {
    $stmt = $pdo->prepare("INSERT INTO users(name,email,password,role,status,created_at) VALUES(?,?,?,?,?,NOW())");
    $stmt->execute(['System Admin','admin@hospital.local',password_hash('Admin@123', PASSWORD_DEFAULT),'admin','active']);
    $message = 'Admin user created successfully.';
} else {
    $message = 'A user already exists. Setup skipped.';
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>HMS Setup</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light"><div class="container py-5"><div class="card shadow-sm border-0 mx-auto" style="max-width:600px"><div class="card-body p-4">
<h2>Hospital Management Setup</h2><p><?= htmlspecialchars($message) ?></p>
<p><strong>Login:</strong> admin@hospital.local / Admin@123</p>
<a class="btn btn-primary" href="login.php">Go to Login</a>
</div></div></div></body></html>
