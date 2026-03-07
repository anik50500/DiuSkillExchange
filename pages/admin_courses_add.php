<?php
$pageTitle = 'Admin - Add Course';
$adminTitle = 'Add Course';
require_once APP_DIR . '/includes/admin_header.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify()) {
    $title = trim($_POST['title'] ?? '');
    $price = (float)($_POST['price_BDT'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    if (!$title) {
        $error = 'Title is required.';
    } else {
        $db = new JsonDb();
        $db->insert('courses', [
            'title' => $title,
            'price_BDT' => $price,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s'),
            'admin_id' => Auth::adminId(),
        ]);
        flash('success', 'Course added.');
        redirect('/admin/courses');
    }
    set_old($_POST);
}
?>
<h2 class="section-title"><i class="bi bi-plus-lg"></i> Add course</h2>
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
            <button type="submit" class="btn btn-cse">Save</button>
            <a href="<?= url('/admin/courses') ?>" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</div>
<?php require_once APP_DIR . '/includes/footer.php'; ?>
