<?php
require_once __DIR__ . '/../includes/auth.php'; requireLogin(); require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
if($_SERVER['REQUEST_METHOD']==='POST'){ $s=$pdo->prepare("INSERT INTO medicines(medicine_name,category,unit_price,stock_qty,expiry_date,status) VALUES(?,?,?,?,?,?)");
$s->execute([post('medicine_name'),post('category'),(float)post('unit_price'),(int)post('stock_qty'),post('expiry_date')?:null,post('status')]);redirectWithMessage('list.php','Medicine added.');}
$pageTitle='Add Medicine'; include __DIR__ . '/../includes/header.php';
?><div class="panel"><div class="p-4"><form method="post"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Medicine Name</label><input class="form-control" name="medicine_name" required></div>
<div class="col-md-6"><label class="form-label">Category</label><input class="form-control" name="category"></div>
<div class="col-md-3"><label class="form-label">Unit Price</label><input class="form-control" type="number" step="0.01" name="unit_price"></div>
<div class="col-md-3"><label class="form-label">Stock Qty</label><input class="form-control" type="number" name="stock_qty"></div>
<div class="col-md-3"><label class="form-label">Expiry Date</label><input class="form-control" type="date" name="expiry_date"></div>
<div class="col-md-3"><label class="form-label">Status</label><select class="form-select" name="status"><option>active</option><option>inactive</option></select></div>
<div class="col-12"><button class="btn btn-primary">Save Medicine</button> <a class="btn btn-light" href="list.php">Cancel</a></div></div></form></div></div><?php include __DIR__ . '/../includes/footer.php'; ?>
