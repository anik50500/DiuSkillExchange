<?php
$pageTitle = 'Admin - Users';
$adminTitle = 'Users';
require_once APP_DIR . '/includes/admin_header.php';
$db = new JsonDb();
$users = $db->getAll('users');
?>
<h2 class="section-title"><i class="bi bi-people"></i> Users</h2>
<?php if (empty($users)): ?>
<div class="card card-cse"><div class="card-body text-muted">No users yet.</div></div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-cse">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Joined</th></tr></thead>
        <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= e($u['id']) ?></td>
            <td><?= e($u['name'] ?? '') ?></td>
            <td><?= e($u['email'] ?? '') ?></td>
            <td><?= e($u['created_at'] ?? '') ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<?php require_once APP_DIR . '/includes/footer.php'; ?>
