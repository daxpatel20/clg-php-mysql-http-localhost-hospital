<?php
session_start();
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_once __DIR__ . '/../includes/patient-auth.php';
if(patientLoggedIn()){header('Location: dashboard.php');exit;}
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  try{
    $name=post('name');$email=strtolower(post('email'));$phone=post('phone');$password=$_POST['password']??'';$confirm=$_POST['confirm_password']??'';
    if(!$name||!$email||!$phone||!$password) throw new RuntimeException('Please complete all required fields.');
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) throw new RuntimeException('Please enter a valid email.');
    if(strlen($password)<8) throw new RuntimeException('Password must be at least 8 characters.');
    if($password!==$confirm) throw new RuntimeException('Passwords do not match.');
    $st=$pdo->prepare('SELECT id FROM patient_accounts WHERE email=?');$st->execute([$email]);if($st->fetch()) throw new RuntimeException('An account with this email already exists.');
    $pdo->beginTransaction();
    $st=$pdo->prepare("SELECT id FROM patients WHERE email=? OR phone=? LIMIT 1");$st->execute([$email,$phone]);$pid=(int)($st->fetchColumn()?:0);
    if(!$pid){$code='PAT'.date('ymd').random_int(1000,9999);$st=$pdo->prepare('INSERT INTO patients(patient_code,name,phone,email,created_at) VALUES(?,?,?,?,NOW())');$st->execute([$code,$name,$phone,$email]);$pid=(int)$pdo->lastInsertId();}
    else {$st=$pdo->prepare('UPDATE patients SET name=?, phone=?, email=? WHERE id=?');$st->execute([$name,$phone,$email,$pid]);}
    $st=$pdo->prepare("INSERT INTO patient_accounts(patient_id,email,password,status,created_at) VALUES(?,?,?,'active',NOW())");$st->execute([$pid,$email,password_hash($password,PASSWORD_DEFAULT)]);
    $pdo->commit();
    $st=$pdo->prepare('SELECT patient_code FROM patients WHERE id=?');$st->execute([$pid]);$code=$st->fetchColumn();
    $_SESSION['patient_user']=['account_id'=>(int)$pdo->lastInsertId(),'patient_id'=>$pid,'name'=>$name,'email'=>$email,'patient_code'=>$code];
    header('Location: dashboard.php');exit;
  }catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();$error=$e->getMessage();}
}
$publicTitle='Patient Registration';include __DIR__.'/../includes/public-header.php';
?>
<section class="portal-auth"><div class="container"><div class="row justify-content-center"><div class="col-lg-8"><div class="portal-auth-card p-4 p-lg-5"><div class="section-kicker">Create Patient Account</div><h2 class="fw-bold">Your private MediCore panel</h2><p class="text-secondary">Register once, then track only your own hospital appointments.</p><?php if($error): ?><div class="alert alert-danger alert-modern"><?= e($error) ?></div><?php endif; ?>
<form method="post"><div class="row g-3"><div class="col-md-6"><label class="form-label">Full Name *</label><input class="form-control" name="name" required value="<?= e($_POST['name']??'') ?>"></div><div class="col-md-6"><label class="form-label">Phone *</label><input class="form-control" name="phone" required value="<?= e($_POST['phone']??'') ?>"></div><div class="col-12"><label class="form-label">Email *</label><input class="form-control" type="email" name="email" required value="<?= e($_POST['email']??'') ?>"></div><div class="col-md-6"><label class="form-label">Password *</label><input class="form-control" type="password" name="password" minlength="8" required></div><div class="col-md-6"><label class="form-label">Confirm Password *</label><input class="form-control" type="password" name="confirm_password" minlength="8" required></div><div class="col-12"><button class="btn btn-main">Create Account</button> <a class="btn btn-outline-secondary ms-2" href="login.php">Login</a></div></div></form></div></div></div></div></section>
<?php include __DIR__.'/../includes/public-footer.php'; ?>
