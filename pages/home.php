<?php
$pageTitle = 'Home';
require_once APP_DIR . '/includes/header.php';

$db = new JsonDb();
$courses = $db->getAll('courses');
$featured = array_slice($courses, 0, 3);
?>
<?php if ($msg = flash('success')): ?>
<div class="alert alert-success mb-4"><?= e($msg) ?></div>
<?php endif; ?>
<section class="hero-cse position-relative">
    <div class="position-relative">
        <h1 class="display-5">Learn skills. Share knowledge.</h1>
        <p class="lead">Browse campus courses, enroll with ease, and track your progress in one place.</p>
        <a class="btn btn-light btn-lg" href="<?= url('/courses') ?>"><i class="bi bi-book me-2"></i>Browse Courses</a>
    </div>
</section>
<?php if (!empty($featured)): ?>
<h2 class="section-title"><i class="bi bi-stars"></i> Featured Courses</h2>
<div class="row g-4 course-browse-grid">
    <?php foreach ($featured as $i => $c):
        $topicCount = count($db->getWhere('topics', 'course_id', $c['id']));
        $imgSeed = 'featured' . (int)$c['id'];
    ?>
    <div class="col-md-4 course-card-wrap" style="animation-delay: <?= $i * 0.12 ?>s">
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
<?php else: ?>
<div class="card card-cse">
    <div class="card-body text-center py-5">
        <i class="bi bi-book display-4 text-cse-primary mb-3"></i>
        <h3 class="h5 mb-2">No courses yet</h3>
        <p class="text-muted mb-0">Check back soon for new courses, or sign in as admin to add some.</p>
    </div>
</div>
<?php endif; ?>
<?php require_once APP_DIR . '/includes/footer.php'; ?>
