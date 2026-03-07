<?php
function e($s)
{
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function redirect($url, $code = 302)
{
    $url = BASE_URL . $url;
    header('Location: ' . $url, true, $code);
    exit;
}

function url($path)
{
    $path = ltrim($path, '/');
    return BASE_URL . '/' . $path;
}

function csrf_field()
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(16));
    }
    return '<input type="hidden" name="_csrf" value="' . e($_SESSION['_csrf']) . '">';
}

function csrf_verify()
{
    $token = $_POST['_csrf'] ?? '';
    return !empty($_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'], $token);
}

function flash($key, $msg = null)
{
    if ($msg !== null) {
        $_SESSION['_flash'][$key] = $msg;
        return null;
    }
    $v = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $v;
}

function old($key, $default = '')
{
    return $_SESSION['_old'][$key] ?? $default;
}

function set_old($data)
{
    $_SESSION['_old'] = $data;
}

function clear_old()
{
    unset($_SESSION['_old']);
}

/**
 * Extract YouTube video ID from common URL formats.
 * Returns the video ID or null if not a valid YouTube URL.
 */
function youtube_embed_id($url)
{
    if (empty($url) || !is_string($url)) {
        return null;
    }
    $url = trim($url);
    // youtube.com/watch?v=ID, youtube.com/embed/ID, youtu.be/ID
    if (preg_match('#(?:youtube\.com/watch\?v=|youtube\.com/embed/|youtu\.be/)([a-zA-Z0-9_-]{11})#', $url, $m)) {
        return $m[1];
    }
    return null;
}
