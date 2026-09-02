<?php
require_once __DIR__ . '/includes/auth.php';
requireLogin();
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

function countRows(PDO $pdo, string $table, string $where = ''): int {
    return (int)$pdo->query("SELECT COUNT(*) FROM {$table} {$where}")->fetchColumn();
}

$stats = [
    ['Patients', countRows($pdo,'patients'), 'fa-hospital-user'],
    ['Doctors', countRows($pdo,'doctors'), 'fa-user-doctor'],
    ["Today's Appointments", countRows($pdo,'appointments',"WHERE appointment_date = CURDATE()"), 'fa-calendar-check'],
    ['Admitted', countRows($pdo,'admissions',"WHERE status = 'admitted'"), 'fa-bed-pulse'],
    ['Pending Bills', countRows($pdo,'bills',"WHERE payment_status = 'unpaid'"), 'fa-file-invoice-dollar'],
    ['Low Stock', countRows($pdo,'medicines',"WHERE stock_qty <= 10"), 'fa-pills'],
];

$appointments = $pdo->query("
SELECT a.*, p.name patient_name, d.name doctor_name
FROM appointments a
JOIN patients p ON p.id=a.patient_id
JOIN doctors d ON d.id=a.doctor_id
ORDER BY a.appointment_date DESC, a.appointment_time DESC LIMIT 6
")->fetchAll();

$patients = $pdo->query("SELECT * FROM patients ORDER BY id DESC LIMIT 6")->fetchAll();

$pageTitle='Dashboard';
include __DIR__ . '/includes/header.php';
?>
<div class="stat-grid mb-4">
<?php foreach ($stats as [$label,$value,$icon]): ?>
  <div class="stat-card">
    <div class="stat-icon"><i class="fa-solid <?= e($icon) ?>"></i></div>
    <h3><?= e((string)$value) ?></h3><p><?= e($label) ?></p>
  </div>
<?php endforeach; ?>
</div>

<div class="row g-4">
  <div class="col-xl-7">
    <div class="panel">
      <div class="panel-header"><div><h2 class="panel-title">Recent Appointments</h2><p class="panel-subtitle">Latest patient bookings</p></div>
      <a class="btn btn-sm btn-outline-secondary" href="appointments/list.php">View all</a></div>
      <div class="table-responsive">
        <table class="table"><thead><tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Status</th></tr></thead><tbody>
        <?php if (!$appointments): ?><tr><td colspan="4" class="empty-state">No appointments yet.</td></tr><?php endif; ?>
        <?php foreach($appointments as $a): ?><tr>
          <td><strong><?= e($a['patient_name']) ?></strong><br><small class="text-secondary"><?= e($a['reason']) ?></small></td>
          <td><?= e($a['doctor_name']) ?></td><td><?= e($a['appointment_date']) ?><br><small><?= e(substr($a['appointment_time'],0,5)) ?></small></td>
          <td><span class="badge text-bg-<?= statusClass($a['status']) ?>"><?= e(ucfirst($a['status'])) ?></span></td>
        </tr><?php endforeach; ?>
        </tbody></table>
      </div>
    </div>
  </div>
  <div class="col-xl-5">
    <div class="panel">
      <div class="panel-header"><div><h2 class="panel-title">New Patients</h2><p class="panel-subtitle">Recently registered</p></div>
      <a class="btn btn-sm btn-outline-secondary" href="patients/list.php">View all</a></div>
      <div class="table-responsive">
        <table class="table"><thead><tr><th>Patient</th><th>Phone</th><th>Blood</th></tr></thead><tbody>
        <?php if (!$patients): ?><tr><td colspan="3" class="empty-state">No patients yet.</td></tr><?php endif; ?>
        <?php foreach($patients as $p): ?><tr>
          <td><strong><?= e($p['name']) ?></strong><br><small class="text-secondary"><?= e($p['patient_code']) ?></small></td>
          <td><?= e($p['phone']) ?></td><td><span class="badge text-bg-light"><?= e($p['blood_group'] ?: '-') ?></span></td>
        </tr><?php endforeach; ?>
        </tbody></table>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
