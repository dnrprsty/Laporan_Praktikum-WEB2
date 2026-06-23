<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>
<section class="hero-card">
    <p class="eyebrow"><?= esc($page['eyebrow']); ?></p>
    <h2><?= esc($page['title']); ?></h2>
    <p class="lead"><?= esc($page['lead']); ?></p>

    <div class="hero-actions">
        <a class="btn btn-primary" href="<?= base_url('/artikel'); ?>">Lihat Artikel</a>
        <a class="btn btn-outline" href="<?= base_url('/admin/artikel'); ?>">Masuk Admin</a>
    </div>

    <div class="feature-list">
        <?php foreach ($page['highlights'] as $highlight): ?>
            <div class="feature-item"><?= esc($highlight); ?></div>
        <?php endforeach; ?>
    </div>
</section>

<section class="section-block">
    <div class="section-heading">
        <h3>Artikel Pilihan</h3>
        <a href="<?= base_url('/artikel'); ?>">Lihat semua</a>
    </div>

    <div class="article-grid">
        <?php foreach ($featuredArticles as $row): ?>
            <article class="article-card">
                <img src="<?= media_url($row['gambar']); ?>" alt="<?= esc($row['judul']); ?>">
                <div class="article-card-content">
                    <p class="meta"><?= esc($row['nama_kategori'] ?? 'Tanpa kategori'); ?></p>
                    <h4><a href="<?= base_url('/artikel/' . $row['slug']); ?>"><?= esc($row['judul']); ?></a></h4>
                    <p><?= esc(character_limiter(strip_tags($row['isi']), 130)); ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?= $this->endSection(); ?>
