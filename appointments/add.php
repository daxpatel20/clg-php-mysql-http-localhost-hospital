<?php
require_once __DIR__ . '/../includes/auth.php'; requireLogin(); require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
$patients=$pdo->query("SELECT id,name,patient_code FROM patients ORDER BY name")->fetchAll();$doctors=$pdo->query("SELECT id,name,specialization FROM doctors WHERE status='active' ORDER BY name")->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){ $s=$pdo->prepare("INSERT INTO appointments(patient_id,doctor_id,appointment_date,appointment_time,reason,status,notes,created_at) VALUES(?,?,?,?,?,?,?,NOW())");
$s->execute([(int)post('patient_id'),(int)post('doctor_id'),post('appointment_date'),post('appointment_time'),post('reason'),post('status'),post('notes')]);redirectWithMessage('list.php','Appointment booked.');}
$pageTitle='Book Appointment'; include __DIR__ . '/../includes/header.php';
?><div class="panel"><div class="p-4"><form method="post"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Patient</label><select class="form-select" name="patient_id" required><option value="">Select patient</option><?php foreach($patients as $p): ?><option value="<?= $p['id'] ?>"><?= e($p['patient_code'].' - '.$p['name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-6"><label class="form-label">Doctor</label><select class="form-select" name="doctor_id" required><option value="">Select doctor</option><?php foreach($doctors as $d): ?><option value="<?= $d['id'] ?>"><?= e($d['name'].' - '.$d['specialization']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-3"><label class="form-label">Date</label><input class="form-control" type="date" name="appointment_date" required></div>
<div class="col-md-3"><label class="form-label">Time</label><input class="form-control" type="time" name="appointment_time" required></div>
<div class="col-md-3"><label class="form-label">Status</label><select class="form-select" name="status"><option>pending</option><option>confirmed</option><option>completed</option><option>cancelled</option></select></div>
<div class="col-md-12"><label class="form-label">Reason</label><input class="form-control" name="reason" required></div>
<div class="col-12"><label class="form-label">Notes</label><textarea class="form-control" name="notes"></textarea></div>
<div class="col-12"><button class="btn btn-primary">Book Appointment</button> <a class="btn btn-light" href="list.php">Cancel</a></div>
</div></form></div></div><?php include __DIR__ . '/../includes/footer.php'; ?>
