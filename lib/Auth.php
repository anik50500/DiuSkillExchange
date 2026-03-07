<?php
class Auth
{
    private static $db;

    public static function db()
    {
        if (self::$db === null) {
            self::$db = new JsonDb();
        }
        return self::$db;
    }

    public static function loginUser($email, $password)
    {
        $user = self::db()->getFirstWhere('users', 'email', $email);
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = 'user';
            $_SESSION['user_name'] = $user['name'] ?? $user['email'];
            return true;
        }
        return false;
    }

    public static function loginAdmin($username, $password)
    {
        $admin = self::db()->getFirstWhere('admins', 'username', $username);
        if ($admin && password_verify($password, $admin['password_hash'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['role'] = 'admin';
            $_SESSION['admin_username'] = $admin['username'];
            return true;
        }
        return false;
    }

    public static function logout()
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
    }

    public static function isLoggedIn()
    {
        return !empty($_SESSION['user_id']) && ($_SESSION['role'] ?? '') === 'user';
    }

    public static function isAdmin()
    {
        return !empty($_SESSION['admin_id']) && ($_SESSION['role'] ?? '') === 'admin';
    }

    public static function userId()
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function adminId()
    {
        return $_SESSION['admin_id'] ?? null;
    }

    public static function user()
    {
        $id = self::userId();
        return $id ? self::db()->getById('users', $id) : null;
    }

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
