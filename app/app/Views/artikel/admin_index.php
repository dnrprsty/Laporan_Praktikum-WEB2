<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>
<section class="admin-card">
    <div class="toolbar">
        <form method="get" class="filter-form">
            <input type="text" name="q" value="<?= esc($q); ?>" placeholder="Cari judul atau isi artikel">
            <select name="kategori_id">
                <option value="">Semua kategori</option>
                <?php foreach ($kategori as $item): ?>
                    <option value="<?= esc($item['id_kategori']); ?>" <?= (string) $kategori_id === (string) $item['id_kategori'] ? 'selected' : ''; ?>>
                        <?= esc($item['nama_kategori']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <a class="btn btn-dark" href="<?= base_url('/admin/artikel/add'); ?>">Tambah Artikel</a>
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($artikel !== []): ?>
                    <?php foreach ($artikel as $row): ?>
                        <tr>
                            <td><?= esc($row['id']); ?></td>
                            <td>
                                <strong><?= esc($row['judul']); ?></strong>
                                <p class="table-subtext"><?= esc(character_limiter(strip_tags($row['isi']), 70)); ?></p>
                            </td>
                            <td><?= esc($row['nama_kategori'] ?? 'Tanpa kategori'); ?></td>
                            <td>
                                <span class="status-badge <?= (int) $row['status'] === 1 ? 'published' : 'draft'; ?>">
                                    <?= (int) $row['status'] === 1 ? 'Published' : 'Draft'; ?>
                                </span>
                            </td>
                            <td><?= esc(date('d M Y', strtotime((string) $row['created_at']))); ?></td>
                            <td class="table-actions">
                                <a class="btn btn-outline" href="<?= base_url('/admin/artikel/edit/' . $row['id']); ?>">Ubah</a>
                                <a class="btn btn-danger" href="<?= base_url('/admin/artikel/delete/' . $row['id']); ?>" onclick="return confirm('Yakin ingin menghapus artikel ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="empty-cell">Tidak ada data artikel.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pager-wrap">
        <?= $pager->only(['q', 'kategori_id'])->links(); ?>
    </div>
</section>
<?= $this->endSection(); ?>
