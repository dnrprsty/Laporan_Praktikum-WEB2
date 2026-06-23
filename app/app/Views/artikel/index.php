<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>
<section class="section-block">
    <div class="section-heading">
        <div>
            <h2><?= esc($title); ?></h2>
            <p>Daftar artikel yang sudah dipublikasikan.</p>
        </div>
    </div>

    <?php if ($artikel !== []): ?>
        <div class="article-list">
            <?php foreach ($artikel as $row): ?>
                <article class="entry">
                    <img src="<?= media_url($row['gambar']); ?>" alt="<?= esc($row['judul']); ?>">
                    <div class="entry-content">
                        <p class="meta">
                            <?= esc($row['nama_kategori'] ?? 'Tanpa kategori'); ?> ·
                            <?= esc(date('d M Y', strtotime((string) $row['created_at']))); ?>
                        </p>
                        <h3>
                            <a href="<?= base_url('/artikel/' . $row['slug']); ?>">
                                <?= esc($row['judul']); ?>
                            </a>
                        </h3>
                        <p><?= esc(character_limiter(strip_tags($row['isi']), 180)); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="pager-wrap">
            <?= $pager->links(); ?>
        </div>
    <?php else: ?>
        <div class="empty-state">Belum ada artikel yang dipublikasikan.</div>
    <?php endif; ?>
</section>
<?= $this->endSection(); ?>
