<?= $this->include('template/header'); ?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f9fc;
        margin: 20px;
        color: #333;
    }
    h1 {
        color: #2c3e50;
        margin-bottom: 20px;
    }
    button {
        background-color: #2980b9;
        color: white;
        border: none;
        padding: 8px 15px;
        cursor: pointer;
        border-radius: 4px;
        font-size: 14px;
        margin-bottom: 15px;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #3498db;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-radius: 6px;
        overflow: hidden;
    }
    thead tr {
        background-color: #2980b9;
        color: white;
        text-align: left;
        font-weight: bold;
    }
    th, td {
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
    }
    tbody tr:hover {
        background-color: #f1f1f1;
    }
    #formContainer {
        background-color: white;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-radius: 6px;
        max-width: 400px;
        margin-top: 20px;
        display: none;
    }
    label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
    }
    input[type="text"], input[type="hidden"] {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    #btnCancel {
        background-color: #e74c3c;
        margin-left: 10px;
    }
    #btnCancel:hover {
        background-color: #c0392b;
    }
</style>

<h1>Data Artikel</h1>
<button id="btnAdd">Tambah Artikel</button>

<table id="artikelTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Isi</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<div id="formContainer">
    <h3 id="formTitle">Tambah Artikel</h3>
    <form id="artikelForm">
        <input type="hidden" name="id" id="artikelId" />
        
        <label for="judul">Judul:</label>
        <input type="text" name="judul" id="judul" required />
        
        <label for="isi">Isi:</label>
        <input type="text" name="isi" id="isi" required />
        
        <label for="status">Status:</label>
        <input type="text" name="status" id="status" required />

        <label for="id_kategori">Kategori:</label>
    <select name="id_kategori" id="id_kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <option value="1">Teknologi</option>
        <option value="2">Kesehatan</option>
        <!-- Tambahkan sesuai kategori yang kamu punya -->
    </select>
        
        <button type="submit">Simpan</button>
        <button type="button" id="btnCancel">Batal</button>
    </form>


</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    function loadData() {
        $.ajax({
            url: "<?= base_url('ajax/getData') ?>",
            method: "GET",
            dataType: "json",
            success: function (data) {
                var rows = '';
                if (data.length > 0) {
                    data.forEach(function (item) {
                        rows += `<tr>
                            <td>${item.id}</td>
                            <td>${item.judul}</td>
                            <td>${item.isi}</td>
                            <td>${item.status}</td>
                            <td>
                                <button class="btnEdit" 
                                    data-id="${item.id}" 
                                    data-judul="${item.judul}" 
                                    data-isi="${item.isi}" 
                                    data-status="${item.status}">Edit</button>
                                <button class="btnDelete" data-id="${item.id}">Delete</button>
                            </td>
                        </tr>`;
                    });
                } else {
                    rows = '<tr><td colspan="5">Tidak ada data.</td></tr>';
                }
                $('#artikelTable tbody').html(rows);
            },
            error: function () {
                alert('Gagal mengambil data.');
            }
        });
    }

    loadData();

    $('#btnAdd').click(function () {
        $('#formTitle').text('Tambah Artikel');
        $('#artikelId').val('');
        $('#judul').val('');
        $('#isi').val('');
        $('#status').val('');
        $('#formContainer').show();
    });

    $('#btnCancel').click(function () {
        $('#formContainer').hide();
    });

    $('#artikelForm').submit(function (e) {
    e.preventDefault();
    var id = $('#artikelId').val();
    var url = id ? "<?= base_url('ajax/update/') ?>" + id : "<?= base_url('ajax/create') ?>";

    $.ajax({
        url: url,
        method: "POST",
        data: {
            judul: $('#judul').val(),
            isi: $('#isi').val(),
            status: $('#status').val(),
            id_kategori: $('#id_kategori').val() // ← tambahkan ini
        },
        success: function () {
            alert('Data berhasil disimpan.');
            $('#formContainer').hide();
            loadData();
        },
        error: function () {
            alert('Gagal menyimpan data.');
        }
    });
});


    $(document).on('click', '.btnEdit', function () {
        $('#formTitle').text('Edit Artikel');
        $('#artikelId').val($(this).data('id'));
        $('#judul').val($(this).data('judul'));
        $('#isi').val($(this).data('isi'));
        $('#status').val($(this).data('status'));
        $('#formContainer').show();
    });

    $(document).on('click', '.btnDelete', function () {
        if (confirm('Yakin ingin menghapus artikel ini?')) {
            var id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('ajax/delete/') ?>" + id,
                method: "DELETE",
                success: function () {
                    alert('Data berhasil dihapus.');
                    loadData();
                },
                error: function () {
                    alert('Gagal menghapus data.');
                }
            });
        }
    });
});


</script>

<?= $this->include('template/footer'); ?>
