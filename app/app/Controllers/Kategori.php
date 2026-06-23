<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Kategori extends BaseController
{
    public function index(): string
    {
        return view('kategori/index', $this->pageData([
            'title'    => 'Daftar Kategori',
            'kategori' => (new KategoriModel())->getWithArticleCount(),
        ]));
    }

    public function add()
    {
        $kategori = [
            'nama_kategori' => '',
            'slug_kategori' => '',
        ];

        if ($this->request->is('post')) {
            if ($this->validate($this->rules())) {
                $nama = trim((string) $this->request->getPost('nama_kategori'));
                $slugInput = trim((string) $this->request->getPost('slug_kategori'));

                (new KategoriModel())->insert([
                    'nama_kategori' => $nama,
                    'slug_kategori' => $this->buildSlug($slugInput !== '' ? $slugInput : $nama),
                ]);

                session()->setFlashdata('success', 'Kategori berhasil ditambahkan.');

                return redirect()->to('/admin/kategori');
            }

            $kategori = $this->request->getPost(['nama_kategori', 'slug_kategori']);
        }

        return view('kategori/form', $this->pageData([
            'title'      => 'Tambah Kategori',
            'mode'       => 'add',
            'kategori'   => $kategori,
            'validation' => validation_list_errors(),
        ]));
    }

    public function edit(int $id)
    {
        $model = new KategoriModel();
        $kategori = $model->find($id);

        if ($kategori === null) {
            throw PageNotFoundException::forPageNotFound('Kategori tidak ditemukan.');
        }

        if ($this->request->is('post')) {
            if ($this->validate($this->rules())) {
                $nama = trim((string) $this->request->getPost('nama_kategori'));
                $slugInput = trim((string) $this->request->getPost('slug_kategori'));

                $model->update($id, [
                    'nama_kategori' => $nama,
                    'slug_kategori' => $this->buildSlug($slugInput !== '' ? $slugInput : $nama, $id),
                ]);

                session()->setFlashdata('success', 'Kategori berhasil diperbarui.');

                return redirect()->to('/admin/kategori');
            }

            $kategori = array_merge($kategori, $this->request->getPost(['nama_kategori', 'slug_kategori']));
        }

        return view('kategori/form', $this->pageData([
            'title'      => 'Edit Kategori',
            'mode'       => 'edit',
            'kategori'   => $kategori,
            'validation' => validation_list_errors(),
        ]));
    }

    public function delete(int $id)
    {
        $artikelDipakai = (new ArtikelModel())->where('id_kategori', $id)->countAllResults();

        if ($artikelDipakai > 0) {
            session()->setFlashdata('error', 'Kategori tidak bisa dihapus karena masih dipakai oleh artikel.');

            return redirect()->to('/admin/kategori');
        }

        (new KategoriModel())->delete($id);
        session()->setFlashdata('success', 'Kategori berhasil dihapus.');

        return redirect()->to('/admin/kategori');
    }

    /**
     * @return array<string, string>
     */
    private function rules(): array
    {
        return [
            'nama_kategori' => 'required|min_length[3]',
            'slug_kategori' => 'permit_empty|alpha_dash|max_length[100]',
        ];
    }

    private function buildSlug(string $value, ?int $ignoreId = null): string
    {
        $model = new KategoriModel();
        $baseSlug = url_title($value, '-', true);
        $slug = $baseSlug;
        $counter = 2;

        while (true) {
            $existing = $model->where('slug_kategori', $slug)->first();

            if ($existing === null || ($ignoreId !== null && (int) $existing['id_kategori'] === $ignoreId)) {
                return $slug;
            }

            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
    }
}
