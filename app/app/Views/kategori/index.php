<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>
<section class="admin-card">
    <div class="toolbar">
        <div class="section-heading">
            <div>
                <h2>Daftar Kategori</h2>
                <p>Kelola kategori untuk relasi artikel.</p>
            </div>
        </div>
        <a class="btn btn-dark" href="<?= base_url('/admin/kategori/add'); ?>">Tambah Kategori</a>
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Total Artikel</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($kategori !== []): ?>
                    <?php foreach ($kategori as $row): ?>
                        <tr>
                            <td><?= esc($row['id_kategori']); ?></td>
                            <td><?= esc($row['nama_kategori']); ?></td>
                            <td><?= esc($row['slug_kategori']); ?></td>
                            <td><?= esc($row['total_artikel']); ?></td>
                            <td class="table-actions">
                                <a class="btn btn-outline" href="<?= base_url('/admin/kategori/edit/' . $row['id_kategori']); ?>">Ubah</a>
                                <a class="btn btn-danger" href="<?= base_url('/admin/kategori/delete/' . $row['id_kategori']); ?>" onclick="return confirm('Yakin ingin menghapus kategori ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty-cell">Belum ada kategori.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?= $this->endSection(); ?>
