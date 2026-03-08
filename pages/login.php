<?php
if (Auth::isLoggedIn()) {
    redirect('/profile');
}
if (Auth::isAdmin()) {
    redirect('/admin');
}

$adminLogin = !empty($_GET['admin']);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify()) {
    if ($adminLogin) {
        $u = trim($_POST['username'] ?? '');
        $p = $_POST['password'] ?? '';
        if ($u && $p && Auth::loginAdmin($u, $p)) {
            redirect('/admin');
        }
        $error = 'Invalid username or password.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $p = $_POST['password'] ?? '';
        if ($email && $p && Auth::loginUser($email, $p)) {
            redirect('/profile');
        }
        $error = 'Invalid email or password.';
    }
}

$pageTitle = $adminLogin ? 'Admin Login' : 'Login';
require_once APP_DIR . '/includes/header.php';
?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card auth-card">
            <div class="card-body">
                <h2 class="card-title">
                    <?php if ($adminLogin): ?>
                    <i class="bi bi-shield-lock"></i> Admin Login
                    <?php else: ?>
                    <i class="bi bi-box-arrow-in-right"></i> Welcome back
                    <?php endif; ?>
                </h2>
                <?php if ($error): ?>
                <div class="alert alert-danger"><?= e($error) ?></div>
                <?php endif; ?>
                <form method="post" action="">
                    <?= csrf_field() ?>
                    <?php if ($adminLogin): ?>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= e(old('username')) ?>" required autofocus>
                    </div>
                    <?php else: ?>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= e(old('email')) ?>" required autofocus>
                    </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-cse w-100 py-2">Login</button>
                </form>
                <?php if ($adminLogin): ?>
                <p class="mt-4 mb-0 text-center small"><a href="<?= url('/login') ?>">User login</a></p>
                <?php else: ?>
                <p class="mt-4 mb-0 text-center small">New here? <a href="<?= url('/signup') ?>">Sign up</a> &middot; <a href="<?= url('/login?admin=1') ?>">Admin login</a></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php require_once APP_DIR . '/includes/footer.php'; ?>
