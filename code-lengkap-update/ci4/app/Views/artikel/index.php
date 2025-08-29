<?= $this->include('template/header'); ?>
<style>
.btn-detail {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 16px;
    background-color: #1f5faa;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 600;
    transition: background-color 0.3s ease;
}

.btn-detail:hover {
    background-color: #2b83ea;
}
</style>
<?php if ($artikel): foreach ($artikel as $row): ?>
<article class="entry">
    <h2><a href="<?= base_url('/artikel/' . $row['slug']); ?>">
        <?= esc($row['judul']); ?>
    </a></h2>

    <p class="meta">Kategori: 
        <strong><?= esc($row['nama_kategori'] ?? 'Tidak berkategori'); ?></strong>
    </p>

    <p class="preview">
        <?= esc(substr(strip_tags($row['isi']), 0, 100)); ?>...
        <a class="btn btn-sm btn-secondary" href="<?= base_url('/artikel/detaill/' . $row['id']) ?>">Detail</a>
    </p>
</article>
<hr class="divider" />
<?php endforeach; else: ?>
<article class="entry">
    <h2>Belum ada data.</h2>
</article>
<?php endif; ?>

<?= $this->include('template/footer'); ?>
