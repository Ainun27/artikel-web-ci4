<?= $this->include('template/admin_header'); ?>

<h2><?= esc($title); ?></h2>

<!-- Form Tambah Artikel -->
 <div id="ajax-error" class="alert alert-danger" style="display:none;"></div>
<form action="<?= site_url('admin/artikel/add') ?>" method="post">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="judul">Judul</label>
        <input type="text" name="judul" id="judul" class="form-control"
               value="<?= old('judul') ?>" required>
    </div>

    <div class="form-group">
        <label for="isi">Isi</label>
        <textarea name="isi" id="isi" class="form-control" rows="8" required><?= old('isi') ?></textarea>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="1" <?= old('status') == '1' ? 'selected' : '' ?>>Aktif</option>
            <option value="0" <?= old('status') == '0' ? 'selected' : '' ?>>Nonaktif</option>
        </select>
    </div>

    <div class="form-group">
        <label for="id_kategori">Kategori</label>
        <select name="id_kategori" id="id_kategori" class="form-control" required>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= esc($k['id_kategori']) ?>"
                    <?= old('id_kategori') == $k['id_kategori'] ? 'selected' : '' ?>>
                    <?= esc($k['nama_kategori']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Tambah Artikel</button>
    <a href="<?= site_url('admin/artikel') ?>" class="btn btn-secondary">Kembali</a>
</form>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#form-artikel').on('submit', function(e) {
    e.preventDefault();

    const form = $(this);
    const url = form.attr('action');
    const data = form.serialize();

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'json',
        headers: {
            'X-Requested-With': 'XMLHttpRequest' // ✅ Wajib agar CI tahu ini AJAX!
        },
        success: function(response) {
    $('#ajax-error').hide(); // sembunyikan error sebelumnya

    if (response.success) {
        alert(response.message);
        window.location.href = '/admin/artikel?msg=added';
    } else {
        // tampilkan error dari server (misalnya listErrors())
        $('#ajax-error').html(response.message).show();
    }
},
        error: function(xhr) {
            alert('❌ Gagal kirim ke server.\n\n' + xhr.responseText);
            console.error(xhr.responseText);
        }
    });
});

</script>

<?= $this->include('template/admin_footer'); ?>
