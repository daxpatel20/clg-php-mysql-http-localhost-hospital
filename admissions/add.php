<?php
require_once __DIR__ . '/../includes/auth.php'; requireLogin(); require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
$patients=$pdo->query("SELECT id,name FROM patients ORDER BY name")->fetchAll();$doctors=$pdo->query("SELECT id,name FROM doctors ORDER BY name")->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){ $s=$pdo->prepare("INSERT INTO admissions(patient_id,doctor_id,room_no,bed_no,admission_date,discharge_date,status) VALUES(?,?,?,?,?,?,?)");
$s->execute([(int)post('patient_id'),(int)post('doctor_id'),post('room_no'),post('bed_no'),post('admission_date'),post('discharge_date')?:null,post('status')]);redirectWithMessage('list.php','Admission added.');}
$pageTitle='Add Admission'; include __DIR__ . '/../includes/header.php';
?><div class="panel"><div class="p-4"><form method="post"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Patient</label><select class="form-select" name="patient_id"><?php foreach($patients as $p): ?><option value="<?= $p['id'] ?>"><?= e($p['name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-6"><label class="form-label">Doctor</label><select class="form-select" name="doctor_id"><?php foreach($doctors as $d): ?><option value="<?= $d['id'] ?>"><?= e($d['name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-3"><label class="form-label">Room No</label><input class="form-control" name="room_no"></div><div class="col-md-3"><label class="form-label">Bed No</label><input class="form-control" name="bed_no"></div>
<div class="col-md-3"><label class="form-label">Admission Date</label><input class="form-control" type="date" name="admission_date" required></div><div class="col-md-3"><label class="form-label">Discharge Date</label><input class="form-control" type="date" name="discharge_date"></div>
<div class="col-md-4"><label class="form-label">Status</label><select class="form-select" name="status"><option>admitted</option><option>discharged</option></select></div>
<div class="col-12"><button class="btn btn-primary">Save Admission</button> <a class="btn btn-light" href="list.php">Cancel</a></div>
</div></form></div></div><?php include __DIR__ . '/../includes/footer.php'; ?>
