<?= $this->extend('layout/auth'); ?>

<?= $this->section('content'); ?>
<section class="login-card">
    <p class="eyebrow">Login Admin</p>
    <h1>Masuk ke Dashboard</h1>
    <p>Gunakan akun default untuk mengelola artikel dan kategori.</p>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')); ?></div>
    <?php endif; ?>

    <form method="post" class="stack-form">
        <label>
            <span>Email</span>
            <input type="email" name="email" placeholder="admin@email.com" required>
        </label>

        <label>
            <span>Password</span>
            <input type="password" name="password" placeholder="admin123" required>
        </label>

        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>

    <div class="login-hint">
        <strong>Akun default</strong>
        <span>Email: admin@email.com</span>
        <span>Password: admin123</span>
    </div>
</section>
<?= $this->endSection(); ?>
