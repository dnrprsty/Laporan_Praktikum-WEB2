<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nama_kategori', 'slug_kategori'];

    /**
     * @return list<array<string, mixed>>
     */
    public function getWithArticleCount(): array
    {
        return $this
            ->select('kategori.*, COUNT(artikel.id) AS total_artikel')
            ->join('artikel', 'artikel.id_kategori = kategori.id_kategori', 'left')
            ->groupBy('kategori.id_kategori')
            ->orderBy('kategori.nama_kategori', 'ASC')
            ->findAll();
    }
}
