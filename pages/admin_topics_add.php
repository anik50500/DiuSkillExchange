<?php
$courseId = (int)($_GET['course_id'] ?? 0);
$db = new JsonDb();
$course = $db->getById('courses', $courseId);
if (!$course) {
    flash('error', 'Course not found.');
    redirect('/admin/topics');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify()) {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $videoUrl = trim($_POST['video_url'] ?? '');
    $orderIndex = (int)($_POST['order_index'] ?? 0);
    if (!$title) {
        $error = 'Title is required.';
    } else {
        $db->insert('topics', [
            'course_id' => $courseId,
            'title' => $title,
            'content' => $content,
            'video_url' => $videoUrl ?: null,
            'order_index' => $orderIndex,
        ]);
        flash('success', 'Topic added.');
        redirect('/admin/topics?course_id=' . $courseId);
    }
    set_old($_POST);
}

$pageTitle = 'Admin - Add Topic';
$adminTitle = 'Add Topic';
require_once APP_DIR . '/includes/admin_header.php';
?>
<h2 class="section-title"><i class="bi bi-plus-lg"></i> Add topic — <?= e($course['title']) ?></h2>
<div class="card card-cse">
<div class="card-body">
<?php if ($error): ?>
<div class="alert alert-danger"><?= e($error) ?></div>
<?php endif; ?>
<form method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="course_id" value="<?= $courseId ?>">
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="<?= e(old('title')) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">YouTube video URL <span class="text-muted">(optional)</span></label>
        <input type="url" name="video_url" class="form-control" value="<?= e(old('video_url')) ?>" placeholder="https://www.youtube.com/watch?v=... or https://youtu.be/...">
        <small class="text-muted">Paste a YouTube watch or share link to embed the video in this topic.</small>
    </div>
    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea name="content" class="form-control" rows="6"><?= e(old('content')) ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Order index</label>
        <input type="number" name="order_index" class="form-control" value="<?= e(old('order_index', '0')) ?>">
    </div>
    <button type="submit" class="btn btn-cse">Save</button>
    <a href="<?= url('/admin/topics?course_id=' . $courseId) ?>" class="btn btn-outline-secondary">Cancel</a>
</form>
</div>
</div>
<?php require_once APP_DIR . '/includes/footer.php'; ?>
