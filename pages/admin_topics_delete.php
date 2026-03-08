<?php
$id = (int)($_GET['id'] ?? 0);
$db = new JsonDb();
$topic = $db->getById('topics', $id);
if (!$topic) {
    flash('error', 'Topic not found.');
    redirect('/admin/topics');
}
$courseId = (int)$topic['course_id'];
$progressList = $db->getWhere('progress', 'topic_id', $id);
foreach ($progressList as $p) {
    $db->delete('progress', $p['id']);
}
$db->delete('topics', $id);
flash('success', 'Topic deleted.');
redirect('/admin/topics?course_id=' . $courseId);
