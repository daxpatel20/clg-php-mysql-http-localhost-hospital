<?php
require_once __DIR__ . '/../includes/auth.php'; requireLogin(); require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
$id=(int)($_GET['id']??0);$s=$pdo->prepare("SELECT * FROM doctors WHERE id=?");$s->execute([$id]);$row=$s->fetch();if(!$row)exit('Doctor not found');
$deps=$pdo->query("SELECT * FROM departments ORDER BY department_name")->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){ $s=$pdo->prepare("UPDATE doctors SET department_id=?,name=?,specialization=?,phone=?,email=?,gender=?,qualification=?,fee=?,status=? WHERE id=?");
$s->execute([(int)post('department_id'),post('name'),post('specialization'),post('phone'),post('email'),post('gender'),post('qualification'),(float)post('fee'),post('status'),$id]);redirectWithMessage('list.php','Doctor updated.');}
$pageTitle='Edit Doctor'; include __DIR__ . '/../includes/header.php';
?><div class="panel"><div class="p-4"><form method="post"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Doctor Name</label><input class="form-control" name="name" value="<?= e($row['name']) ?>" required></div>
<div class="col-md-6"><label class="form-label">Department</label><select class="form-select" name="department_id"><?php foreach($deps as $d): ?><option value="<?= $d['id'] ?>" <?= $row['department_id']==$d['id']?'selected':'' ?>><?= e($d['department_name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-6"><label class="form-label">Specialization</label><input class="form-control" name="specialization" value="<?= e($row['specialization']) ?>"></div>
<div class="col-md-6"><label class="form-label">Qualification</label><input class="form-control" name="qualification" value="<?= e($row['qualification']) ?>"></div>
<div class="col-md-4"><label class="form-label">Phone</label><input class="form-control" name="phone" value="<?= e($row['phone']) ?>"></div>
<div class="col-md-4"><label class="form-label">Email</label><input class="form-control" name="email" value="<?= e($row['email']) ?>"></div>
<div class="col-md-2"><label class="form-label">Gender</label><input class="form-control" name="gender" value="<?= e($row['gender']) ?>"></div>
<div class="col-md-2"><label class="form-label">Fee</label><input class="form-control" name="fee" value="<?= e((string)$row['fee']) ?>"></div>
<div class="col-md-4"><label class="form-label">Status</label><select class="form-select" name="status"><option <?= $row['status']==='active'?'selected':'' ?>>active</option><option <?= $row['status']==='inactive'?'selected':'' ?>>inactive</option></select></div>
<div class="col-12"><button class="btn btn-primary">Update Doctor</button> <a class="btn btn-light" href="list.php">Cancel</a></div>
</div></form></div></div><?php include __DIR__ . '/../includes/footer.php'; ?>
