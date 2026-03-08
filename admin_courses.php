<?php
$pageTitle = 'Admin - Courses';
$adminTitle = 'Courses';
require_once APP_DIR . '/includes/admin_header.php';
$db = new JsonDb();
$courses = $db->getAll('courses');
?>
<h2 class="section-title"><i class="bi bi-journal-plus"></i> Courses</h2>
<p><a href="<?= url('/admin/courses/add') ?>" class="btn btn-cse"><i class="bi bi-plus-lg me-2"></i>Add course</a></p>
<?php if (empty($courses)): ?>
<div class="card card-cse">
    <div class="card-body text-center py-5 text-muted">No courses yet. Add one to get started.</div>
</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-cse">
        <thead><tr><th>ID</th><th>Title</th><th>Price (BDT)</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($courses as $c): ?>
        <tr>
            <td><?= e($c['id']) ?></td>
            <td><?= e($c['title']) ?></td>
            <td><?= e(number_format($c['price_BDT'] ?? 0)) ?></td>
            <td>
                <a href="<?= url('/admin/courses/edit/' . $c['id']) ?>" class="btn btn-outline-cse btn-sm me-1">Edit</a>
                <a href="<?= url('/admin/courses/delete/' . $c['id']) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this course?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<?php require_once APP_DIR . '/includes/footer.php'; ?>
