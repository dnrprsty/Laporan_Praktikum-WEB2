<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>
<article class="content-card article-detail">
    <p class="meta">
        <?= esc($artikel['nama_kategori'] ?? 'Tanpa kategori'); ?> ·
        <?= esc(date('d M Y', strtotime((string) $artikel['created_at']))); ?>
    </p>
    <h2><?= esc($artikel['judul']); ?></h2>
    <img src="<?= media_url($artikel['gambar']); ?>" alt="<?= esc($artikel['judul']); ?>">
    <div class="article-body">
        <?= nl2br(esc($artikel['isi'])); ?>
    </div>
</article>
<?= $this->endSection(); ?>
