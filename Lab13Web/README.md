# Lab13Web
## Ainun Dwi Permana (312310013)

Tugas mengerjakan latihan pada module dua Pemrograman Web
       

#### Persiapan membuat dokumen HTML dengan nama file lab4_box.html seperti berikut.

### Membuat Layout Utama
- Buat folder layout di dalam app/Views/
- Buat file main.php di dalam folder layout dengan kode berikut:
```ssh
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $title ?? 'My Website' ?></title>
<link rel="stylesheet" href="<?= base_url('/style.css');?>">
</head>
<body>
<div id="container">
<header>
<h1>Layout Sederhana</h1>
</header>
<nav>
<a href="<?= base_url('/');?>" class="active">Home</a>
<a href="<?= base_url('/artikel');?>">Artikel</a>
<a href="<?= base_url('/about');?>">About</a>
<a href="<?= base_url('/contact');?>">Kontak</a>
</nav>
<section id="wrapper">
<section id="main">
<?= $this->renderSection('content') ?>
</section>
<aside id="sidebar">
<?= view_cell('App\\Cells\\ArtikelTerkini::render') ?>
<div class="widget-box">
<h3 class="title">Widget Header</h3>
<ul>
<li><a href="#">Widget Link</a></li>
<li><a href="#">Widget Link</a></li>
</ul>
</div>
<div class="widget-box">
<h3 class="title">Widget Text</h3>
<p>Vestibulum lorem elit, iaculis in nisl volutpat,
malesuada tincidunt arcu. Proin in leo fringilla,

vestibulum mi porta,

faucibus felis. Integer pharetra est nunc, nec pretium

nunc pretium ac.</p>
</div>
</aside>
</section>
<footer>
<p>&copy; 2021 - Universitas Pelita Bangsa</p>
</footer>
</div>
</body>
</html>
```
### Modifikasi File View
- Ubah app/Views/home.php agar sesuai dengan layout baru:
```ssh
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>
<?= $this->endSection() ?>
```
### Membuat Class View Cell
- Buat folder Cells di dalam app/
- Buat file ArtikelTerkini.php di dalam app/Cells/ dengan kode berikut:
```ssh
<?php
namespace App\Cells;
use CodeIgniter\View\Cell;
use App\Models\ArtikelModel;
class ArtikelTerkini extends Cell
{
public function render()
{
$model = new ArtikelModel();
$artikel = $model->orderBy('created_at', 'DESC')->limit(5)->findAll();
return view('components/artikel_terkini', ['artikel' => $artikel]);
}
}
```

### Membuat View untuk View Cell
- Buat folder components di dalam app/Views/
- Buat file artikel_terkini.php di dalam app/Views/components/ dengan kode berikut:
```ssh
<h3>Artikel Terkini</h3>
<ul>
<?php foreach ($artikel as $row): ?>
<li><a href="<?= base_url('/artikel/' . $row['slug']) ?>"><?=
$row['judul'] ?></a></li>
<?php endforeach; ?>
</ul>
```
![Screenshot 2025-04-24 133931](https://github.com/user-attachments/assets/49f7641a-eb97-40c2-81ea-4f85e0792d85)

