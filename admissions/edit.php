<?php
require_once __DIR__ . '/../includes/auth.php'; requireLogin(); require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
$id=(int)($_GET['id']??0);$s=$pdo->prepare("SELECT * FROM admissions WHERE id=?");$s->execute([$id]);$row=$s->fetch();if(!$row)exit('Not found');
$patients=$pdo->query("SELECT id,name FROM patients ORDER BY name")->fetchAll();$doctors=$pdo->query("SELECT id,name FROM doctors ORDER BY name")->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){ $s=$pdo->prepare("UPDATE admissions SET patient_id=?,doctor_id=?,room_no=?,bed_no=?,admission_date=?,discharge_date=?,status=? WHERE id=?");
$s->execute([(int)post('patient_id'),(int)post('doctor_id'),post('room_no'),post('bed_no'),post('admission_date'),post('discharge_date')?:null,post('status'),$id]);redirectWithMessage('list.php','Admission updated.');}
$pageTitle='Edit Admission'; include __DIR__ . '/../includes/header.php';
?><div class="panel"><div class="p-4"><form method="post"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Patient</label><select class="form-select" name="patient_id"><?php foreach($patients as $p): ?><option value="<?= $p['id'] ?>" <?= $row['patient_id']==$p['id']?'selected':'' ?>><?= e($p['name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-6"><label class="form-label">Doctor</label><select class="form-select" name="doctor_id"><?php foreach($doctors as $d): ?><option value="<?= $d['id'] ?>" <?= $row['doctor_id']==$d['id']?'selected':'' ?>><?= e($d['name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-3"><label class="form-label">Room</label><input class="form-control" name="room_no" value="<?= e($row['room_no']) ?>"></div><div class="col-md-3"><label class="form-label">Bed</label><input class="form-control" name="bed_no" value="<?= e($row['bed_no']) ?>"></div>
<div class="col-md-3"><label class="form-label">Admission</label><input class="form-control" type="date" name="admission_date" value="<?= e($row['admission_date']) ?>"></div><div class="col-md-3"><label class="form-label">Discharge</label><input class="form-control" type="date" name="discharge_date" value="<?= e($row['discharge_date']) ?>"></div>
<div class="col-md-4"><label class="form-label">Status</label><select class="form-select" name="status"><option <?= $row['status']==='admitted'?'selected':'' ?>>admitted</option><option <?= $row['status']==='discharged'?'selected':'' ?>>discharged</option></select></div>
<div class="col-12"><button class="btn btn-primary">Update Admission</button> <a class="btn btn-light" href="list.php">Cancel</a></div>
</div></form></div></div><?php include __DIR__ . '/../includes/footer.php'; ?>
