# Lab18Web

## Ainun Dwi Permana (312310013)

### Tugas mengerjakan latihan pada module dua belas Pemrograman Web

### Membuat AJAX Controller
```ssh
<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ArtikelModel;

class AjaxController extends Controller
{
    public function index()
    {
        $data = ['title' => 'Data Artikel'];
        return view('ajax/index', $data);
    }

    public function getData()
    {
        $model = new ArtikelModel();
        $data = $model->getArtikelDenganKategori(); // Pastikan method ini ada di model
        return $this->response->setJSON($data);
    }

    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);
        return $this->response->setJSON(['status' => 'OK']);
    }

    public function create()
    {
        $model = new ArtikelModel();
        $data = [
            'judul'  => $this->request->getPost('judul'),
            'isi'    => '', // Bisa diisi nanti jika ingin form lengkap
            'status' => $this->request->getPost('status')
        ];
        $model->insert($data);
        return $this->response->setJSON(['status' => 'OK']);
    }

    public function update($id)
    {
        $model = new ArtikelModel();
        $data = [
            'judul'  => $this->request->getPost('judul'),
            'isi'    => '', // Sama seperti create
            'status' => $this->request->getPost('status')
        ];
        $model->update($id, $data);
        return $this->response->setJSON(['status' => 'OK']);
    }
}

```

