<?php
require_once __DIR__ . '/../includes/auth.php'; requireLogin(); require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
$deps=$pdo->query("SELECT * FROM departments ORDER BY department_name")->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){ $s=$pdo->prepare("INSERT INTO doctors(department_id,name,specialization,phone,email,gender,qualification,fee,status) VALUES(?,?,?,?,?,?,?,?,?)");
$s->execute([(int)post('department_id'),post('name'),post('specialization'),post('phone'),post('email'),post('gender'),post('qualification'),(float)post('fee'),post('status')]);redirectWithMessage('list.php','Doctor added.');}
$pageTitle='Add Doctor'; include __DIR__ . '/../includes/header.php';
?><div class="panel"><div class="p-4"><form method="post"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Doctor Name</label><input class="form-control" name="name" required></div>
<div class="col-md-6"><label class="form-label">Department</label><select class="form-select" name="department_id" required><option value="">Select</option><?php foreach($deps as $d): ?><option value="<?= $d['id'] ?>"><?= e($d['department_name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-6"><label class="form-label">Specialization</label><input class="form-control" name="specialization"></div>
<div class="col-md-6"><label class="form-label">Qualification</label><input class="form-control" name="qualification"></div>
<div class="col-md-4"><label class="form-label">Phone</label><input class="form-control" name="phone"></div>
<div class="col-md-4"><label class="form-label">Email</label><input class="form-control" name="email"></div>
<div class="col-md-2"><label class="form-label">Gender</label><select class="form-select" name="gender"><option>Male</option><option>Female</option><option>Other</option></select></div>
<div class="col-md-2"><label class="form-label">Fee</label><input class="form-control" type="number" step="0.01" name="fee"></div>
<div class="col-md-4"><label class="form-label">Status</label><select class="form-select" name="status"><option>active</option><option>inactive</option></select></div>
<div class="col-12"><button class="btn btn-primary">Save Doctor</button> <a class="btn btn-light" href="list.php">Cancel</a></div>
</div></form></div></div><?php include __DIR__ . '/../includes/footer.php'; ?>
