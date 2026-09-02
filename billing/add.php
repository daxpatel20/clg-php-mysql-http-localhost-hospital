<?php
require_once __DIR__ . '/../includes/auth.php'; requireLogin(); require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
$patients=$pdo->query("SELECT id,name FROM patients ORDER BY name")->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $vals=[(float)post('consultation_amount'),(float)post('room_amount'),(float)post('medicine_amount'),(float)post('test_amount'),(float)post('other_amount')];
  $total=array_sum($vals);
  $s=$pdo->prepare("INSERT INTO bills(patient_id,bill_date,consultation_amount,room_amount,medicine_amount,test_amount,other_amount,total_amount,payment_status) VALUES(?,?,?,?,?,?,?,?,?)");
  $s->execute([(int)post('patient_id'),post('bill_date'),...$vals,$total,post('payment_status')]);redirectWithMessage('list.php','Bill created.');
}
$pageTitle='Create Bill'; include __DIR__ . '/../includes/header.php';
?><div class="panel"><div class="p-4"><form method="post"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Patient</label><select class="form-select" name="patient_id"><?php foreach($patients as $p): ?><option value="<?= $p['id'] ?>"><?= e($p['name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-3"><label class="form-label">Bill Date</label><input class="form-control" type="date" name="bill_date" value="<?= date('Y-m-d') ?>"></div>
<div class="col-md-3"><label class="form-label">Payment Status</label><select class="form-select" name="payment_status"><option>unpaid</option><option>paid</option></select></div>
<div class="col-md-4"><label class="form-label">Consultation</label><input class="form-control" type="number" step="0.01" name="consultation_amount" value="0"></div>
<div class="col-md-4"><label class="form-label">Room</label><input class="form-control" type="number" step="0.01" name="room_amount" value="0"></div>
<div class="col-md-4"><label class="form-label">Medicines</label><input class="form-control" type="number" step="0.01" name="medicine_amount" value="0"></div>
<div class="col-md-4"><label class="form-label">Tests</label><input class="form-control" type="number" step="0.01" name="test_amount" value="0"></div>
<div class="col-md-4"><label class="form-label">Other</label><input class="form-control" type="number" step="0.01" name="other_amount" value="0"></div>
<div class="col-12"><button class="btn btn-primary">Create Bill</button> <a class="btn btn-light" href="list.php">Cancel</a></div></div></form></div></div><?php include __DIR__ . '/../includes/footer.php'; ?>
