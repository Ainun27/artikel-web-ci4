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
    $model = new \App\Models\ArtikelModel();

    $judul = $this->request->getPost('judul');
    $isi = $this->request->getPost('isi');
    $status = $this->request->getPost('status');
    $id_kategori = $this->request->getPost('id_kategori');

    if (!$judul || !$isi || !$id_kategori) {
        return $this->response->setStatusCode(400)->setJSON(['message' => 'Data tidak lengkap']);
    }

    $data = [
        'judul'       => $judul,
        'isi'         => $isi,
        'status'      => $status ?? 1,
        'slug'        => url_title($judul, '-', true),
        'gambar'      => null, // default
        'id_kategori' => $id_kategori
    ];

    if ($model->insert($data)) {
        return $this->response->setJSON(['status' => 'OK']);
    } else {
        return $this->response->setStatusCode(500)->setJSON([
            'message' => 'Gagal menyimpan',
            'errors' => $model->errors(),
        ]);
    }
}


    public function update($id)
    {
        $model = new ArtikelModel();
        $data = [
            'judul'  => $this->request->getPost('judul'),
            'isi'    => $this->request->getPost('isi'),
            'status' => $this->request->getPost('status')
        ];
        $model->update($id, $data);
        return $this->response->setJSON(['status' => 'OK']);
    }
}
