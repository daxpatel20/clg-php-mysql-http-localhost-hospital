<?php
require_once __DIR__ . '/../includes/auth.php'; requireLogin();
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';

if (isset($_GET['delete'])) {
    $id=(int)$_GET['delete'];
    $stmt=$pdo->prepare("DELETE FROM doctors WHERE id=?"); $stmt->execute([$id]);
    redirectWithMessage('list.php','Record deleted successfully.');
}
$q = '%' . ($_GET['q'] ?? '') . '%';
$sql = "SELECT t.*, dep.department_name FROM doctors t LEFT JOIN departments dep ON dep.id=t.department_id";
$params=[];
if (isset($_GET['q']) && $_GET['q'] !== '') {
    $sql .= " WHERE t.name LIKE ? OR t.specialization LIKE ? OR t.phone LIKE ?";
    $params = [$q, $q, $q];
}
$sql .= " ORDER BY t.id DESC";
$stmt=$pdo->prepare($sql); $stmt->execute($params); $rows=$stmt->fetchAll();
$pageTitle='Doctors'; include __DIR__ . '/../includes/header.php';
?>
<div class="page-actions">
  <form class="search-box" method="get"><i class="fa-solid fa-magnifying-glass"></i><input class="form-control" name="q" value="<?= e($_GET['q'] ?? '') ?>" placeholder="Search doctors..."></form>
  <a class="btn btn-primary" href="add.php"><i class="fa-solid fa-plus me-2"></i>Add New</a>
</div>
<div class="panel"><div class="panel-header"><div><h2 class="panel-title">Doctors</h2><p class="panel-subtitle">Manage doctors records</p></div></div>
<div class="table-responsive"><table class="table"><thead><tr><th>Doctor</th><th>Department</th><th>Specialization</th><th>Phone</th><th>Fee</th><th>Status</th><th>Actions</th></tr></thead><tbody>
<?php if(!$rows): ?><tr><td colspan="7"><div class="empty-state"><i class="fa-solid fa-user-doctor"></i><div>No records found.</div></div></td></tr><?php endif; ?>
<?php foreach($rows as $row): ?><tr><td><?= e((string)($row['name'] ?? '')) ?></td><td><?= e((string)($row['department_name'] ?? '')) ?></td><td><?= e((string)($row['specialization'] ?? '')) ?></td><td><?= e((string)($row['phone'] ?? '')) ?></td><td><?= money($row['fee']) ?></td><td><span class="badge text-bg-<?= statusClass($row['status']) ?>"><?= e(ucfirst($row['status'])) ?></span></td>
<td class="text-nowrap"><a class="btn btn-sm btn-outline-primary" href="edit.php?id=<?= (int)$row['id'] ?>"><i class="fa-solid fa-pen"></i></a>
<a class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this record?')" href="?delete=<?= (int)$row['id'] ?>"><i class="fa-solid fa-trash"></i></a></td>
</tr><?php endforeach; ?></tbody></table></div></div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
