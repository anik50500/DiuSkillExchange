<?php
$courseId = (int)($_GET['course_id'] ?? 0);
$db = new JsonDb();
$courses = $db->getAll('courses');
if ($courseId) {
    $course = $db->getById('courses', $courseId);
} else {
    $course = $courses[0] ?? null;
    if ($course) {
        $courseId = (int)$course['id'];
    }
}
$topics = [];
if ($courseId) {
    $topics = $db->getWhere('topics', 'course_id', $courseId);
    usort($topics, function ($a, $b) {
        return ($a['order_index'] ?? 0) - ($b['order_index'] ?? 0);
    });
}

$pageTitle = 'Admin - Topics';
$adminTitle = 'Topics';
require_once APP_DIR . '/includes/admin_header.php';
?>
<h2 class="section-title"><i class="bi bi-list-check"></i> Topics</h2>
<?php if (!empty($courses)): ?>
<form method="get" class="mb-4">
    <label class="form-label">Course</label>
    <select name="course_id" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
        <?php foreach ($courses as $c): ?>
        <option value="<?= (int)$c['id'] ?>" <?= (int)$c['id'] === $courseId ? 'selected' : '' ?>><?= e($c['title']) ?></option>
        <?php endforeach; ?>
    </select>
</form>
<?php endif; ?>
<?php if (!$courseId): ?>
<div class="card card-cse"><div class="card-body text-muted">Add a course first, then add topics.</div></div>
<?php else: ?>
<p><a href="<?= url('/admin/topics/add?course_id=' . $courseId) ?>" class="btn btn-cse"><i class="bi bi-plus-lg me-2"></i>Add topic</a></p>
<?php if (empty($topics)): ?>
<div class="card card-cse"><div class="card-body text-muted">No topics in this course.</div></div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-cse">
        <thead><tr><th>Order</th><th>Title</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($topics as $t): ?>
        <tr>
            <td><?= e($t['order_index'] ?? 0) ?></td>
            <td><?= e($t['title']) ?></td>
            <td>
                <a href="<?= url('/admin/topics/edit/' . $t['id']) ?>" class="btn btn-outline-cse btn-sm me-1">Edit</a>
                <a href="<?= url('/admin/topics/delete/' . $t['id']) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this topic?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<?php endif; ?>
<?php require_once APP_DIR . '/includes/footer.php'; ?>
