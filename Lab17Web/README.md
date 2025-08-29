# Lab17Web
## Ainun Dwi Permana (312310013)

Tugas mengerjakan latihan pada module dua Pemrograman Web

### Persiapan
- Pastikan MySQL Server sudah berjalan, dan buka database `lab_ci4
### Membuat Tabel Kategori
- Kita akan membuat tabel baru bernama `kategori` untuk mengkategorikan artikel.
```ssh
CREATE TABLE kategori (
 id_kategori INT(11) AUTO_INCREMENT,
 nama_kategori VARCHAR(100) NOT NULL,
 slug_kategori VARCHAR(100),
 PRIMARY KEY (id_kategori)
 )
```

### Mengubah Tabel Artikel
- Tambahkan foreign key `id_kategori` pada tabel `artikel` untuk membuat relasi dengan tabel `kategori`.
- Query untuk menambahkan foreign key:
```ssh
ALTER TABLE artikel
ADD COLUMN id_kategori INT(11),
ADD CONSTRAINT fk_kategori_artikel
FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori);
```

### Membuat Model Kategori
- Buat file model baru di `app/Models` dengan nama `KategoriModel.php`:
```ssh
<?php
namespace App\Models;
use CodeIgniter\Model;
class KategoriModel extends Model
{
 protected $table = 'kategori';
 protected $primaryKey = 'id_kategori';
 protected $useAutoIncrement = true;
 protected $allowedFields = [nama_kategori', 'slug_kategori'];
}
```

### Memodifikasi Model Artikel
- Modifikasi `ArtikelModel.php` untuk mendefinisikan relasi dengan `KategoriModel`:
```ssh
<?php
namespace App\Models;
use CodeIgniter\Model;
class ArtikelModel extends Model
{
protected $table = 'artikel';
protected $primaryKey = 'id';
protected $useAutoIncrement = true;
protected $allowedFields = ['judul', 'isi', 'status', 'slug', 'gambar',
'id_kategori'];
public function getArtikelDenganKategori()
{
 return $this->db->table('artikel')
 ->select('artikel.*, kategori.nama_kategori')
 ->join('kategori', 'kategori.id_kategori =
artikel.id_kategori')
->get()
 ->getResultArray();
 }
}
```

### Memodifikasi Controller Artikel
- Modifikasi `Artikel.php` untuk menggunakan model baru dan menampilkan data relasi:
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
        $title       = 'Daftar Artikel (Admin)';
        $model       = new ArtikelModel();
        $kategori_id = $this->request->getVar('kategori_id') ?? '';
        $q           = $this->request->getVar('q') ?? '';

        $data = [
            'title'       => $title,
            'q'           => $q,
            'kategori_id' => $kategori_id,
        ];

        // Build query with join ke kategori
        $builder = $model->table('artikel')
                        ->select('artikel.*, kategori.nama_kategori')
                        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');

        if ($q !== '') {
            $builder->like('artikel.judul', $q);
        }

        if ($kategori_id !== '') {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        $data['artikel'] = $builder->paginate(10);
        $data['pager']   = $model->pager;

        // Load semua kategori untuk dropdown filter
        $kategoriModel     = new KategoriModel();
        $data['kategori']  = $kategoriModel->findAll();

        return view('artikel/admin_index', $data);
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

### Memodifikasi View
- Buka folder view/artikel sesuaikan masing-masing view. index.php
```ssh
<?= $this->include('template/header'); ?>
<?php if ($artikel): foreach ($artikel as $row): ?>
<article class="entry">
<h2><a href="<?= base_url('/artikel/' . $row['slug']); ?>"><?=
$row['judul']; ?></a></h2>
<p>Kategori: <?= $row['nama_kategori'] ?></p>
<img src="<?= base_url('/gambar/' . $row['gambar']); ?>" alt="<?=
$row['judul']; ?>">
<p><?= substr($row['isi'], 0, 200); ?></p>
</article>
<hr class="divider" />
<?php endforeach; else: ?>
<article class="entry">
<h2>Belum ada data.</h2>
</article>
<?php endif; ?>
<?= $this->include('template/footer'); ?>
```

- admin_index.php
```ssh
<?= $this->include('template/header'); ?>

<?php if ($artikel): ?>
    <?php foreach ($artikel as $row): ?>
        <article class="entry">
            <h2>
                <a href="<?= base_url('/artikel/' . $row['slug']); ?>">
                    <?= esc($row['judul']); ?>
                </a>
            </h2>
            <p><strong>Kategori:</strong> <?= esc($row['nama_kategori']); ?></p>

