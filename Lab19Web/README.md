# Lab19Web

## Ainun Dwi Permana (312310013)

### Tugas mengerjakan latihan pada module dua belas Pemrograman Web

### Modifikasi Controller Artikel
- Ubah method `admin_index()` di `Artikel.php` untuk mengembalikan data dalam format JSON jika request adalah AJAX. (Sama seperti modul sebelumnya)
```ssh
public function admin_index()
{
    $title = 'Daftar Artikel (Admin)';
    $model = new ArtikelModel();

    $q = $this->request->getVar('q') ?? '';
    $kategori_id = $this->request->getVar('kategori_id') ?? '';
    $page = $this->request->getVar('page') ?? 1;

    $builder = $model->table('artikel')
        ->select('artikel.*, kategori.nama_kategori')
        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');

    if (!empty($q)) {
        $builder->like('artikel.judul', $q);
    }

    if (!empty($kategori_id)) {
        $builder->where('artikel.id_kategori', $kategori_id);
    }

    $artikel = $builder->paginate(10, 'default', $page);
    $pager = $model->pager;

    $data = [
        'title'       => $title,
        'q'           => $q,
        'kategori_id' => $kategori_id,
        'artikel'     => $artikel,
        'pager'       => $pager
    ];

    if ($this->request->isAJAX()) {
        return $this->response->setJSON($data);
    } else {
        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();
        return view('artikel/admin_index', $data);
    }
}

```

### Modifikasi View (admin_index.php)
- Ubah view `admin_index.php` untuk menggunakan jQuery.
- Hapus kode yang menampilkan tabel artikel dan pagination secara langsung.
- Tambahkan elemen untuk menampilkan data artikel dan pagination dari AJAX.
- Tambahkan kode jQuery untuk melakukan request AJAX.

```ssh
<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<div class="row mb-3">
    <div class="col-md-6">
        <form id="search-form" class="form-inline">
            <input type="text" name="q" id="search-box" value="<?= $q; ?>" 
                placeholder="Cari judul artikel" class="form-control mr-2" />

            <select name="kategori_id" id="category-filter" class="form-control mr-2">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id_kategori']; ?>" <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>>
                        <?= $k['nama_kategori']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Cari" class="btn btn-primary">
        </form>
    </div>
</div>

<div id="article-container"></div>
<div id="pagination-container"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    const articleContainer = $('#article-container');
    const paginationContainer = $('#pagination-container');
    const searchForm = $('#search-form');
    const searchBox = $('#search-box');
    const categoryFilter = $('#category-filter');

    const fetchData = (url) => {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (data) {
                renderArticles(data.artikel);
                renderPagination(data.pager, data.q, data.kategori_id);
            },
            error: function () {
                articleContainer.html('<div class="alert alert-danger">Gagal memuat data artikel.</div>');
            }
        });
    };

    const renderArticles = (articles) => {
        let html = '<table class="table">';
        html += `
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
        `;

        if (articles.length > 0) {
            articles.forEach(article => {
                html += `
                    <tr>
                        <td>${article.id}</td>
                        <td>
                            <b>${article.judul}</b>
                            <p><small>${article.isi.substring(0, 50)}</small></p>
                        </td>
                        <td>${article.nama_kategori}</td>
                        <td>${article.status}</td>
                        <td>
                            <a class="btn btn-sm btn-info" href="/admin/artikel/edit/${article.id}">Ubah</a>
                            <a class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus data?');" 
                               href="/admin/artikel/delete/${article.id}">Hapus</a>
                        </td>
                    </tr>
                `;
            });
        } else {
            html += '<tr><td colspan="5">Tidak ada data.</td></tr>';
        }

        html += '</tbody></table>';
        articleContainer.html(html);
    };

    const renderPagination = (pager, q, kategori_id) => {
        if (!pager.links || pager.links.length === 0) {
            paginationContainer.html('');
            return;
        }

        let html = '<nav><ul class="pagination">';
        pager.links.forEach(link => {
            let url = link.url ? `${link.url}&q=${q}&kategori_id=${kategori_id}` : '#';
            html += `<li class="page-item ${link.active ? 'active' : ''}">
                        <a class="page-link" href="${url}">${link.title}</a>
                     </li>`;
        });
        html += '</ul></nav>';
        paginationContainer.html(html);
    };

    searchForm.on('submit', function (e) {
        e.preventDefault();
        const q = searchBox.val();
        const kategori_id = categoryFilter.val();
        fetchData(`/admin/artikel?q=${encodeURIComponent(q)}&kategori_id=${encodeURIComponent(kategori_id)}`);
    });

    categoryFilter.on('change', function () {
        searchForm.trigger('submit');
    });

    // Load awal
    fetchData('/admin/artikel');
});
</script>

<?= $this->include('template/admin_footer'); ?>

```

