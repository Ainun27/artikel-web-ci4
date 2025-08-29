<?= $this->include('template/admin_header'); ?>

<h2><?= esc($title); ?></h2>

<form action="<?= site_url('admin/artikel/edit/' . $artikel['id']) ?>" method="post">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="judul">Judul</label>
        <input type="text" name="judul" id="judul" class="form-control"
               value="<?= old('judul', esc($artikel['judul'])) ?>" required>
    </div>

    <div class="form-group">
        <label for="isi">Isi</label>
        <textarea name="isi" id="isi" class="form-control" rows="8" required><?= old('isi', esc($artikel['isi'])) ?></textarea>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="1" <?= $artikel['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
            <option value="0" <?= $artikel['status'] == 0 ? 'selected' : '' ?>>Nonaktif</option>
        </select>
    </div>

    <div class="form-group">
        <label for="id_kategori">Kategori</label>
        <select name="id_kategori" id="id_kategori" class="form-control" required>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= esc($k['id_kategori']) ?>"
                    <?= $artikel['id_kategori'] == $k['id_kategori'] ? 'selected' : '' ?>>
                    <?= esc($k['nama_kategori']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="<?= site_url('admin/artikel') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->include('template/admin_footer'); ?>
