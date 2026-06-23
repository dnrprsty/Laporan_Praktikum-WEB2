<div class="widget-box">
    <h3 class="title">Artikel Terkini</h3>

    <?php if ($artikel !== []): ?>
        <ul class="link-list">
            <?php foreach ($artikel as $row): ?>
                <li>
                    <a href="<?= base_url('/artikel/' . $row['slug']); ?>">
                        <?= esc($row['judul']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Belum ada artikel yang dipublikasikan.</p>
    <?php endif; ?>
</div>
