<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'judul',
        'isi',
        'gambar',
        'status',
        'slug',
        'id_kategori',
    ];

    public function withKategori(): self
    {
        return $this
            ->select('artikel.*, kategori.nama_kategori, kategori.slug_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getLatestPublished(int $limit = 5): array
    {
        return $this
            ->withKategori()
            ->where('artikel.status', 1)
            ->orderBy('artikel.created_at', 'DESC')
            ->findAll($limit);
    }
}
