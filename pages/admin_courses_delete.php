<?php
$id = (int)($_GET['id'] ?? 0);
$db = new JsonDb();
$course = $db->getById('courses', $id);
if (!$course) {
    flash('error', 'Course not found.');
    redirect('/admin/courses');
}
// Delete topics for this course
$topics = $db->getWhere('topics', 'course_id', $id);
foreach ($topics as $t) {
    $db->delete('topics', $t['id']);
    $progress = $db->getWhere('progress', 'topic_id', $t['id']);
    foreach ($progress as $p) {
        $db->delete('progress', $p['id']);
    }
}
$enrollments = $db->getWhere('enrollments', 'course_id', $id);
foreach ($enrollments as $e) {
    $db->delete('enrollments', $e['id']);
}
$db->delete('courses', $id);
flash('success', 'Course deleted.');
redirect('/admin/courses');
