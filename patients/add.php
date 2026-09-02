<?php
require_once __DIR__ . '/../includes/auth.php'; requireLogin();
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $code='PAT'.date('ymd').random_int(100,999);
  $stmt=$pdo->prepare("INSERT INTO patients(patient_code,name,gender,dob,phone,email,address,blood_group,emergency_contact,created_at) VALUES(?,?,?,?,?,?,?,?,?,NOW())");
  $stmt->execute([$code,post('name'),post('gender'),post('dob') ?: null,post('phone'),post('email'),post('address'),post('blood_group'),post('emergency_contact')]);
  redirectWithMessage('list.php','Patient registered successfully.');
}
$pageTitle='Add Patient'; include __DIR__ . '/../includes/header.php';
?>
<div class="panel"><div class="panel-header"><div><h2 class="panel-title">Register Patient</h2><p class="panel-subtitle">Enter patient personal and contact details</p></div></div>
<div class="p-4"><form method="post"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Full Name *</label><input class="form-control" name="name" required></div>
<div class="col-md-3"><label class="form-label">Gender</label><select class="form-select" name="gender"><option>Male</option><option>Female</option><option>Other</option></select></div>
<div class="col-md-3"><label class="form-label">Date of Birth</label><input class="form-control" type="date" name="dob"></div>
<div class="col-md-4"><label class="form-label">Phone *</label><input class="form-control" name="phone" required></div>
<div class="col-md-4"><label class="form-label">Email</label><input class="form-control" type="email" name="email"></div>
<div class="col-md-4"><label class="form-label">Blood Group</label><input class="form-control" name="blood_group" placeholder="O+"></div>
<div class="col-md-6"><label class="form-label">Emergency Contact</label><input class="form-control" name="emergency_contact"></div>
<div class="col-12"><label class="form-label">Address</label><textarea class="form-control" name="address" rows="3"></textarea></div>
<div class="col-12 d-flex gap-2"><button class="btn btn-primary">Save Patient</button><a class="btn btn-light" href="list.php">Cancel</a></div>
</div></form></div></div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
