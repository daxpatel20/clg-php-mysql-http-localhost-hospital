<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/patient-auth.php';
if (patientLoggedIn()) { header('Location: dashboard.php'); exit; }
$error='';
$next=$_GET['next'] ?? $_POST['next'] ?? 'dashboard.php';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $email=strtolower(post('email')); $password=$_POST['password'] ?? '';
    $st=$pdo->prepare("SELECT pa.*, p.name, p.patient_code FROM patient_accounts pa JOIN patients p ON p.id=pa.patient_id WHERE pa.email=? AND pa.status='active' LIMIT 1");
    $st->execute([$email]); $account=$st->fetch();
    if ($account && password_verify($password,$account['password'])) {
        session_regenerate_id(true);
        $_SESSION['patient_user']=['account_id'=>(int)$account['id'],'patient_id'=>(int)$account['patient_id'],'name'=>$account['name'],'email'=>$account['email'],'patient_code'=>$account['patient_code']];
        header('Location: dashboard.php'); exit;
    }
    $error='Invalid email or password.';
}
$publicTitle='Patient Login'; include __DIR__ . '/../includes/public-header.php';
?>
<section class="portal-auth"><div class="container"><div class="row justify-content-center"><div class="col-lg-9"><div class="portal-auth-card"><div class="row g-0">
<div class="col-lg-5 portal-auth-side"><span class="portal-badge"><i class="fa-solid fa-user-shield"></i> Secure Patient Portal</span><h2>Track your care, privately.</h2><p>Login to see only your appointments and their latest hospital confirmation status.</p><ul><li><i class="fa-solid fa-circle-check"></i> Your appointment history</li><li><i class="fa-solid fa-circle-check"></i> Pending / Confirmed / Completed status</li><li><i class="fa-solid fa-circle-check"></i> Book a new appointment</li></ul></div>
<div class="col-lg-7 p-4 p-lg-5"><div class="section-kicker">Patient Login</div><h3 class="fw-bold mb-2">Welcome back</h3><p class="text-secondary mb-4">Use your patient account to continue.</p><?php if($error): ?><div class="alert alert-danger alert-modern"><?= e($error) ?></div><?php endif; ?>
<form method="post"><input type="hidden" name="next" value="<?= e($next) ?>"><div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" required></div><div class="mb-4"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div><button class="btn btn-main w-100">Login to My Panel <i class="fa-solid fa-arrow-right ms-1"></i></button></form>
<p class="small text-secondary text-center mt-4 mb-0">New patient? <a href="register.php" class="fw-bold" style="color:var(--p)">Create account</a></p></div>
</div></div></div></div></div></section>
<?php include __DIR__ . '/../includes/public-footer.php'; ?>
