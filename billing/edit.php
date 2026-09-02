<?php
require_once __DIR__ . '/../includes/auth.php'; requireLogin(); require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
$id=(int)($_GET['id']??0);$s=$pdo->prepare("SELECT * FROM bills WHERE id=?");$s->execute([$id]);$row=$s->fetch();if(!$row)exit('Not found');$patients=$pdo->query("SELECT id,name FROM patients ORDER BY name")->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){ $vals=[(float)post('consultation_amount'),(float)post('room_amount'),(float)post('medicine_amount'),(float)post('test_amount'),(float)post('other_amount')];$total=array_sum($vals);
$s=$pdo->prepare("UPDATE bills SET patient_id=?,bill_date=?,consultation_amount=?,room_amount=?,medicine_amount=?,test_amount=?,other_amount=?,total_amount=?,payment_status=? WHERE id=?");
$s->execute([(int)post('patient_id'),post('bill_date'),...$vals,$total,post('payment_status'),$id]);redirectWithMessage('list.php','Bill updated.');}
$pageTitle='Edit Bill'; include __DIR__ . '/../includes/header.php';
?><div class="panel"><div class="p-4"><form method="post"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Patient</label><select class="form-select" name="patient_id"><?php foreach($patients as $p): ?><option value="<?= $p['id'] ?>" <?= $row['patient_id']==$p['id']?'selected':'' ?>><?= e($p['name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-3"><label class="form-label">Bill Date</label><input class="form-control" type="date" name="bill_date" value="<?= e($row['bill_date']) ?>"></div>
<div class="col-md-3"><label class="form-label">Status</label><select class="form-select" name="payment_status"><option <?= $row['payment_status']==='unpaid'?'selected':'' ?>>unpaid</option><option <?= $row['payment_status']==='paid'?'selected':'' ?>>paid</option></select></div>
<?php foreach(['consultation_amount'=>'Consultation','room_amount'=>'Room','medicine_amount'=>'Medicines','test_amount'=>'Tests','other_amount'=>'Other'] as $f=>$label): ?>
<div class="col-md-4"><label class="form-label"><?= $label ?></label><input class="form-control" name="<?= $f ?>" value="<?= e((string)$row[$f]) ?>"></div>
<?php endforeach; ?>
<div class="col-12"><button class="btn btn-primary">Update Bill</button> <a class="btn btn-light" href="list.php">Cancel</a></div></div></form></div></div><?php include __DIR__ . '/../includes/footer.php'; ?>
