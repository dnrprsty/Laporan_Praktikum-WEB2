<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>
<section class="admin-card">
    <div class="section-heading">
        <h2><?= esc($title); ?></h2>
        <a href="<?= base_url('/admin/artikel'); ?>">Kembali ke daftar artikel</a>
    </div>

    <?php if ($validation): ?>
        <div class="alert alert-danger">
            <?= $validation; ?>
        </div>
    <?php endif; ?>

    <form method="post" class="stack-form">
        <label>
            <span>Judul</span>
            <input type="text" name="judul" value="<?= esc($artikel['judul'] ?? ''); ?>" required>
        </label>

        <label>
            <span>Isi Artikel</span>
            <textarea name="isi" rows="10" required><?= esc($artikel['isi'] ?? ''); ?></textarea>
        </label>

        <div class="form-grid">
            <label>
                <span>Kategori</span>
                <select name="id_kategori" required>
                    <option value="">Pilih kategori</option>
                    <?php foreach ($kategori as $item): ?>
                        <option value="<?= esc($item['id_kategori']); ?>" <?= (string) ($artikel['id_kategori'] ?? '') === (string) $item['id_kategori'] ? 'selected' : ''; ?>>
                            <?= esc($item['nama_kategori']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>
                <span>Status</span>
                <select name="status" required>
                    <option value="1" <?= (string) ($artikel['status'] ?? '1') === '1' ? 'selected' : ''; ?>>Published</option>
                    <option value="0" <?= (string) ($artikel['status'] ?? '1') === '0' ? 'selected' : ''; ?>>Draft</option>
                </select>
            </label>
        </div>

        <label>
            <span>Gambar</span>
            <input type="text" name="gambar" value="<?= esc($artikel['gambar'] ?? 'placeholder.svg'); ?>" placeholder="Contoh: placeholder.svg atau https://...">
            <small>Bisa diisi path file di folder public atau URL gambar eksternal.</small>
        </label>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $mode === 'add' ? 'Simpan Artikel' : 'Update Artikel'; ?></button>
            <a class="btn btn-outline" href="<?= base_url('/admin/artikel'); ?>">Batal</a>
        </div>
    </form>
</section>
<?= $this->endSection(); ?>
