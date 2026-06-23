<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>
<section class="content-card">
    <h2><?= esc($page['title']); ?></h2>
    <p><?= esc($page['intro']); ?></p>

    <div class="contact-list">
        <?php foreach ($page['details'] as $detail): ?>
            <div class="contact-item">
                <span><?= esc($detail['label']); ?></span>
                <strong><?= esc($detail['value']); ?></strong>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?= $this->endSection(); ?>