### Tambahkan indikator loading saat data sedang diambil dari server.
```ssh
<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Artikel extends BaseController
{
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->getArtikelDenganKategori(); // Menggunakan method relasi
        return view('artikel/index', compact('artikel', 'title'));
    }

public function admin_index()
{
    $title = 'Daftar Artikel (Admin)';
    $model = new ArtikelModel();
    $q = $this->request->getVar('q') ?? '';
    $kategori_id = $this->request->getVar('kategori_id') ?? '';
    $sort_field = $this->request->getVar('sort_field') ?? '';
    $sort_dir = $this->request->getVar('sort_dir') ?? 'asc';
    $page = $this->request->getVar('page') ?? 1;

    $builder = $model->table('artikel')
        ->select('artikel.*, kategori.nama_kategori')
        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');

    if ($q != '') {
        $builder->like('artikel.judul', $q);
    }
    if ($kategori_id != '') {
        $builder->where('artikel.id_kategori', $kategori_id);
    }

    // Validasi field dan direction sorting supaya aman
    $allowedSortFields = ['id', 'judul', 'status', 'nama_kategori'];
    if (in_array($sort_field, $allowedSortFields)) {
        $sort_dir = strtolower($sort_dir) === 'desc' ? 'desc' : 'asc';

        // Jika sorting berdasarkan kolom dari join (kategori), gunakan alias
        if ($sort_field == 'nama_kategori') {
            $builder->orderBy('kategori.nama_kategori', $sort_dir);
        } else {
            $builder->orderBy('artikel.' . $sort_field, $sort_dir);
        }
    }

    $artikel = $builder->paginate(10, 'default', $page);
    $pager = $model->pager;

    $data = [
        'title' => $title,
        'q' => $q,
        'kategori_id' => $kategori_id,
        'artikel' => $artikel,
        'pager' => $pager
    ];

    if ($this->request->isAJAX()) {
        return $this->response->setJSON($data);
    } else {
        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();
        return view('artikel/admin_index', $data);
    }
}


    public function add()
{
    if ($this->request->getMethod() == 'post' && $this->validate([
        'judul'       => 'required',
        'id_kategori' => 'required|integer',
    ])) {
        $model = new ArtikelModel();
        $model->insert([
            'judul'       => $this->request->getPost('judul'),
            'isi'         => $this->request->getPost('isi'),
            'slug'        => url_title($this->request->getPost('judul'), '-', true),
            'id_kategori' => $this->request->getPost('id_kategori'),
        ]);
        return redirect()->to('/admin/artikel');
    } else {
        $kategoriModel     = new KategoriModel();
        $data['kategori']  = $kategoriModel->findAll();
        $data['title']     = "Tambah Artikel";
        return view('artikel/form_add', $data);
    }
}


    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);
        return redirect()->to('/admin/artikel');
    }

    public function view($slug)
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->where('slug', $slug)->first();

        if (empty($data['artikel'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the article.');
        }

        $data['title'] = $data['artikel']['judul'];
        return view('artikel/detail', $data);
    }
}
```
### Implementasikan fitur sorting (mengurutkan artikel berdasarkan judul, dll.) dengan AJAX.

