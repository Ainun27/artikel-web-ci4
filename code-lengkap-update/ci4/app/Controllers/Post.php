<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ArtikelModel;

class Post extends ResourceController
{
    use ResponseTrait;

    // Get all articles
    //public function index()
    //{
    //    $model = new ArtikelModel();
      //  $data['artikel'] = $model->orderBy('id', 'DESC')->findAll();
      //  return $this->respond($data);
    //}

    public function index()
    {
        // Tambahkan header CORS ini:
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        $data = [
            'artikel' => [
                ['id' => 1, 'judul' => 'Artikel 1', 'status' => 1],
                ['id' => 2, 'judul' => 'Artikel 2', 'status' => 0],
            ]
        ];

        return $this->respond($data);
    }

    // Create a new article
    public function create()
    {
        $model = new ArtikelModel();
        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi'   => $this->request->getVar('isi'),
        ];

        $model->insert($data);

        $response = [
            'status'  => 201,
            'error'   => null,
            'messages'=> [
                'success' => 'Data artikel berhasil ditambahkan.'
            ]
        ];

        return $this->respondCreated($response);
    }

    // Get a single article by ID
    public function show($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->where('id', $id)->first();

        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }

    // Update an existing article
    public function update($id = null)
    {
        $model = new ArtikelModel();
        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi'   => $this->request->getVar('isi'),
        ];

        $model->update($id, $data);

        $response = [
            'status'  => 200,
            'error'   => null,
            'messages'=> [
                'success' => 'Data artikel berhasil diubah.'
            ]
        ];

        return $this->respond($response);
    }

    // Delete an article
    public function delete($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->where('id', $id)->first();

        if ($data) {
            $model->delete($id);
            $response = [
                'status'  => 200,
                'error'   => null,
                'messages'=> [
                    'success' => 'Data artikel berhasil dihapus.'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }
}
