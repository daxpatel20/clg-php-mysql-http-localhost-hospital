<?php
require_once __DIR__ . '/../includes/auth.php'; requireLogin(); require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
$id=(int)($_GET['id']??0);$s=$pdo->prepare("SELECT * FROM appointments WHERE id=?");$s->execute([$id]);$row=$s->fetch();if(!$row)exit('Appointment not found');
$patients=$pdo->query("SELECT id,name FROM patients ORDER BY name")->fetchAll();$doctors=$pdo->query("SELECT id,name FROM doctors ORDER BY name")->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){ $s=$pdo->prepare("UPDATE appointments SET patient_id=?,doctor_id=?,appointment_date=?,appointment_time=?,reason=?,status=?,notes=? WHERE id=?");
$s->execute([(int)post('patient_id'),(int)post('doctor_id'),post('appointment_date'),post('appointment_time'),post('reason'),post('status'),post('notes'),$id]);redirectWithMessage('list.php','Appointment updated.');}
$pageTitle='Edit Appointment'; include __DIR__ . '/../includes/header.php';
?><div class="panel"><div class="p-4"><form method="post"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Patient</label><select class="form-select" name="patient_id"><?php foreach($patients as $p): ?><option value="<?= $p['id'] ?>" <?= $row['patient_id']==$p['id']?'selected':'' ?>><?= e($p['name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-6"><label class="form-label">Doctor</label><select class="form-select" name="doctor_id"><?php foreach($doctors as $d): ?><option value="<?= $d['id'] ?>" <?= $row['doctor_id']==$d['id']?'selected':'' ?>><?= e($d['name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-3"><label class="form-label">Date</label><input class="form-control" type="date" name="appointment_date" value="<?= e($row['appointment_date']) ?>"></div>
<div class="col-md-3"><label class="form-label">Time</label><input class="form-control" type="time" name="appointment_time" value="<?= e(substr($row['appointment_time'],0,5)) ?>"></div>
<div class="col-md-3"><label class="form-label">Status</label><select class="form-select" name="status"><?php foreach(['pending','confirmed','completed','cancelled'] as $v): ?><option <?= $row['status']===$v?'selected':'' ?>><?= $v ?></option><?php endforeach; ?></select></div>
<div class="col-12"><label class="form-label">Reason</label><input class="form-control" name="reason" value="<?= e($row['reason']) ?>"></div>
<div class="col-12"><label class="form-label">Notes</label><textarea class="form-control" name="notes"><?= e($row['notes']) ?></textarea></div>
<div class="col-12"><button class="btn btn-primary">Update Appointment</button> <a class="btn btn-light" href="list.php">Cancel</a></div>
</div></form></div></div><?php include __DIR__ . '/../includes/footer.php'; ?>
