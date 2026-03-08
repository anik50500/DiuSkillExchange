<?php
$pageTitle = 'Admin Dashboard';
$adminTitle = 'Dashboard';
require_once APP_DIR . '/includes/admin_header.php';
$db = new JsonDb();
$coursesCount = count($db->getAll('courses'));
$usersCount = count($db->getAll('users'));
$enrollmentsCount = count($db->getAll('enrollments'));
?>
<h2 class="section-title"><i class="bi bi-speedometer2"></i> Dashboard</h2>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card card-cse h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-cse-light rounded-cse p-3"><i class="bi bi-journal-bookmark display-6 text-cse-primary"></i></div>
                <div>
                    <p class="text-muted small mb-0">Courses</p>
                    <p class="h3 mb-0 fw-bold"><?= $coursesCount ?></p>
                    <a href="<?= url('/admin/courses') ?>" class="small">Manage</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-cse h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-cse-light rounded-cse p-3"><i class="bi bi-people display-6 text-cse-primary"></i></div>
                <div>
                    <p class="text-muted small mb-0">Users</p>
                    <p class="h3 mb-0 fw-bold"><?= $usersCount ?></p>
                    <a href="<?= url('/admin/users') ?>" class="small">View</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-cse h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-cse-light rounded-cse p-3"><i class="bi bi-person-check display-6 text-cse-primary"></i></div>
                <div>
                    <p class="text-muted small mb-0">Enrollments</p>
                    <p class="h3 mb-0 fw-bold"><?= $enrollmentsCount ?></p>
                    <a href="<?= url('/admin/enrolled') ?>" class="small">View</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once APP_DIR . '/includes/footer.php'; ?>
