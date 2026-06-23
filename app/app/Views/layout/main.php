<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? $site->siteName); ?> | <?= esc($site->siteName); ?></title>
    <link rel="stylesheet" href="<?= base_url('style.css'); ?>">
</head>
<body>
    <div id="container">
        <header class="site-header">
            <div>
                <p class="eyebrow"><?= esc($site->siteName); ?></p>
                <h1><?= esc($site->tagline); ?></h1>
            </div>
            <div class="header-actions">
                <?php if (session()->get('logged_in')): ?>
                    <a class="btn btn-outline" href="<?= base_url('/admin/artikel'); ?>">Admin</a>
                    <a class="btn btn-dark" href="<?= base_url('/user/logout'); ?>">Logout</a>
                <?php else: ?>
                    <a class="btn btn-dark" href="<?= base_url('/user/login'); ?>">Login Admin</a>
                <?php endif; ?>
            </div>
        </header>

        <nav class="main-nav">
            <a href="<?= base_url('/'); ?>" class="<?= url_is('/') ? 'active' : ''; ?>">Home</a>
            <a href="<?= base_url('/artikel'); ?>" class="<?= url_is('artikel') ? 'active' : ''; ?>">Artikel</a>
            <a href="<?= base_url('/about'); ?>" class="<?= url_is('about') ? 'active' : ''; ?>">About</a>
            <a href="<?= base_url('/contact'); ?>" class="<?= url_is('contact') ? 'active' : ''; ?>">Kontak</a>
        </nav>

        <section id="wrapper">
            <main id="main">
                <?= $this->renderSection('content'); ?>
            </main>

            <aside id="sidebar">
                <?= view_cell('App\\Cells\\ArtikelTerkini::render'); ?>

                <div class="widget-box">
                    <h3 class="title"><?= esc($site->widgetTitle); ?></h3>
                    <ul class="link-list">
                        <?php foreach ($site->widgetLinks as $link): ?>
                            <li><a href="<?= esc($link['url']); ?>"><?= esc($link['label']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="widget-box">
                    <h3 class="title"><?= esc($site->widgetTextTitle); ?></h3>
                    <p><?= esc($site->widgetText); ?></p>
                </div>
            </aside>
        </section>

        <footer class="site-footer">
            <p>&copy; <?= date('Y'); ?> - <?= esc($site->footerText); ?></p>
        </footer>
    </div>
</body>
</html>
