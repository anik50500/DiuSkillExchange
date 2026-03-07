</main>
<footer class="footer-cse">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <span class="brand"><i class="bi bi-mortarboard-fill me-1"></i>Campus Skill Exchange</span>
                <span class="mx-2">·</span>
                <span>Learn, share, grow.</span>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="<?= url('/') ?>">Home</a>
                <span class="mx-2">·</span>
                <a href="<?= url('/courses') ?>">Courses</a>
                <span class="mx-2">·</span>
                <a href="<?= url('/login') ?>">Login</a>
                <span class="mx-2">·</span>
                &copy; <?= date('Y') ?>
            </div>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= url('assets/js/app.js') ?>"></script>
<?php if (!empty($extraScripts)) echo $extraScripts; ?>
</body>
</html>
