<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class SiteContent extends BaseConfig
{
    public string $siteName = 'Portal Artikel Praktikum';
    public string $tagline = 'CodeIgniter 4, Query Builder, Pagination, dan Docker Compose';
    public string $footerText = 'Praktikum Web 2 - Universitas Pelita Bangsa';

    /**
     * @var array<string, mixed>
     */
    public array $pages = [
        'home' => [
            'eyebrow'   => 'Modul Web 2',
            'title'     => 'Aplikasi Artikel Relasi Kategori',
            'lead'      => 'Project ini menyatukan layout sederhana, CRUD artikel, relasi kategori, pencarian, filter, pagination, dan login admin dalam satu aplikasi CodeIgniter 4 yang dijalankan lewat Docker Compose.',
            'highlights' => [
                'Konten artikel dan kategori bisa diubah langsung dari halaman admin.',
                'Sidebar menampilkan artikel terbaru secara otomatis memakai View Cell.',
                'Struktur halaman dibuat sederhana supaya gampang dipelajari dan gampang dikustom.',
            ],
        ],
        'about' => [
            'title'      => 'Tentang Project',
            'paragraphs' => [
                'Aplikasi ini dibuat untuk mengikuti alur praktikum Web 2 mulai dari layout, CRUD, login, pencarian, pagination, sampai relasi tabel menggunakan Query Builder.',
                'Struktur kode dipisah dengan pola MVC bawaan CodeIgniter 4 agar lebih mudah dipahami saat presentasi, demo, maupun pengembangan lanjutan.',
            ],
        ],
        'contact' => [
            'title'   => 'Kontak',
            'intro'   => 'Data kontak di bawah ini bisa kamu ubah langsung lewat file konfigurasi supaya sesuai identitas kelas, kelompok, atau project kamu.',
            'details' => [
                ['label' => 'Email', 'value' => 'admin@email.com'],
                ['label' => 'Telepon', 'value' => '+62 812-3456-7890'],
                ['label' => 'Alamat', 'value' => 'Bekasi, Jawa Barat'],
            ],
        ],
    ];

    /**
     * @var array<int, array<string, string>>
     */
    public array $widgetLinks = [
        ['label' => 'Daftar Artikel', 'url' => '/artikel'],
        ['label' => 'Login Admin', 'url' => '/user/login'],
        ['label' => 'CodeIgniter 4 Docs', 'url' => 'https://codeigniter.com/user_guide/'],
    ];

    public string $widgetTitle = 'Widget Header';
    public string $widgetTextTitle = 'Catatan Praktikum';
    public string $widgetText = 'Bagian statis seperti judul website, deskripsi halaman, footer, dan widget sidebar bisa diubah dari Config/SiteContent.php tanpa perlu mengedit banyak view.';
}
