<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Login'); ?> | <?= esc($site->siteName); ?></title>
    <link rel="stylesheet" href="<?= base_url('style.css'); ?>">
</head>
<body class="auth-body">
    <main class="login-wrapper">
        <?= $this->renderSection('content'); ?>
    </main>
</body>
</html>
