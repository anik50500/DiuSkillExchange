<?php
$pageTitle = 'Courses';
require_once APP_DIR . '/includes/header.php';

$db = new JsonDb();
$courses = $db->getAll('courses');
?>
<h1 class="page-title"><i class="bi bi-book text-cse-primary me-2"></i>All Courses</h1>
<p class="page-subtitle">Choose a course and start learning.</p>
<?php if (empty($courses)): ?>
<div class="card card-cse">
    <div class="card-body text-center py-5">
        <i class="bi bi-inbox display-4 text-cse-primary mb-3"></i>
        <h3 class="h5 mb-2">No courses yet</h3>
        <p class="text-muted mb-0">Check back later for new courses.</p>
    </div>
</div>
<?php else: ?>
<div class="row g-4 course-browse-grid">
    <?php foreach ($courses as $i => $c):
        $topicCount = count($db->getWhere('topics', 'course_id', $c['id']));
        $imgSeed = 'course' . (int)$c['id'];
    ?>
    <div class="col-md-6 col-lg-4 course-card-wrap" style="animation-delay: <?= $i * 0.1 ?>s">
        <a href="<?= url('/course/' . $c['id']) ?>" class="text-decoration-none">
            <div class="card card-course card-course-anim">
                <div class="card-img-top card-course-img">
                    <img src="https://picsum.photos/seed/<?= e($imgSeed) ?>/600/280" alt="" loading="lazy">
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= e($c['title']) ?></h5>
                    <p class="badge-topic mb-2"><i class="bi bi-list-ul me-1"></i><?= $topicCount ?> topic<?= $topicCount !== 1 ? 's' : '' ?></p>
                    <p class="price-tag mb-0"><?= e(number_format($c['price_BDT'] ?? 0)) ?> BDT</p>
                    <span class="btn btn-outline-cse btn-sm mt-2">View course <i class="bi bi-arrow-right ms-1"></i></span>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php require_once APP_DIR . '/includes/footer.php'; ?>
