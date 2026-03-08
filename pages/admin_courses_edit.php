<?php
$id = (int)($_GET['id'] ?? 0);
$db = new JsonDb();
$course = $db->getById('courses', $id);
if (!$course) {
    flash('error', 'Course not found.');
    redirect('/admin/courses');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify()) {
    $title = trim($_POST['title'] ?? '');
    $price = (float)($_POST['price_BDT'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    if (!$title) {
        $error = 'Title is required.';
    } else {
        $db->update('courses', $id, [
            'title' => $title,
            'price_BDT' => $price,
            'description' => $description,
        ]);
        flash('success', 'Course updated.');
        redirect('/admin/courses');
    }
    set_old($_POST);
} else {
    set_old($course);
}

$pageTitle = 'Admin - Edit Course';
$adminTitle = 'Edit Course';
require_once APP_DIR . '/includes/admin_header.php';
?>
<h2 class="section-title"><i class="bi bi-pencil"></i> Edit course</h2>
<div class="card card-cse">
    <div class="card-body">
        <?php if ($error): ?>
        <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="<?= e(old('title')) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Price (BDT)</label>
                <input type="number" name="price_BDT" class="form-control" value="<?= e(old('price_BDT', '0')) ?>" min="0" step="0.01">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"><?= e(old('description')) ?></textarea>
            </div>
            <button type="submit" class="btn btn-cse">Update</button>
            <a href="<?= url('/admin/courses') ?>" class="btn btn-outline-secondary">Cancel</a>
        </form>
        <hr class="my-4">
        <a href="<?= url('/admin/topics?course_id=' . $id) ?>" class="btn btn-outline-cse btn-sm"><i class="bi bi-list-check me-1"></i>Manage topics</a>
    </div>
</div>
<?php require_once APP_DIR . '/includes/footer.php'; ?>
