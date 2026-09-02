<?php
require_once __DIR__ . '/../includes/auth.php'; requireLogin(); require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
if($_SERVER['REQUEST_METHOD']==='POST'){ $stmt=$pdo->prepare("INSERT INTO departments(department_name,description,created_at) VALUES(?,?,NOW())"); $stmt->execute([post('department_name'),post('description')]); redirectWithMessage('list.php','Department added.');}
$pageTitle='Add Department'; include __DIR__ . '/../includes/header.php';
?><div class="panel"><div class="p-4"><form method="post"><div class="mb-3"><label class="form-label">Department Name</label><input class="form-control" name="department_name" required></div><div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description"></textarea></div><button class="btn btn-primary">Save</button> <a class="btn btn-light" href="list.php">Cancel</a></form></div></div><?php include __DIR__ . '/../includes/footer.php'; ?>
