<?php
require_once __DIR__ . '/../includes/auth.php'; requireLogin(); require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
$id=(int)($_GET['id']??0); $stmt=$pdo->prepare("SELECT * FROM patients WHERE id=?"); $stmt->execute([$id]); $row=$stmt->fetch(); if(!$row) exit('Patient not found');
if($_SERVER['REQUEST_METHOD']==='POST'){ $stmt=$pdo->prepare("UPDATE patients SET name=?,gender=?,dob=?,phone=?,email=?,address=?,blood_group=?,emergency_contact=? WHERE id=?");
$stmt->execute([post('name'),post('gender'),post('dob')?:null,post('phone'),post('email'),post('address'),post('blood_group'),post('emergency_contact'),$id]); redirectWithMessage('list.php','Patient updated.');}
$pageTitle='Edit Patient'; include __DIR__ . '/../includes/header.php';
?>
<div class="panel"><div class="p-4"><form method="post"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Full Name</label><input class="form-control" name="name" value="<?= e($row['name']) ?>" required></div>
<div class="col-md-3"><label class="form-label">Gender</label><select class="form-select" name="gender"><?php foreach(['Male','Female','Other'] as $v): ?><option <?= $row['gender']===$v?'selected':'' ?>><?= $v ?></option><?php endforeach; ?></select></div>
<div class="col-md-3"><label class="form-label">Date of Birth</label><input class="form-control" type="date" name="dob" value="<?= e($row['dob']) ?>"></div>
<div class="col-md-4"><label class="form-label">Phone</label><input class="form-control" name="phone" value="<?= e($row['phone']) ?>"></div>
<div class="col-md-4"><label class="form-label">Email</label><input class="form-control" name="email" value="<?= e($row['email']) ?>"></div>
<div class="col-md-4"><label class="form-label">Blood Group</label><input class="form-control" name="blood_group" value="<?= e($row['blood_group']) ?>"></div>
<div class="col-md-6"><label class="form-label">Emergency Contact</label><input class="form-control" name="emergency_contact" value="<?= e($row['emergency_contact']) ?>"></div>
<div class="col-12"><label class="form-label">Address</label><textarea class="form-control" name="address"><?= e($row['address']) ?></textarea></div>
<div class="col-12"><button class="btn btn-primary">Update Patient</button> <a class="btn btn-light" href="list.php">Cancel</a></div></div></form></div></div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
