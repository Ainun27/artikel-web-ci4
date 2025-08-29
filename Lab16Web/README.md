# Lab16Web
## Ainun Dwi Permana (312310013)

### Tugas mengerjakan latihan pada module dua belas Pemrograman Web

#### membuat pagination
- buka Kembali Controller Artikel, kemudian modifikasi kode pada method admin_index seperti berikut.
```sh
public function admin_index()
{
  $title = 'Daftar Artikel';
  $model = new ArtikelModel();
  $data = [
  'title' => $title,
  'artikel' => $model->paginate(10), #data dibatasi 10 record per halaman
  'pager' => $model->pager,
  ];
  return view('artikel/admin_index', $data);
}
```

- Kemudian buka file views/artikel/admin_index.php dan tambahkan kode berikut dibawah deklarasi tabel data.
```sh
<?= $pager->links(); ?>
```

![alt text](https://github.com/Ainun27/artikel-web-ci4/blob/master/Lab16Web/1.png?raw=true)


#### Membuat Pencarian
- Pencarian data digunakan untuk memfilter data.
- Untuk membuat pencarian data, buka kembali Controller Artikel, pada method admin_index ubah kodenya seperti berikut

```sh
public function admin_index()
{
  $title = 'Daftar Artikel';
  $q = $this->request->getVar('q') ?? '';
  $model = new ArtikelModel();
  $data = [
  'title' => $title,
  'q' => $q,
  'artikel' => $model->like('judul', $q)->paginate(10), # data dibatasi 10 record per halaman
  'pager' => $model->pager,
  ];
  return view('artikel/admin_index', $data);
}
```

- Kemudian buka kembali file views/artikel/admin_index.php dan tambahkan form pencarian sebelum deklarasi tabel seperti berikut:
```sh
<form method="get" class="form-search">
<input type="text" name="q" value="<?= $q; ?>" placeholder="Cari data">
<input type="submit" value="Cari" class="btn btn-primary">
</form>
```
- Dan pada link pager ubah seperti berikut.
```sh
<?= $pager->only(['q'])->links(); ?>
```
![alt text](https://github.com/Ainun27/artikel-web-ci4/blob/master/Lab16Web/2.png?raw=true)
