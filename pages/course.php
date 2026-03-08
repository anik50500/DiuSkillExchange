<?php
$id = (int)($_GET['id'] ?? 0);
$db = new JsonDb();
$course = $db->getById('courses', $id);
if (!$course) {
    flash('error', 'Course not found.');
    redirect('/courses');
}
$topics = $db->getWhere('topics', 'course_id', $id);
usort($topics, function ($a, $b) {
    return ($a['order_index'] ?? 0) - ($b['order_index'] ?? 0);
});
$enrolled = false;
if (Auth::isLoggedIn()) {
    $list = $db->getWhere('enrollments', 'user_id', Auth::userId());
    foreach ($list as $e) {
        if ((int)($e['course_id'] ?? 0) === (int)$id) {
            $enrolled = true;
            break;
        }
    }
}

$pageTitle = $course['title'];
require_once APP_DIR . '/includes/header.php';
?>
<nav aria-label="breadcrumb" class="breadcrumb-cse">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="<?= url('/courses') ?>">Courses</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= e($course['title']) ?></li>
    </ol>
</nav>
<div class="row">
    <div class="col-lg-8">
        <div class="card card-cse mb-4">
            <div class="card-body">
                <h1 class="page-title mb-2"><?= e($course['title']) ?></h1>
                <?php if ($enrolled): ?>
                <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-check-circle me-1"></i>Enrolled</span>
                <?php endif; ?>
                <?php if (!empty($course['description'])): ?>
                <p class="mt-3 text-muted"><?= nl2br(e($course['description'])) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($enrolled && !empty($topics)): ?>
        <h3 class="section-title"><i class="bi bi-list-check"></i> Course topics</h3>
        <div class="topic-list">
            <?php
            $progress = $db->getWhere('progress', 'user_id', Auth::userId());
            $doneIds = array_column($progress, 'topic_id');
            foreach ($topics as $t):
                $isDone = in_array((string)$t['id'], array_map('strval', $doneIds));
            ?>
            <a href="<?= url('/topic/' . $t['id']) ?>" class="topic-list-item <?= $isDone ? 'done' : '' ?>">
                <span class="icon-wrap"><?= $isDone ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-file-text"></i>' ?></span>
                <span class="flex-grow-1"><?= e($t['title']) ?></span>
                <?php if ($isDone): ?><i class="bi bi-check-circle-fill text-success"></i><?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>
        <p class="mt-3"><a href="<?= url('/my-courses') ?>" class="btn btn-outline-cse"><i class="bi bi-collection-play me-1"></i>My Courses</a></p>
        <?php endif; ?>
    </div>
    <div class="col-lg-4">
        <div class="card card-cse sticky-top" style="top: 1rem;">
            <div class="card-body">
                <p class="mb-2 text-muted small">Price</p>
                <p class="h4 text-cse-primary mb-0"><?= e(number_format($course['price_BDT'] ?? 0)) ?> BDT</p>
                <hr>
                <?php if ($enrolled): ?>
                <p class="mb-0 small text-muted">You have access to all <?= count($topics) ?> topic(s).</p>
                <?php elseif (Auth::isLoggedIn()): ?>
                <form method="post" action="<?= url('/enroll') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="course_id" value="<?= (int)$id ?>">
                    <button type="submit" class="btn btn-cse-accent w-100 py-2"><i class="bi bi-cart-plus me-2"></i>Enroll now</button>
                </form>
                <?php else: ?>
                <p class="mb-2 small">Login or sign up to enroll.</p>
                <a href="<?= url('/login') ?>" class="btn btn-cse w-100 py-2 me-1">Login</a>
                <a href="<?= url('/signup') ?>" class="btn btn-outline-cse w-100 py-2 mt-2">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php require_once APP_DIR . '/includes/footer.php'; ?>
