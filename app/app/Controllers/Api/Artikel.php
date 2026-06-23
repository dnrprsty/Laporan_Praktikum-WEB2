<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ArtikelModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $model = new ArtikelModel();
        $data = $model
            ->withKategori()
            ->orderBy('artikel.created_at', 'DESC')
            ->findAll();

        return $this->respond([
            'status'   => 200,
            'error'    => null,
            'data'     => $data,
        ], 200);
    }

    public function create()
    {
        $model = new ArtikelModel();
        $judul = (string) $this->request->getVar('judul');

        $model->insert([
            'judul'       => $judul,
            'isi'         => (string) $this->request->getVar('isi'),
            'slug'        => url_title($judul, '-', true),
            'gambar'      => $this->request->getVar('gambar') ?? 'placeholder.svg',
            'status'      => (int) ($this->request->getVar('status') ?? 1),
            'id_kategori' => (int) ($this->request->getVar('id_kategori') ?? 1),
        ]);

        return $this->respondCreated([
            'status'   => 201,
            'error'    => null,
            'messages' => 'Artikel berhasil ditambahkan.',
        ]);
    }

    public function update($id = null)
    {
        $model = new ArtikelModel();
        $artikel = $model->find($id);

        if ($artikel === null) {
            return $this->failNotFound('Artikel tidak ditemukan.');
        }

        $judul = (string) $this->request->getVar('judul');

        $model->update($id, [
            'judul'       => $judul,
            'isi'         => (string) $this->request->getVar('isi'),
            'slug'        => url_title($judul, '-', true),
            'gambar'      => $this->request->getVar('gambar') ?? 'placeholder.svg',
            'status'      => (int) ($this->request->getVar('status') ?? 1),
            'id_kategori' => (int) ($this->request->getVar('id_kategori') ?? 1),
        ]);

        return $this->respond([
            'status'   => 200,
            'error'    => null,
            'messages' => 'Artikel berhasil diperbarui.',
        ], 200);
    }

    public function delete($id = null)
    {
        $model = new ArtikelModel();
        $artikel = $model->find($id);

        if ($artikel === null) {
            return $this->failNotFound('Artikel tidak ditemukan.');
        }

        $model->delete($id);

        return $this->respondDeleted([
            'status'   => 200,
            'error'    => null,
            'messages' => 'Artikel berhasil dihapus.',
        ]);
    }
}
