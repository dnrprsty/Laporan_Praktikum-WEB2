<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>
<section class="content-card">
    <h2><?= esc($page['title']); ?></h2>
    <?php foreach ($page['paragraphs'] as $paragraph): ?>
        <p><?= esc($paragraph); ?></p>
    <?php endforeach; ?>
</section>
<?= $this->endSection(); ?>
