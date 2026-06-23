<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin'); ?> | <?= esc($site->siteName); ?></title>
    <link rel="stylesheet" href="<?= base_url('style.css'); ?>">
</head>
<body class="admin-body">
    <div class="admin-shell">
        <header class="admin-header">
            <div>
                <p class="eyebrow">Dashboard Admin</p>
                <h1><?= esc($title ?? 'Panel Admin'); ?></h1>
            </div>
            <div class="admin-user">
                <span><?= esc((string) session()->get('user_name')); ?></span>
                <a class="btn btn-outline" href="<?= base_url('/'); ?>">Lihat Website</a>
                <a class="btn btn-dark" href="<?= base_url('/user/logout'); ?>">Logout</a>
            </div>
        </header>

        <nav class="admin-nav">
            <a href="<?= base_url('/admin/artikel'); ?>" class="<?= url_is('admin/artikel') ? 'active' : ''; ?>">Artikel</a>
            <a href="<?= base_url('/admin/kategori'); ?>" class="<?= url_is('admin/kategori') ? 'active' : ''; ?>">Kategori</a>
        </nav>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')); ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')); ?></div>
        <?php endif; ?>

        <main class="admin-main">
            <?= $this->renderSection('content'); ?>
        </main>
    </div>
</body>
</html>
