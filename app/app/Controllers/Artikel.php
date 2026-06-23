<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
    public function index(): string
    {
        $model = new ArtikelModel();

        $artikel = $model
            ->withKategori()
            ->where('artikel.status', 1)
            ->orderBy('artikel.created_at', 'DESC')
            ->paginate(6);

        return view('artikel/index', $this->pageData([
            'title'   => 'Daftar Artikel',
            'artikel' => $artikel,
            'pager'   => $model->pager,
        ]));
    }

    public function view(string $slug): string
    {
        $artikel = (new ArtikelModel())
            ->withKategori()
            ->where('artikel.slug', $slug)
            ->where('artikel.status', 1)
            ->first();

        if ($artikel === null) {
            throw PageNotFoundException::forPageNotFound('Artikel tidak ditemukan.');
        }

        return view('artikel/detail', $this->pageData([
            'title'   => $artikel['judul'],
            'artikel' => $artikel,
        ]));
    }

    public function admin_index(): string
    {
        $q = trim((string) $this->request->getGet('q'));
        $kategoriId = trim((string) $this->request->getGet('kategori_id'));

        $model = new ArtikelModel();
        $model->withKategori()->orderBy('artikel.created_at', 'DESC');

        if ($q !== '') {
            $model->groupStart()
                ->like('artikel.judul', $q)
                ->orLike('artikel.isi', $q)
                ->groupEnd();
        }

        if ($kategoriId !== '') {
            $model->where('artikel.id_kategori', (int) $kategoriId);
        }

        return view('artikel/admin_index', $this->pageData([
            'title'       => 'Daftar Artikel (Admin)',
            'q'           => $q,
            'kategori_id' => $kategoriId,
            'kategori'    => (new KategoriModel())->orderBy('nama_kategori', 'ASC')->findAll(),
            'artikel'     => $model->paginate(10),
            'pager'       => $model->pager,
        ]));
    }

    public function add()
    {
        $kategoriModel = new KategoriModel();
        $artikel = $this->emptyArtikel();

        if ($this->request->is('post')) {
            if ($this->validate($this->artikelRules())) {
                $model = new ArtikelModel();
                $judul = (string) $this->request->getPost('judul');

                $model->insert([
                    'judul'       => $judul,
                    'isi'         => (string) $this->request->getPost('isi'),
                    'slug'        => $this->buildSlug($judul),
                    'gambar'      => $this->normalizeImagePath((string) $this->request->getPost('gambar')),
                    'status'      => (int) $this->request->getPost('status'),
                    'id_kategori' => (int) $this->request->getPost('id_kategori'),
                ]);

                session()->setFlashdata('success', 'Artikel berhasil ditambahkan.');

                return redirect()->to('/admin/artikel');
            }

            $artikel = $this->request->getPost([
                'judul',
                'isi',
                'gambar',
                'status',
                'id_kategori',
            ]);
        }

        return view('artikel/form', $this->pageData([
            'title'      => 'Tambah Artikel',
            'mode'       => 'add',
            'artikel'    => array_merge($artikel, ['status' => $artikel['status'] ?? 1]),
            'kategori'   => $kategoriModel->orderBy('nama_kategori', 'ASC')->findAll(),
            'validation' => validation_list_errors(),
        ]));
    }

    public function edit(int $id)
    {
        $model = new ArtikelModel();
        $artikel = $model->find($id);

        if ($artikel === null) {
            throw PageNotFoundException::forPageNotFound('Artikel tidak ditemukan.');
        }

        if ($this->request->is('post')) {
            if ($this->validate($this->artikelRules())) {
                $judul = (string) $this->request->getPost('judul');

                $model->update($id, [
                    'judul'       => $judul,
                    'isi'         => (string) $this->request->getPost('isi'),
                    'slug'        => $this->buildSlug($judul, $id),
                    'gambar'      => $this->normalizeImagePath((string) $this->request->getPost('gambar')),
                    'status'      => (int) $this->request->getPost('status'),
                    'id_kategori' => (int) $this->request->getPost('id_kategori'),
                ]);

                session()->setFlashdata('success', 'Artikel berhasil diperbarui.');

                return redirect()->to('/admin/artikel');
            }

            $artikel = array_merge($artikel, $this->request->getPost([
                'judul',
                'isi',
                'gambar',
                'status',
                'id_kategori',
            ]));
        }

        return view('artikel/form', $this->pageData([
            'title'      => 'Edit Artikel',
            'mode'       => 'edit',
            'artikel'    => $artikel,
            'kategori'   => (new KategoriModel())->orderBy('nama_kategori', 'ASC')->findAll(),
            'validation' => validation_list_errors(),
        ]));
    }

    public function delete(int $id)
    {
        $model = new ArtikelModel();
        $artikel = $model->find($id);

        if ($artikel !== null) {
            $model->delete($id);
            session()->setFlashdata('success', 'Artikel berhasil dihapus.');
        }

        return redirect()->to('/admin/artikel');
    }

    /**
     * @return array<string, string>
     */
    private function artikelRules(): array
    {
        return [
            'judul'       => 'required|min_length[3]',
            'isi'         => 'required|min_length[20]',
            'id_kategori' => 'required|integer',
            'status'      => 'required|in_list[0,1]',
            'gambar'      => 'permit_empty|max_length[255]',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function emptyArtikel(): array
    {
        return [
            'judul'       => '',
            'isi'         => '',
            'gambar'      => 'placeholder.svg',
            'status'      => 1,
            'id_kategori' => '',
        ];
    }

    private function normalizeImagePath(string $path): string
    {
        $path = trim($path);

        return $path !== '' ? $path : 'placeholder.svg';
    }

    private function buildSlug(string $title, ?int $ignoreId = null): string
    {
        $model = new ArtikelModel();
        $baseSlug = url_title($title, '-', true);
        $slug = $baseSlug;
        $counter = 2;

        while (true) {
            $existing = $model->where('slug', $slug)->first();

            if ($existing === null || ($ignoreId !== null && (int) $existing['id'] === $ignoreId)) {
                return $slug;
            }

            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
    }
}
