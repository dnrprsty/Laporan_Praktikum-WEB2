<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ArtikelSeeder extends Seeder
{
    public function run()
    {
        $kategoriMap = [];
        $kategoriRows = $this->db->table('kategori')->get()->getResultArray();

        foreach ($kategoriRows as $row) {
            $kategoriMap[$row['slug_kategori']] = $row['id_kategori'];
        }

        $items = [
            [
                'judul'       => 'Mengenal Konsep MVC di CodeIgniter 4',
                'slug'        => 'mengenal-konsep-mvc-di-codeigniter-4',
                'isi'         => 'Model, View, dan Controller membantu kita memisahkan logika aplikasi, tampilan, dan akses data. Dengan struktur ini, project lebih mudah dirawat dan dikembangkan ketika fitur mulai bertambah.',
                'gambar'      => 'placeholder.svg',
                'status'      => 1,
                'id_kategori' => $kategoriMap['framework'] ?? null,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-6 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-6 days')),
            ],
            [
                'judul'       => 'Cara Kerja Query Builder untuk Join Tabel',
                'slug'        => 'cara-kerja-query-builder-untuk-join-tabel',
                'isi'         => 'Query Builder memudahkan proses join antara tabel artikel dan kategori tanpa perlu menulis query SQL yang panjang. Hasilnya lebih aman, lebih rapi, dan lebih mudah dibaca saat praktikum.',
                'gambar'      => 'placeholder.svg',
                'status'      => 1,
                'id_kategori' => $kategoriMap['database'] ?? null,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-5 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-5 days')),
            ],
            [
                'judul'       => 'Menjalankan CodeIgniter 4 dengan Docker Compose',
                'slug'        => 'menjalankan-codeigniter-4-dengan-docker-compose',
                'isi'         => 'Docker Compose membantu menyalakan aplikasi dan database dalam satu perintah. Setup ini cocok untuk kebutuhan praktikum karena environment menjadi konsisten dan lebih mudah direplikasi.',
                'gambar'      => 'placeholder.svg',
                'status'      => 1,
                'id_kategori' => $kategoriMap['docker'] ?? null,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-4 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-4 days')),
            ],
            [
                'judul'       => 'Membuat Pagination Artikel di Halaman Admin',
                'slug'        => 'membuat-pagination-artikel-di-halaman-admin',
                'isi'         => 'Pagination berguna untuk membagi daftar artikel menjadi beberapa halaman. Saat data makin banyak, tabel admin tetap ringan dibuka dan pencarian terasa lebih nyaman digunakan.',
                'gambar'      => 'placeholder.svg',
                'status'      => 1,
                'id_kategori' => $kategoriMap['framework'] ?? null,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-3 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-3 days')),
            ],
            [
                'judul'       => 'Filter Artikel Berdasarkan Kategori',
                'slug'        => 'filter-artikel-berdasarkan-kategori',
                'isi'         => 'Filter kategori membantu admin melihat artikel tertentu dengan lebih cepat. Fitur ini dipadukan dengan form pencarian supaya proses pengelolaan data terasa lebih efisien.',
                'gambar'      => 'placeholder.svg',
                'status'      => 1,
                'id_kategori' => $kategoriMap['database'] ?? null,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
            [
                'judul'       => 'Draft Artikel untuk Uji Coba Status',
                'slug'        => 'draft-artikel-untuk-uji-coba-status',
                'isi'         => 'Artikel ini disimpan sebagai draft supaya kamu bisa melihat perbedaan tampilan data publik dan admin. Konten draft tidak akan tampil di halaman artikel publik.',
                'gambar'      => 'placeholder.svg',
                'status'      => 0,
                'id_kategori' => $kategoriMap['framework'] ?? null,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'judul'       => 'Menyusun Struktur View yang Mudah Dirawat',
                'slug'        => 'menyusun-struktur-view-yang-mudah-dirawat',
                'isi'         => 'Pemisahan layout, komponen, dan view halaman membuat tampilan lebih gampang diatur saat project mulai bertambah. Pendekatan ini cocok untuk kebutuhan praktikum maupun project portofolio.',
                'gambar'      => 'placeholder.svg',
                'status'      => 1,
                'id_kategori' => $kategoriMap['framework'] ?? null,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-12 hours')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-12 hours')),
            ],
            [
                'judul'       => 'Tips Menata Seeder agar Data Awal Konsisten',
                'slug'        => 'tips-menata-seeder-agar-data-awal-konsisten',
                'isi'         => 'Seeder yang rapi membuat aplikasi lebih cepat siap dipakai untuk demo, presentasi, atau screenshot laporan. Setiap kategori, user, dan artikel bisa dibuat terstruktur sejak awal.',
                'gambar'      => 'placeholder.svg',
                'status'      => 1,
                'id_kategori' => $kategoriMap['database'] ?? null,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-11 hours')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-11 hours')),
            ],
            [
                'judul'       => 'Membuat Halaman Contact yang Mudah Diganti',
                'slug'        => 'membuat-halaman-contact-yang-mudah-diganti',
                'isi'         => 'Konten statis seperti kontak, about, dan widget sidebar lebih nyaman diletakkan dalam file konfigurasi sederhana. Dengan begitu, perubahan isi tidak perlu membongkar banyak file view.',
                'gambar'      => 'placeholder.svg',
                'status'      => 1,
                'id_kategori' => $kategoriMap['framework'] ?? null,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-10 hours')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-10 hours')),
            ],
            [
                'judul'       => 'Cara Menambahkan Status Published dan Draft',
                'slug'        => 'cara-menambahkan-status-published-dan-draft',
                'isi'         => 'Status artikel membantu memisahkan konten yang siap tampil ke publik dan konten yang masih disiapkan. Fitur ini sederhana tetapi sangat berguna saat mengelola banyak artikel.',
                'gambar'      => 'placeholder.svg',
                'status'      => 1,
                'id_kategori' => $kategoriMap['database'] ?? null,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-9 hours')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-9 hours')),
            ],
            [
                'judul'       => 'Menghubungkan Form Admin dengan Validasi',
                'slug'        => 'menghubungkan-form-admin-dengan-validasi',
                'isi'         => 'Validasi pada form admin membantu menjaga data tetap rapi, misalnya judul tidak boleh kosong, kategori wajib dipilih, dan isi artikel harus cukup panjang untuk tampil layak.',
                'gambar'      => 'placeholder.svg',
                'status'      => 1,
                'id_kategori' => $kategoriMap['framework'] ?? null,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-8 hours')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-8 hours')),
            ],
            [
                'judul'       => 'Workflow Praktikum dari Migration sampai View',
                'slug'        => 'workflow-praktikum-dari-migration-sampai-view',
                'isi'         => 'Urutan kerja yang nyaman adalah: siapkan migration, jalankan seeder, buat model, sambungkan controller, lalu rapikan view. Dengan alur seperti ini, bug lebih cepat ditemukan dan diperbaiki.',
                'gambar'      => 'placeholder.svg',
                'status'      => 1,
                'id_kategori' => $kategoriMap['docker'] ?? null,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-7 hours')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-7 hours')),
            ],
        ];

        foreach ($items as $item) {
            $existing = $this->db->table('artikel')
                ->where('slug', $item['slug'])
                ->get()
                ->getFirstRow('array');

            if ($existing === null) {
                $this->db->table('artikel')->insert($item);
                continue;
            }

            $this->db->table('artikel')->where('id', $existing['id'])->update($item);
        }
    }
}