### Membuat View
```ssh
<?= $this->include('template/header'); ?>

<style>
    /* --- Gaya tampilan --- */
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f9fc;
        margin: 20px;
        color: #333;
    }
    h1 { color: #2c3e50; margin-bottom: 20px; }
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
    button:hover { background-color: #3498db; }
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
    tbody tr:hover { background-color: #f1f1f1; }
    #formContainer {
        background-color: white;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-radius: 6px;
        max-width: 400px;
    }
    label { display: block; margin-top: 10px; font-weight: bold; }
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
    #btnCancel:hover { background-color: #c0392b; }
</style>
<h1>Data Artikel</h1>

<table id="artikelTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<!-- Form Tambah/Ubah -->
<div id="formContainer" style="display:none; margin-top: 20px;">
    <h3 id="formTitle">Tambah Artikel</h3>
    <form id="artikelForm">
        <input type="hidden" name="id" id="artikelId" />
        <label for="judul">Judul:</label>
        <input type="text" name="judul" id="judul" required />
        <label for="status">Status:</label>
        <input type="text" name="status" id="status" required />
        <button type="submit">Simpan</button>
        <button type="button" id="btnCancel">Batal</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    function loadData() {
        $.ajax({
            url: "<?= base_url('ajax/getData') ?>",
            method: "GET",
            dataType: "json",
            success: function(data) {
                var rows = '';
                if (data.length > 0) {
                    data.forEach(function(item) {
                        rows += `<tr>
                                    <td>${item.id}</td>
                                    <td>${item.judul}</td>
                                    <td>${item.status}</td>
                                    <td>
                                        <button class="btnEdit" data-id="${item.id}" data-judul="${item.judul}" data-status="${item.status}">Edit</button>
                                        <button class="btnDelete" data-id="${item.id}">Delete</button>
                                    </td>
                                </tr>`;
                    });
                } else {
                    rows = '<tr><td colspan="4">Tidak ada data.</td></tr>';
                }
                $('#artikelTable tbody').html(rows);
            },
            error: function() {
                alert('Gagal mengambil data.');
            }
        });
    }

    loadData();

    $('#btnAdd').click(function() {
        $('#formTitle').text('Tambah Artikel');
        $('#artikelId').val('');
        $('#judul').val('');
        $('#status').val('');
        $('#formContainer').show();
    });

    $('#btnCancel').click(function() {
        $('#formContainer').hide();
    });

    $('#artikelForm').submit(function(e) {
        e.preventDefault();
        var id = $('#artikelId').val();
        var url = id ? "<?= base_url('ajax/update/') ?>" + id : "<?= base_url('ajax/create') ?>";
        $.ajax({
            url: url,
            method: "POST",
            data: {
                judul: $('#judul').val(),
                status: $('#status').val()
            },
            success: function() {
                alert('Data berhasil disimpan.');
                $('#formContainer').hide();
                loadData();
            },
            error: function() {
                alert('Gagal menyimpan data.');
            }
        });
    });

    $(document).on('click', '.btnEdit', function() {
        $('#formTitle').text('Edit Artikel');
        $('#artikelId').val($(this).data('id'));
        $('#judul').val($(this).data('judul'));
        $('#status').val($(this).data('status'));
        $('#formContainer').show();
    });

    $(document).on('click', '.btnDelete', function() {
        if (confirm('Yakin ingin menghapus artikel ini?')) {
            var id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('ajax/delete/') ?>" + id,
                method: "DELETE",
                success: function() {
                    alert('Data berhasil dihapus.');
                    loadData();
                },
                error: function() {
                    alert('Gagal menghapus data.');
                }
            });
        }
    });
});
</script>

<?= $this->include('template/footer'); ?>

```
![image](https://github.com/user-attachments/assets/f45e344c-467e-4f71-850c-66e8f3b621c4)
![image](https://github.com/user-attachments/assets/13ceb1f1-182e-4d4b-aad9-8cf0a55b281a)

### Pertanyaan dan Tugas
- Selesaikan programnya sesuai Langkah-langkah yang ada. Tambahkan fungsu untuk tambah dan ubah data. Anda boleh melakukan improvisasi.
```ssh
<?= $this->include('template/header'); ?>

<style>
    /* --- Gaya tampilan --- */
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f9fc;
        margin: 20px;
        color: #333;
    }
    h1 { color: #2c3e50; margin-bottom: 20px; }
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
    button:hover { background-color: #3498db; }
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
    tbody tr:hover { background-color: #f1f1f1; }
    #formContainer {
        background-color: white;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-radius: 6px;
        max-width: 400px;
    }
    label { display: block; margin-top: 10px; font-weight: bold; }
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
    #btnCancel:hover { background-color: #c0392b; }
</style>

<h1>Data Artikel</h1>
<button id="btnAdd">Tambah Artikel</button>

<table id="artikelTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<!-- Form Tambah/Ubah -->
<div id="formContainer" style="display:none; margin-top: 20px;">
    <h3 id="formTitle">Tambah Artikel</h3>
    <form id="artikelForm">
        <input type="hidden" name="id" id="artikelId" />
        <label for="judul">Judul:</label>
        <input type="text" name="judul" id="judul" required />
        <label for="status">Status:</label>
        <input type="text" name="status" id="status" required />
        <button type="submit">Simpan</button>
        <button type="button" id="btnCancel">Batal</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    function loadData() {
        $.ajax({
            url: "<?= base_url('ajax/getData') ?>",
            method: "GET",
            dataType: "json",
            success: function(data) {
                var rows = '';
                if (data.length > 0) {
                    data.forEach(function(item) {
                        rows += `<tr>
                                    <td>${item.id}</td>
                                    <td>${item.judul}</td>
                                    <td>${item.status}</td>
                                    <td>
                                        <button class="btnEdit" data-id="${item.id}" data-judul="${item.judul}" data-status="${item.status}">Edit</button>
                                        <button class="btnDelete" data-id="${item.id}">Delete</button>
                                    </td>
                                </tr>`;
                    });
                } else {
                    rows = '<tr><td colspan="4">Tidak ada data.</td></tr>';
                }
                $('#artikelTable tbody').html(rows);
            },
            error: function() {
                alert('Gagal mengambil data.');
            }
        });
    }

    loadData();

    $('#btnAdd').click(function() {
        $('#formTitle').text('Tambah Artikel');
        $('#artikelId').val('');
        $('#judul').val('');
        $('#status').val('');
        $('#formContainer').show();
    });

    $('#btnCancel').click(function() {
        $('#formContainer').hide();
    });

    $('#artikelForm').submit(function(e) {
        e.preventDefault();
        var id = $('#artikelId').val();
        var url = id ? "<?= base_url('ajax/update/') ?>" + id : "<?= base_url('ajax/create') ?>";
        $.ajax({
            url: url,
            method: "POST",
            data: {
                judul: $('#judul').val(),
                status: $('#status').val()
            },
            success: function() {
                alert('Data berhasil disimpan.');
                $('#formContainer').hide();
                loadData();
            },
            error: function() {
                alert('Gagal menyimpan data.');
            }
        });
    });

    $(document).on('click', '.btnEdit', function() {
        $('#formTitle').text('Edit Artikel');
        $('#artikelId').val($(this).data('id'));
        $('#judul').val($(this).data('judul'));
        $('#status').val($(this).data('status'));
        $('#formContainer').show();
    });

    $(document).on('click', '.btnDelete', function() {
        if (confirm('Yakin ingin menghapus artikel ini?')) {
            var id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('ajax/delete/') ?>" + id,
                method: "DELETE",
                success: function() {
                    alert('Data berhasil dihapus.');
                    loadData();
                },
                error: function() {
                    alert('Gagal menghapus data.');
                }
            });
        }
    });
});
</script>

<?= $this->include('template/footer'); ?>
```
![image](https://github.com/user-attachments/assets/47eb7beb-7815-4794-867e-d184571294fd)
![image](https://github.com/user-attachments/assets/07bb5b5e-918c-4efb-9de1-4d410226efba)
![image](https://github.com/user-attachments/assets/bf78ec98-b37e-4e27-b2b1-5f0acca0e43e)




