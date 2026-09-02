<?php
require_once __DIR__.'/../includes/auth.php'; requireLogin();
require_once __DIR__.'/../config/db.php'; require_once __DIR__.'/../includes/functions.php';
if(isset($_GET['delete'])){$id=(int)$_GET['delete'];$s=$pdo->prepare('DELETE FROM contact_messages WHERE id=?');$s->execute([$id]);redirectWithMessage('list.php','Enquiry deleted.');}
$rows=$pdo->query('SELECT * FROM contact_messages ORDER BY id DESC')->fetchAll();$pageTitle='Contact Enquiries';include __DIR__.'/../includes/header.php';
?>
<div class="panel"><div class="panel-header"><div><h2 class="panel-title">Website Contact Enquiries</h2><p class="panel-subtitle">Messages submitted from the public contact page</p></div></div><div class="table-responsive"><table class="table"><thead><tr><th>Name</th><th>Contact</th><th>Subject</th><th>Message</th><th>Date</th><th>Action</th></tr></thead><tbody><?php if(!$rows): ?><tr><td colspan="6" class="empty-state">No enquiries yet.</td></tr><?php endif; ?><?php foreach($rows as $r): ?><tr><td><strong><?= e($r['name']) ?></strong></td><td><?= e($r['email']) ?><br><small class="text-secondary"><?= e($r['phone']) ?></small></td><td><?= e($r['subject']) ?></td><td style="min-width:260px"><?= e($r['message']) ?></td><td><?= e($r['created_at']) ?></td><td><a class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this enquiry?')" href="?delete=<?= (int)$r['id'] ?>"><i class="fa-solid fa-trash"></i></a></td></tr><?php endforeach; ?></tbody></table></div></div>
<?php include __DIR__.'/../includes/footer.php'; ?>
