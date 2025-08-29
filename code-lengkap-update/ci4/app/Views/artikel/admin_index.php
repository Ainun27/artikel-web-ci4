<?= $this->include('template/admin_header'); ?>

<h2><?= esc($title); ?></h2>

<!-- Tempat notifikasi -->
<div id="alert-container"></div>

<!-- Form pencarian & filter -->
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
    <div class="col-md-6 text-right">
        <a href="<?= base_url('/admin/artikel/add'); ?>" class="btn btn-tmb add-button">+ Tambah Artikel</a>
    </div>
</div>

<!-- Loading -->
<div id="loading" style="display:none; margin-bottom:10px;">
    <strong>Loading data...</strong>
</div>

<!-- Container tabel & pagination -->
<div id="article-container"></div>
<div id="pagination-container"></div>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    const articleContainer = $('#article-container');
    const paginationContainer = $('#pagination-container');
    const loadingIndicator = $('#loading');
    const searchForm = $('#search-form');
    const searchBox = $('#search-box');
    const categoryFilter = $('#category-filter');

    let sortField = <?= json_encode($sort_field ?? 'id'); ?>;
    let sortDir = <?= json_encode($sort_dir ?? 'asc'); ?>;

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
                renderPagination(data.pager.links, data.q, data.kategori_id);
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
                            <div class="btn-group-action">
                                <a class="btn btn-sm btn-info" href="/admin/artikel/edit/${article.id}">Ubah</a>
                                <a class="btn btn-sm btn-secondary" href="/admin/artikel/detail/${article.id}">Detail</a>
                                <a class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus data?');" href="/admin/artikel/delete/${article.id}">Hapus</a>
                            </div>
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

    function renderPagination(links, q, kategori_id) {
        let html = '<nav><ul class="pagination">';
        links.forEach(link => {
            let url = link.url ? `${link.url}&q=${encodeURIComponent(q)}&kategori_id=${kategori_id}&sort_field=${sortField}&sort_dir=${sortDir}` : '#';
            html += `<li class="page-item ${link.active ? 'active' : ''}"><a class="page-link" href="${url}">${link.title}</a></li>`;
        });
        html += '</ul></nav>';
        paginationContainer.html(html);
    }

    $(document).on('click', '.sort', function(e) {
        e.preventDefault();
        const field = $(this).data('field');
        if (sortField === field) {
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

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url && url !== '#') {
            fetchData(url);
        }
    });

    // Notifikasi dari URL (msg=)
    const urlParams = new URLSearchParams(window.location.search);
    const msg = urlParams.get('msg');
    if (msg === 'updated') {
        $('#alert-container').html(`<div class="alert alert-success">Artikel berhasil diperbarui.</div>`);
    } else if (msg === 'added') {
        $('#alert-container').html(`<div class="alert alert-success">Artikel berhasil ditambahkan.</div>`);
    } else if (msg === 'deleted') {
        $('#alert-container').html(`<div class="alert alert-success">Artikel berhasil dihapus.</div>`);
    }

    if (msg) {
        const cleanUrl = window.location.href.split('?')[0];
        window.history.replaceState({}, document.title, cleanUrl);
    }

    // Load awal
    triggerFetch();
});
</script>

<?= $this->include('template/admin_footer'); ?>
