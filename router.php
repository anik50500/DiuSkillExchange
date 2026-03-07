<?php
/**
 * Router for PHP built-in server: php -S localhost:8000 router.php
 * Run from inside the App folder: php -S localhost:8000 router.php
 */
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = '/' . trim($uri, '/');

// Serve static files if they exist (assets, etc.)
$file = __DIR__ . $uri;
if ($uri !== '/' && $uri !== '' && file_exists($file) && !is_dir($file)) {
    return false;
}

require_once __DIR__ . '/config.php';

$path = trim($uri, '/') ?: 'home';
$path = preg_replace('#/+#', '/', $path);
$parts = explode('/', $path);

// Public routes
$public = [
    '' => 'home',
    'home' => 'home',
    'login' => 'login',
    'signup' => 'signup',
    'logout' => 'logout',
    'courses' => 'courses',
    'course' => 'course',
    'enroll' => 'enroll',
    'payment' => 'payment',
    'my-courses' => 'my_courses',
    'topic' => 'topic',
    'mark-complete' => 'mark_complete',
    'profile' => 'profile',
];
// Admin routes (require admin)
$admin = [
    'admin' => 'admin/dashboard',
    'admin/dashboard' => 'admin/dashboard',
    'admin/courses' => 'admin/courses',
    'admin/courses/add' => 'admin/courses_add',
    'admin/courses/edit' => 'admin/courses_edit',
    'admin/courses/delete' => 'admin/courses_delete',
    'admin/topics' => 'admin/topics',
    'admin/topics/add' => 'admin/topics_add',
    'admin/topics/edit' => 'admin/topics_edit',
    'admin/topics/delete' => 'admin/topics_delete',
    'admin/users' => 'admin/users',
    'admin/enrolled' => 'admin/enrolled',
    'admin/progress' => 'admin/progress',
];

$page = null;
if (isset($public[$path])) {
    $page = $public[$path];
} elseif (isset($admin[$path])) {
    if (!Auth::isAdmin()) {
        redirect('/login?admin=1');
    }
    $page = $admin[$path];
} elseif (count($parts) >= 2) {
    if ($parts[0] === 'course' && is_numeric($parts[1])) {
        $page = 'course';
        $_GET['id'] = $parts[1];
    } elseif ($parts[0] === 'topic' && is_numeric($parts[1])) {
        $page = 'topic';
        $_GET['id'] = $parts[1];
    } elseif ($parts[0] === 'admin' && $parts[1] === 'courses' && isset($parts[2])) {
        if (($parts[2] ?? '') === 'edit' && isset($parts[3]) && is_numeric($parts[3])) {
            $_GET['id'] = $parts[3];
            $page = 'admin/courses_edit';
        } elseif (($parts[2] ?? '') === 'delete' && isset($parts[3]) && is_numeric($parts[3])) {
            $_GET['id'] = $parts[3];
            $page = 'admin/courses_delete';
        }
    } elseif ($parts[0] === 'admin' && $parts[1] === 'topics') {
        if (isset($parts[2])) {
            if ($parts[2] === 'edit' && isset($parts[3]) && is_numeric($parts[3])) {
                $_GET['id'] = $parts[3];
                $page = 'admin/topics_edit';
            } elseif ($parts[2] === 'delete' && isset($parts[3]) && is_numeric($parts[3])) {
                $_GET['id'] = $parts[3];
                $page = 'admin/topics_delete';
            }
        }
    }
}

if ($page === null) {
    $page = 'home';
}

$file = __DIR__ . '/pages/' . str_replace('/', '_', $page) . '.php';
if (!file_exists($file)) {
    $file = __DIR__ . '/pages/home.php';
}
require $file;