```ssh
<?= $this->include('template/admin_header'); ?>

<h2><?= esc($title); ?></h2>

<div class="row mb-3">
    <div class="col-md-6">
        <form id="search-form" class="form-inline">
            <input type="text" name="q" id="search-box" value="<?= esc($q); ?>" placeholder="Cari judul artikel" class="form-control mr-2">
            
            <select name="kategori_id" id="category-filter" class="form-control mr-2">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= esc($k['id_kategori']); ?>" <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>>
                        <?= esc($k['nama_kategori']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Cari" class="btn btn-primary">
        </form>
    </div>
</div>

<div id="loading" style="display:none; margin-bottom:10px;">
    <strong>Loading data...</strong>
</div>

<div id="article-container">
    <!-- Data artikel akan dimuat di sini -->
</div>

<div id="pagination-container">
    <!-- Pagination akan dimuat di sini -->
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const articleContainer = $('#article-container');
    const paginationContainer = $('#pagination-container');
    const loadingIndicator = $('#loading');
    const searchForm = $('#search-form');
    const searchBox = $('#search-box');
    const categoryFilter = $('#category-filter');

    // State sorting
    let sortField = '<?= esc($sort_field); ?>';
    let sortDir = '<?= esc($sort_dir); ?>';

    function fetchData(url) {
        loadingIndicator.show();

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            success: function(data) {
                loadingIndicator.hide();
                renderArticles(data.artikel);
                renderPagination(data.pager, data.q, data.kategori_id);
            },
            error: function() {
                loadingIndicator.hide();
                articleContainer.html('<p class="text-danger">Gagal memuat data.</p>');
            }
        });
    }

    function renderArticles(articles) {
        let html = '<table class="table table-bordered">';
        html += '<thead><tr>';

        // Header dengan clickable sorting
        html += `<th><a href="#" class="sort" data-field="id">ID${sortField==='id' ? (sortDir==='asc' ? ' ▲' : ' ▼') : ''}</a></th>`;
        html += `<th><a href="#" class="sort" data-field="judul">Judul${sortField==='judul' ? (sortDir==='asc' ? ' ▲' : ' ▼') : ''}</a></th>`;
        html += `<th><a href="#" class="sort" data-field="nama_kategori">Kategori${sortField==='nama_kategori' ? (sortDir==='asc' ? ' ▲' : ' ▼') : ''}</a></th>`;
        html += `<th><a href="#" class="sort" data-field="status">Status${sortField==='status' ? (sortDir==='asc' ? ' ▲' : ' ▼') : ''}</a></th>`;
        html += '<th>Aksi</th>';
        html += '</tr></thead><tbody>';

        if (articles.length > 0) {
            articles.forEach(article => {
                html += `
                    <tr>
                        <td>${article.id}</td>
                        <td>
                            <b>${article.judul}</b>
                            <p><small>${article.isi ? article.isi.substring(0, 50) : ''}...</small></p>
                        </td>
                        <td>${article.nama_kategori}</td>
                        <td>${article.status == 1 ? 'Aktif' : 'Nonaktif'}</td>
                        <td>
                            <a class="btn btn-sm btn-info" href="/admin/artikel/edit/${article.id}">Ubah</a>
                            <a class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus data?');" href="/admin/artikel/delete/${article.id}">Hapus</a>
                        </td>
                    </tr>
                `;
            });
        } else {
            html += '<tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>';
        }

        html += '</tbody></table>';
        articleContainer.html(html);
    }

    function renderPagination(pager, q, kategori_id) {
        let html = '<nav><ul class="pagination">';
        pager.links.forEach(link => {
            let url = link.url ? `${link.url}&q=${encodeURIComponent(q)}&kategori_id=${kategori_id}&sort_field=${sortField}&sort_dir=${sortDir}` : '#';
            html += `<li class="page-item ${link.active ? 'active' : ''}"><a class="page-link" href="${url}">${link.title}</a></li>`;
        });
        html += '</ul></nav>';
        paginationContainer.html(html);
    }

    // Handle sorting click
    $(document).on('click', '.sort', function(e) {
        e.preventDefault();
        const field = $(this).data('field');
        if (sortField === field) {
            // Toggle direction
            sortDir = (sortDir === 'asc') ? 'desc' : 'asc';
        } else {
            sortField = field;
            sortDir = 'asc';
        }
        triggerFetch();
    });

    function triggerFetch() {
        const q = searchBox.val();
        const kategori_id = categoryFilter.val();
        const url = `/admin/artikel?q=${encodeURIComponent(q)}&kategori_id=${kategori_id}&sort_field=${sortField}&sort_dir=${sortDir}`;
        fetchData(url);
    }

    searchForm.on('submit', function(e) {
        e.preventDefault();
        triggerFetch();
    });

    categoryFilter.on('change', function() {
        triggerFetch();
    });

    // Pagination link AJAX handling
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url && url !== '#') {
            fetchData(url);
        }
    });

    // Load data awal
    triggerFetch();
});
</script>

<?= $this->include('template/admin_footer'); ?>
```
![Screenshot 2025-05-25 120630](https://github.com/user-attachments/assets/4ed2e0f7-a7e8-4b90-9e13-d5c7c0528065)
![Screenshot 2025-05-25 120656](https://github.com/user-attachments/assets/86bc9dea-e7e6-46da-9035-6bd5e4175959)
![Screenshot 2025-05-25 120703](https://github.com/user-attachments/assets/68e41e8f-4951-4e22-bbd2-8a2cd53621d9)
![Screenshot 2025-05-25 120713](https://github.com/user-attachments/assets/dcd1ebdc-e946-436e-a6eb-4121119325e3)
![Screenshot 2025-05-25 120732](https://github.com/user-attachments/assets/9b6d1e30-3f54-4c73-a07d-97138f1efae7)


