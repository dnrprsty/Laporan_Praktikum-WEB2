<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>
<section class="admin-card">
    <div class="section-heading">
        <h2><?= esc($title); ?></h2>
        <a href="<?= base_url('/admin/kategori'); ?>">Kembali ke daftar kategori</a>
    </div>

    <?php if ($validation): ?>
        <div class="alert alert-danger">
            <?= $validation; ?>
        </div>
    <?php endif; ?>

    <form method="post" class="stack-form">
        <label>
            <span>Nama Kategori</span>
            <input type="text" name="nama_kategori" value="<?= esc($kategori['nama_kategori'] ?? ''); ?>" required>
        </label>

        <label>
            <span>Slug Kategori</span>
            <input type="text" name="slug_kategori" value="<?= esc($kategori['slug_kategori'] ?? ''); ?>" placeholder="Opsional, akan dibuat otomatis jika kosong">
        </label>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $mode === 'add' ? 'Simpan Kategori' : 'Update Kategori'; ?></button>
            <a class="btn btn-outline" href="<?= base_url('/admin/kategori'); ?>">Batal</a>
        </div>
    </form>
</section>
<?= $this->endSection(); ?>
