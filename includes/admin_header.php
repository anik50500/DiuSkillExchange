<?php
$adminTitle = $adminTitle ?? 'Admin';
require_once APP_DIR . '/includes/header.php';
?>
<div class="admin-nav-pills">
    <a href="<?= url('/admin') ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="<?= url('/admin/courses') ?>"><i class="bi bi-journal-plus"></i> Courses</a>
    <a href="<?= url('/admin/topics') ?>"><i class="bi bi-list-check"></i> Topics</a>
    <a href="<?= url('/admin/users') ?>"><i class="bi bi-people"></i> Users</a>
    <a href="<?= url('/admin/enrolled') ?>"><i class="bi bi-person-check"></i> Enrolled</a>
    <a href="<?= url('/admin/progress') ?>"><i class="bi bi-graph-up"></i> Progress</a>
</div>
