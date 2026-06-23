<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $items = [
            ['nama_kategori' => 'Framework', 'slug_kategori' => 'framework'],
            ['nama_kategori' => 'Database', 'slug_kategori' => 'database'],
            ['nama_kategori' => 'Docker', 'slug_kategori' => 'docker'],
        ];

        foreach ($items as $item) {
            $existing = $this->db->table('kategori')
                ->where('slug_kategori', $item['slug_kategori'])
                ->get()
                ->getFirstRow('array');

            if ($existing === null) {
                $this->db->table('kategori')->insert($item);
                continue;
            }

            $this->db->table('kategori')->where('id_kategori', $existing['id_kategori'])->update($item);
        }
    }
}
