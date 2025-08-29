<?= $this->include('template/admin_header'); ?>

<style>
.detail-container {
    padding: 25px 30px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    line-height: 1.8;
    margin-bottom: 30px;
    font-family: 'Open Sans', sans-serif;
    color: #555;
}

.detail-container h2 {
    color: #2c3e50;
    font-size: 1.8rem;
    margin-bottom: 15px;
}

.detail-container .meta {
    font-size: 0.95rem;
    color: #888;
    margin-bottom: 20px;
}

.detail-container .content {
    font-size: 1.05rem;
    white-space: pre-line;
}

.btn-secondary {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 18px;
    background-color: #6c757d;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.btn-secondary:hover {
    background-color: #5a6268;
}
</style>

<div id="container">
    <div class="detail-container">
        <h2><?= esc($artikel['judul']); ?></h2>
        <div class="meta"><strong>Kategori:</strong> <?= esc($artikel['nama_kategori']); ?></div>
        <div class="content"><?= esc($artikel['isi']) ?></div>

        <a href="<?= site_url('/admin/artikel') ?>" >← Kembali ke Daftar Artikel</a>
    </div>
</div>

<?= $this->include('template/admin_footer'); ?>
