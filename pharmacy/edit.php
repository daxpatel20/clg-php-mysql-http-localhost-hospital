<?php
require_once __DIR__ . '/../includes/auth.php'; requireLogin(); require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
$id=(int)($_GET['id']??0);$s=$pdo->prepare("SELECT * FROM medicines WHERE id=?");$s->execute([$id]);$row=$s->fetch();if(!$row)exit('Not found');
if($_SERVER['REQUEST_METHOD']==='POST'){ $s=$pdo->prepare("UPDATE medicines SET medicine_name=?,category=?,unit_price=?,stock_qty=?,expiry_date=?,status=? WHERE id=?");
$s->execute([post('medicine_name'),post('category'),(float)post('unit_price'),(int)post('stock_qty'),post('expiry_date')?:null,post('status'),$id]);redirectWithMessage('list.php','Medicine updated.');}
$pageTitle='Edit Medicine'; include __DIR__ . '/../includes/header.php';
?><div class="panel"><div class="p-4"><form method="post"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Medicine</label><input class="form-control" name="medicine_name" value="<?= e($row['medicine_name']) ?>"></div>
<div class="col-md-6"><label class="form-label">Category</label><input class="form-control" name="category" value="<?= e($row['category']) ?>"></div>
<div class="col-md-3"><label class="form-label">Price</label><input class="form-control" name="unit_price" value="<?= e((string)$row['unit_price']) ?>"></div>
<div class="col-md-3"><label class="form-label">Stock</label><input class="form-control" name="stock_qty" value="<?= e((string)$row['stock_qty']) ?>"></div>
<div class="col-md-3"><label class="form-label">Expiry</label><input class="form-control" type="date" name="expiry_date" value="<?= e($row['expiry_date']) ?>"></div>
<div class="col-md-3"><label class="form-label">Status</label><select class="form-select" name="status"><option <?= $row['status']==='active'?'selected':'' ?>>active</option><option <?= $row['status']==='inactive'?'selected':'' ?>>inactive</option></select></div>
<div class="col-12"><button class="btn btn-primary">Update Medicine</button> <a class="btn btn-light" href="list.php">Cancel</a></div></div></form></div></div><?php include __DIR__ . '/../includes/footer.php'; ?>