            <?php if (!empty($row['gambar'])): ?>
                <img src="<?= base_url('/gambar/' . $row['gambar']); ?>" alt="<?= esc($row['judul']); ?>" style="max-width:100%; height:auto;">
            <?php endif; ?>

            <p><?= esc(substr(strip_tags($row['isi']), 0, 200)); ?>...</p>
        </article>
        <hr class="divider" />
    <?php endforeach; ?>
<?php else: ?>
    <article class="entry">
        <h2>Belum ada data.</h2>
    </article>
<?php endif; ?>

<?= $this->include('template/footer'); ?>
```

- form_add.php
```ssh
<?= $this->include('template/admin_header'); ?>

<h2><?= esc($title); ?></h2>

<form action="" method="post">
    <div class="form-group">
        <label for="judul">Judul</label>
        <input type="text" name="judul" id="judul" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="isi">Isi</label>
        <textarea name="isi" id="isi" class="form-control" cols="50" rows="10" required></textarea>
    </div>

    <div class="form-group">
        <label for="id_kategori">Kategori</label>
        <select name="id_kategori" id="id_kategori" class="form-control" required>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= esc($k['id_kategori']); ?>"><?= esc($k['nama_kategori']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <input type="submit" value="Kirim" class="btn btn-primary">
    </div>
</form>

<?= $this->include('template/admin_footer'); ?>
```

- form_edit.php
```ssh
<?= $this->include('template/admin_header'); ?>

<h2><?= esc($title); ?></h2>

<form action="" method="post">
    <div class="form-group">
        <label for="judul">Judul</label>
        <input type="text" name="judul" id="judul" class="form-control" 
                value="<?= esc($artikel['judul']); ?>" required>
    </div>

    <div class="form-group">
        <label for="isi">Isi</label>
        <textarea name="isi" id="isi" class="form-control" cols="50" rows="10" required>
            <?= esc($artikel['isi']); ?>
        </textarea>
    </div>

    <div class="form-group">
        <label for="id_kategori">Kategori</label>
        <select name="id_kategori" id="id_kategori" class="form-control" required>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= esc($k['id_kategori']); ?>" 
                        <?= ($artikel['id_kategori'] == $k['id_kategori']) ? 'selected' : ''; ?>>
                    <?= esc($k['nama_kategori']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <input type="submit" value="Kirim" class="btn btn-primary">
    </div>
</form>

<?= $this->include('template/admin_footer'); ?>
```

• Menampilkan daftar artikel dengan nama kategori.
![Screenshot 2025-05-13 114748](https://github.com/user-attachments/assets/612450bf-afcf-4297-97aa-2400c1481ffd)

• Menambah artikel baru dengan memilih kategori.
![Screenshot 2025-05-13 125723](https://github.com/user-attachments/assets/4acf003c-7375-4743-84d2-f939b6013a5a)

• Mengedit artikel dan mengubah kategorinya.
![Screenshot 2025-05-13 124323](https://github.com/user-attachments/assets/b1a189d6-ebbb-4384-bd03-bc526e797c81)

• Menghapus artikel.
![Screenshot 2025-05-13 124938](https://github.com/user-attachments/assets/a903e2e2-f708-4c50-bcae-fa75db111e88)

![Screenshot 2025-05-13 124949](https://github.com/user-attachments/assets/cf1c0f9b-3242-438d-a5bf-cd343419037e)

