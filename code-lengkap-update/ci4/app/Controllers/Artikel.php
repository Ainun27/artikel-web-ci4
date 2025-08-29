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
        $page = $this->request->getVar('page') ?? 1;

        $builder = $model->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');

        if ($q !== '') {
            $builder->like('artikel.judul', $q);
        }

        if ($kategori_id !== '') {
            $builder->where('artikel.id_kategori', $kategori_id);
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

    public function formAdd()
{
    $kategoriModel = new \App\Models\KategoriModel();
    return view('artikel/form_add', [
        'title' => 'Tambah Artikel',
        'kategori' => $kategoriModel->findAll(),
        'validation' => \Config\Services::validation()
    ]);
}

public function saveAdd()
{
    $validation = \Config\Services::validation();

    if (!$this->validate([
        'judul' => 'required',
        'isi' => 'required',
        'status' => 'required|in_list[0,1]',
        'id_kategori' => 'required|integer'
    ])) {
        return redirect()->back()->withInput()->with('validation', $validation);
    }

    $model = new \App\Models\ArtikelModel();
    $model->insert([
        'judul' => $this->request->getPost('judul'),
        'isi' => $this->request->getPost('isi'),
        'status' => $this->request->getPost('status'),
        'slug' => url_title($this->request->getPost('judul')),
        'id_kategori' => $this->request->getPost('id_kategori')
    ]);

    return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil ditambahkan');
}


    public function formEdit($id)
{
    $model = new \App\Models\ArtikelModel();
    $artikel = $model->find($id);

    if (!$artikel) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Artikel tidak ditemukan");
    }

    $kategoriModel = new \App\Models\KategoriModel();

    return view('artikel/form_edit', [
        'title' => 'Edit Artikel',
        'artikel' => $artikel,
        'kategori' => $kategoriModel->findAll(),
        'validation' => \Config\Services::validation()
    ]);
}

public function saveEdit($id)
{
    $validation = \Config\Services::validation();

    if (!$this->validate([
        'judul' => 'required',
        'isi' => 'required',
        'status' => 'required|in_list[0,1]',
        'id_kategori' => 'required|integer'
    ])) {
        return redirect()->back()->withInput()->with('validation', $validation);
    }

    $model = new \App\Models\ArtikelModel();
    $model->update($id, [
        'judul' => $this->request->getPost('judul'),
        'isi' => $this->request->getPost('isi'),
        'status' => $this->request->getPost('status'),
        'id_kategori' => $this->request->getPost('id_kategori'),
        'slug' => url_title($this->request->getPost('judul')),
    ]);

    return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil diperbarui');
}


   public function detail($id)
{
    $model = new \App\Models\ArtikelModel();
    
    // Ambil artikel beserta nama kategori
    $artikel = $model->select('artikel.*, kategori.nama_kategori')
        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
        ->where('artikel.id', $id)
        ->first();

    // Kalau artikel tidak ditemukan
    if (!$artikel) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan');
    }

    return view('artikel/detail', [
        'title' => 'Detail Artikel',
        'artikel' => $artikel
    ]);
}

public function detaill($id)
{
    $model = new \App\Models\ArtikelModel();
    $artikel = $model->select('artikel.*, kategori.nama_kategori')
        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
        ->where('artikel.id', $id)
        ->first();

    if (!$artikel) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan');
    }

    return view('artikel/detaill', [
        'title' => 'Detail Artikel',
        'artikel' => $artikel
    ]);
}




    public function view($slug)
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->where('slug', $slug)->first();

        if (empty($data['artikel'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan.');
        }

        $data['title'] = $data['artikel']['judul'];
        return view('artikel/detail', $data);
    }

     public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);
        return redirect()->to('/admin/artikel');
    }
}
