<?php
require_once __DIR__ . '/../includes/auth.php'; requireLogin(); require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
$id=(int)($_GET['id']??0);$s=$pdo->prepare("SELECT * FROM departments WHERE id=?");$s->execute([$id]);$row=$s->fetch();if(!$row)exit('Not found');
if($_SERVER['REQUEST_METHOD']==='POST'){$s=$pdo->prepare("UPDATE departments SET department_name=?,description=? WHERE id=?");$s->execute([post('department_name'),post('description'),$id]);redirectWithMessage('list.php','Department updated.');}
$pageTitle='Edit Department'; include __DIR__ . '/../includes/header.php';
?><div class="panel"><div class="p-4"><form method="post"><div class="mb-3"><label class="form-label">Department Name</label><input class="form-control" name="department_name" value="<?= e($row['department_name']) ?>" required></div><div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description"><?= e($row['description']) ?></textarea></div><button class="btn btn-primary">Update</button> <a class="btn btn-light" href="list.php">Cancel</a></form></div></div><?php include __DIR__ . '/../includes/footer.php'; ?>
