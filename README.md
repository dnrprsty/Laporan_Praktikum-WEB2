# Praktikum Web 2 - CodeIgniter 4 dengan Docker

## 🛠 Tech Stack
- **Backend**: CodeIgniter 4, PHP 8.x, MySQL 8.0
- **Frontend**: VueJS 3, Vue Router, Axios
- **Containerization**: Docker & Docker Compose
- **Package Manager**: Composer
- **Testing**: PHPUnit

Website portal artikel sederhana berbasis **CodeIgniter 4** dengan fitur CRUD lengkap, sistem autentikasi admin, relasi database, pencarian, filter, dan pagination. Proyek ini dikonfigurasi sepenuhnya dengan **Docker Compose** untuk kemudahan deployment dan dilengkapi dengan **frontend VueJS SPA** yang terintegrasi dengan REST API.

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Screenshots](#-screenshots)
- [Struktur Proyek](#-struktur-proyek)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Instalasi & Setup](#-instalasi--setup)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Akun Default](#-akun-default)
- [Dokumentasi Fitur](#-dokumentasi-fitur)
- [Endpoint API](#-endpoint-api)
- [Struktur Database](#-struktur-database)
- [Dokumentasi Praktikum](#-dokumentasi-praktikum)

---

## ✨ Fitur Utama

### Publik (Pengunjung)
- **Halaman Beranda** - Menampilkan 3 artikel terbaru yang dipublikasikan
- **Halaman Artikel** - Daftar semua artikel dengan pagination (6 artikel per halaman)
- **Detail Artikel** - Membaca artikel lengkap dengan nama kategori
- **Halaman About** - Informasi tentang website
- **Halaman Contact** - Formulir kontak
- **Sidebar Dinamis** - Menampilkan artikel terbaru menggunakan View Cell
- **Layout Responsif** - Header, navigasi, konten utama, sidebar, dan footer yang tertata rapi

### Admin (Terotentikasi)
- **Autentikasi Login** - System login dengan email dan password terenkripsi
- **Manajemen Artikel**
  - Create (tambah) artikel baru
  - Read (lihat) daftar semua artikel dengan pagination (10 per halaman)
  - Update (edit) artikel yang sudah dibuat
  - Delete (hapus) artikel
  - Pilih kategori artikel
  - Atur status `Published` (1) atau `Draft` (0)
  - Ganti sumber gambar artikel
  - Validasi input lengkap (judul min 3 karakter, isi min 20 karakter)

- **Pencarian & Filter Artikel**
  - Pencarian berdasarkan judul atau isi artikel
  - Filter berdasarkan kategori
  - Kombinasi pencarian dan filter

- **Manajemen Kategori**
  - Create (tambah) kategori baru
  - Read (lihat) daftar kategori dengan jumlah artikel
  - Update (edit) kategori
  - Delete (hapus) kategori dengan validasi (tidak bisa dihapus jika masih dipakai artikel)
  - Auto-generate slug dari nama kategori

- **Proteksi Akses** - Auth filter untuk melindungi semua endpoint admin

### Frontend SPA (VueJS)
- **Single Page Application** - Navigasi halus tanpa reload
- **Router Navigation** - Vue Router untuk manajemen rute
- **Dynamic Content** - Data diambil dari REST API backend
- **Responsive Design** - Layout yang menyesuaikan ukuran layar
- **State Management** - Menggunakan localStorage untuk session

---

## 📸 Screenshots

### Halaman Publik

#### 1. Beranda
Halaman depan website menampilkan artikel terbaru dan sidebar dinamis:

![Halaman Beranda](ss/01-beranda.png)

#### 2. Daftar Artikel Publik
Tampilan list semua artikel dengan pagination:

![Daftar Artikel](ss/02-daftar-artikel.png)

#### 3. Detail Artikel
Membaca artikel lengkap dengan kategori dan navigasi:

![Detail Artikel](ss/03-detail-artiker.png)

#### 4. Halaman About
Informasi tentang website:

![Halaman About](ss/04-about.png)

#### 5. Halaman Contact
Formulir kontak dengan informasi:

![Halaman Contact](ss/05-contact.png)

---

### Halaman Admin

#### 6. Login Admin
Form login dengan email dan password:

![Login Admin](ss/06-login-admin.png)

#### 7. Dashboard - Daftar Artikel
Interface admin untuk mengelola semua artikel dengan pencarian, filter, dan pagination:

![Dashboard Artikel](ss/07-admin-dashboard-artikel.png)

#### 8. Pencarian & Filter Artikel
Fitur pencarian by judul/isi dan filter by kategori:

![Pencarian & Filter](ss/08-admin-search-filter.png)

#### 9. Tambah Artikel
Form untuk membuat artikel baru:

![Tambah Artikel](ss/09-admin-tambah-artikel.png)

#### 10. Edit Artikel
Form untuk mengubah artikel yang sudah dibuat:

![Edit Artikel](ss/10-admin-edit-artikel.png)

#### 11. Daftar Kategori
Interface mengelola kategori dengan jumlah artikel:

![Daftar Kategori](ss/11-admin-daftar-kategori.png)

#### 12. Tambah/Edit Kategori
Form kategori dengan auto-generate slug:

![Tambah Kategori](ss/12-admin-tambah-kategori.png)

---

### Frontend SPA (VueJS)

#### 13. Frontend SPA - Beranda
Tampilan beranda di frontend VueJS SPA:

![Frontend Beranda](ss/13-frontend-beranda.png)

#### 14. Frontend SPA - Login
Form login di frontend VueJS SPA:

![Frontend Login](ss/14-frontend-login.png)

#### 15. Frontend SPA - Daftar Artikel
Tampilan daftar artikel di frontend SPA (terproteksi):

![Frontend Artikel](ss/15-frontend-artikel.png)

#### 16. Akses Ditolak (Navigation Guard)
Tampilan ketika akses ditolak karena belum login:

![Akses Ditolak](ss/16-akses-ditolak.png)

#### 17. API Test di Postman
Pengujian API tanpa token (401 Unauthorized):

![API Test Postman](ss/17-api-test-postman.png)

---

## 📁 Struktur Proyek

```
web2/
├── app/                              # Aplikasi CodeIgniter 4
│   ├── app/
│   │   ├── Config/                   # Konfigurasi aplikasi
│   │   │   ├── Routes.php           # Definisi routing
│   │   │   ├── App.php              # Konfigurasi umum
│   │   │   ├── Database.php         # Konfigurasi database
│   │   │   ├── Filters.php          # Filter middleware
│   │   │   ├── Cors.php             # CORS configuration
│   │   │   └── ... (config lainnya)
│   │   ├── Controllers/              # Controller handlers
│   │   │   ├── Home.php             # Halaman beranda
│   │   │   ├── Artikel.php          # Kelola artikel (publik & admin)
│   │   │   ├── Kategori.php         # Kelola kategori
│   │   │   ├── Page.php             # Halaman statis (about, contact)
│   │   │   ├── User.php             # Login & logout
│   │   │   ├── BaseController.php   # Base controller dengan helper method
│   │   │   └── Api/                 # API Controllers
│   │   │       ├── Auth.php         # API Auth login
│   │   │       └── Artikel.php      # API Artikel CRUD
│   │   ├── Models/                   # Database models
│   │   │   ├── ArtikelModel.php     # Model untuk tabel artikel
│   │   │   ├── KategoriModel.php    # Model untuk tabel kategori
│   │   │   └── UserModel.php        # Model untuk tabel user
│   │   ├── Views/                    # Template views
│   │   │   ├── layout/              # Layout utama
│   │   │   ├── pages/               # Halaman publik (home, about, contact)
│   │   │   ├── artikel/             # Views artikel (index, detail, admin, form)
│   │   │   ├── kategori/            # Views kategori (index, form)
│   │   │   ├── user/                # Views user (login)
│   │   │   ├── components/          # Komponen reusable
│   │   │   └── errors/              # Halaman error
│   │   ├── Database/
│   │   │   ├── Migrations/          # File migrasi database
│   │   │   │   ├── 2026-04-20-000001_CreateKategoriTable.php
│   │   │   │   ├── 2026-04-20-000002_CreateArtikelTable.php
│   │   │   │   └── 2026-04-20-000003_CreateUserTable.php
│   │   │   └── Seeds/               # Data seeder
│   │   ├── Filters/                  # Middleware filter
│   │   │   ├── Auth.php             # Filter autentikasi
│   │   │   └── ApiAuthFilter.php    # Filter API auth
│   │   ├── Cells/                    # View Cell components
│   │   │   └── ArtikelTerkini.php   # Cell untuk artikel terbaru
│   │   ├── Helpers/                  # Helper functions
│   │   ├── Libraries/                # Library tambahan
│   │   └── Common.php               # Helper function global
│   ├── public/                       # Public folder (document root)
│   │   ├── index.php                # Entry point aplikasi
│   │   ├── style.css                # Stylesheet publik
│   │   └── robots.txt
│   ├── vendor/                       # Composer dependencies
│   ├── writable/                     # Folder writable (cache, logs, session, uploads)
│   ├── tests/                        # Test files
│   ├── composer.json                # Composer configuration
│   ├── .env                         # Environment variables
│   └── ... (file konfigurasi lainnya)
├── frontend/                        # Frontend VueJS SPA
│   ├── index.html                   # Entry point SPA
│   ├── assets/
│   │   ├── css/
│   │   │   └── style.css           # Stylesheet SPA
│   │   └── js/
│   │       ├── app.js               # Vue router, guards, Axios interceptors
│   │       └── components/          # VueJS Components
│   │           ├── Home.js           # Halaman beranda
│   │           ├── Artikel.js       # Daftar artikel (terproteksi)
│   │           └── Login.js         # Form login
├── docker/                          # Docker configuration
│   ├── vhost.conf                   # Apache virtual host config
│   └── start-ci.sh                  # Startup script
├── Dockerfile                       # Docker image configuration
├── docker-compose.yml               # Docker Compose configuration
├── ss/                              # Folder screenshots
│   ├── 01-beranda.png
│   ├── 02-daftar-artikel.png
│   └── ... (screenshot lainnya)
└── README.md                        # File dokumentasi ini
```

---

## 🛠 Teknologi yang Digunakan

| Komponen | Teknologi | Versi |
|----------|-----------|-------|
| **Backend Framework** | CodeIgniter | 4 |
| **Backend Language** | PHP | 8.x |
| **Database** | MySQL | 8.0 |
| **Web Server** | Apache | Built-in |
| **Frontend Framework** | VueJS | 3 |
| **Frontend Router** | Vue Router | 4 |
| **HTTP Client** | Axios | Latest |
| **Containerization** | Docker & Docker Compose | Latest |
| **Package Manager** | Composer | Latest |
| **Testing** | PHPUnit | Latest |

---

## 🚀 Instalasi & Setup

### Prasyarat
- Docker dan Docker Compose terinstall
- Terminal/Command Line
- Git (untuk clone repository)

### Langkah-langkah

1. **Clone atau Download Repository**
   ```bash
   git clone <repository-url>
   cd web2
   ```

2. **Build dan Jalankan Container**
   ```bash
   docker compose up --build -d
   ```

3. **Tunggu Proses Initialization**
   
   Saat container `app` pertama kali jalan, startup script akan otomatis melakukan:
   - Menunggu database siap
   - Menjalankan `composer install`
   - Menjalankan migrations (membuat tabel)
   - Menjalankan seeder (mengisi data awal)

   Proses ini membutuhkan 1-2 menit. Anda bisa monitor log dengan:
   ```bash
   docker compose logs -f app
   ```

4. **Akses Aplikasi**
   - Backend URL: `http://localhost:8082`
   - Frontend URL: `http://localhost:8081` (jika dijalankan terpisah)
   - Database: `localhost:3307`

5. **Untuk Menghentikan**
   ```bash
   docker compose down
   ```

---

## 🌐 Menjalankan Aplikasi

### Konfigurasi Port

Port default diatur karena port `8080`, `8081`, dan `3306` sudah dipakai:

| Service | Port |
|---------|------|
| Backend Web | 8082 |
| MySQL Database | 3307 |

Untuk mengubah port, edit `docker-compose.yml`:
```yaml
services:
  app:
    ports:
      - "PORT_BARU:80"  # Ubah PORT_BARU sesuai keinginan
```

### Development Workflow

```bash
# Lihat status container
docker compose ps

# Lihat log aplikasi real-time
docker compose logs -f app

# Akses terminal dalam container
docker exec -it web2_ci4_app bash

# Jalankan command di container
docker exec web2_ci4_app php spark migrate

# Rebuild container (jika ada perubahan Dockerfile)
docker compose up --build -d
```

---

## 👤 Akun Default

Akun admin sudah dibuat otomatis melalui seeder:

| Field | Value |
|-------|-------|
| Email | `admin@email.com` |
| Password | `admin123` |

**URL Login:** `http://localhost:8082/user/login`

### Tips Keamanan
- **Ubah password** setelah login pertama kali
- Gunakan password yang kuat untuk production
- Jangan hardcode password di kode, gunakan environment variable

---

## 📖 Dokumentasi Fitur

### 1. **Halaman Publik**

#### Beranda (`/`)
- Menampilkan header, navigasi, dan 3 artikel terbaru
- Sidebar menampilkan "Artikel Terkini" (dinamis dengan View Cell)
- Layout: header → navigasi → featured articles → sidebar → footer

#### Daftar Artikel (`/artikel`)
- Menampilkan semua artikel yang `Published` (status = 1)
- Pagination: 6 artikel per halaman
- Query: Artikel di-join dengan kategori untuk menampilkan nama kategori
- Sorting: Berdasarkan `created_at` DESC (terbaru dahulu)

#### Detail Artikel (`/artikel/{slug}`)
- Menampilkan artikel lengkap dengan isi, gambar, kategori
- Hanya menampilkan artikel yang `Published`
- Akses via URL slug (unik dan SEO-friendly)
- Jika artikel tidak ditemukan: tampilkan 404

#### Halaman About (`/about`)
- Konten statis dari SiteContent config

#### Halaman Contact (`/contact`)
- Konten statis dari SiteContent config

---

### 2. **Autentikasi & Admin**

#### Login (`/user/login`)
- Form email + password
- Password di-hash dengan `password_verify()` (PHP native)
- Session disimpan: `user_id`, `user_name`, `user_email`, `logged_in`
- Flash message untuk error
- Redirect ke `/admin/artikel` jika login berhasil

#### Logout (`/user/logout`)
- Destroy session
- Redirect ke halaman login

#### Auth Filter
- Filter `auth` melindungi semua route di `/admin` group
- Jika user belum login: redirect ke `/user/login`

---

### 3. **Manajemen Artikel (Admin)**

#### Daftar Artikel Admin (`/admin/artikel`)
- Pagination: 10 artikel per halaman
- Tabel: ID | Judul | Kategori | Status | Aksi (edit, delete)
- **Pencarian:** Input `q` (query) untuk cari di judul atau isi
- **Filter:** Dropdown `kategori_id` untuk filter by kategori
- Query Builder: `like` untuk pencarian, `where` untuk filter
- Sorting: `created_at` DESC

#### Tambah Artikel (`/admin/artikel/add`)
- Form POST
- Validasi:
  - Judul: required, min 3 karakter
  - Isi: required, min 20 karakter
  - Kategori: required, integer
  - Status: required, 0 atau 1
  - Gambar: optional, max 255 karakter
- Auto-generate slug dari judul
- Input gambar: path/nama file atau placeholder.svg
- Submit: insert ke tabel `artikel`
- Success: flash message + redirect ke daftar artikel

#### Edit Artikel (`/admin/artikel/edit/{id}`)
- Form GET (tampil form) dan POST (proses update)
- Validasi sama seperti tambah artikel
- Update slug (bisa berubah jika judul berubah)
- Jika artikel tidak ditemukan: 404
- Success: flash message + redirect ke daftar artikel

#### Hapus Artikel (`/admin/artikel/delete/{id}`)
- Delete dari tabel `artikel` by ID
- Redirect ke daftar artikel dengan flash message
- Tidak ada konfirmasi, langsung hapus

---

### 4. **Manajemen Kategori (Admin)**

#### Daftar Kategori (`/admin/kategori`)
- Tampilkan semua kategori dengan jumlah artikel
- Tabel: ID | Nama | Slug | Jumlah Artikel | Aksi (edit, delete)

#### Tambah Kategori (`/admin/kategori/add`)
- Form POST
- Validasi:
  - Nama kategori: required, min 3 karakter
  - Slug kategori: optional
- Jika slug kosong: auto-generate dari nama
- Insert ke tabel `kategori`
- Success: flash message + redirect

#### Edit Kategori (`/admin/kategori/edit/{id}`)
- Form GET dan POST
- Validasi sama seperti tambah
- Update slug jika ada perubahan
- Jika kategori tidak ditemukan: 404

#### Hapus Kategori (`/admin/kategori/delete/{id}`)
- Cek apakah kategori masih dipakai artikel
- Jika dipakai: tampilkan error message (tidak bisa dihapus)
- Jika tidak: delete dari tabel `kategori`

---

### 5. **Frontend SPA (VueJS)**

#### Single Page Application
- Navigasi halus tanpa page reload
- Vue Router untuk manajemen routing
- Axios untuk komunikasi dengan backend API
- Komponen-komponen terpisah untuk maintainability

#### Navigation Guards
- Proteksi rute yang membutuhkan autentikasi
- Cek status login di localStorage
- Redirect ke halaman login jika belum terautentikasi

#### Dynamic Navigation
- Menu navigasi yang berubah berdasarkan status login
- Tombol Login/Logout yang dinamis

#### State Management
- Menggunakan localStorage untuk menyimpan status login
- Token JWT disimpan di localStorage untuk API calls

---

## 🔌 Endpoint API

### Publik Routes (Server-Side MVC)

| Method | Route | Controller | Deskripsi |
|--------|-------|-----------|-----------|
| GET | `/` | Home::index | Halaman beranda |
| GET | `/about` | Page::about | Halaman about |
| GET | `/contact` | Page::contact | Halaman contact |
| GET | `/artikel` | Artikel::index | Daftar artikel publik |
| GET | `/artikel/{slug}` | Artikel::view | Detail artikel |

### User Routes

| Method | Route | Controller | Deskripsi |
|--------|-------|-----------|-----------|
| GET/POST | `/user/login` | User::login | Login form & proses |
| GET | `/user/logout` | User::logout | Logout |

### Admin Routes (Protected by Auth Filter)

| Method | Route | Controller | Deskripsi |
|--------|-------|-----------|-----------|
| GET | `/admin/artikel` | Artikel::admin_index | Daftar artikel (dengan pencarian & filter) |
| GET/POST | `/admin/artikel/add` | Artikel::add | Form & proses tambah artikel |
| GET/POST | `/admin/artikel/edit/{id}` | Artikel::edit | Form & proses edit artikel |
| GET | `/admin/artikel/delete/{id}` | Artikel::delete | Hapus artikel |
| GET | `/admin/kategori` | Kategori::index | Daftar kategori |
| GET/POST | `/admin/kategori/add` | Kategori::add | Form & proses tambah kategori |
| GET/POST | `/admin/kategori/edit/{id}` | Kategori::edit | Form & proses edit kategori |
| GET | `/admin/kategori/delete/{id}` | Kategori::delete | Hapus kategori |

### REST API Routes (Untuk SPA Frontend)

| Method | Route | Controller | Auth | Deskripsi |
|--------|-------|-----------|------|-----------|
| POST | `/api/login` | Api\Auth::login | - | Login API, mengembalikan token |
| GET | `/api/artikel` | Api\Artikel::index | - | Ambil daftar artikel (publik) |
| POST | `/api/artikel` | Api\Artikel::create | apiauth | Tambah artikel baru |
| PUT | `/api/artikel/{id}` | Api\Artikel::update | apiauth | Update artikel |
| DELETE | `/api/artikel/{id}` | Api\Artikel::delete | apiauth | Hapus artikel |

---

## 🗄 Struktur Database

### Tabel: `kategori`

```sql
CREATE TABLE kategori (
  id_kategori INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama_kategori VARCHAR(100) NOT NULL,
  slug_kategori VARCHAR(100) UNIQUE NOT NULL
);
```

| Kolom | Tipe | Deskripsi |
|-------|------|-----------|
| `id_kategori` | INT UNSIGNED | Primary key, auto increment |
| `nama_kategori` | VARCHAR(100) | Nama kategori (unik per kategori) |
| `slug_kategori` | VARCHAR(100) | Slug unik untuk URL |

---

### Tabel: `artikel`

```sql
CREATE TABLE artikel (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(200) NOT NULL,
  isi TEXT NOT NULL,
  gambar VARCHAR(255) NULL,
  status TINYINT(1) DEFAULT 1,
  slug VARCHAR(200) UNIQUE NOT NULL,
  id_kategori INT UNSIGNED,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) 
    ON DELETE RESTRICT ON UPDATE CASCADE
);
```

| Kolom | Tipe | Deskripsi |
|-------|------|-----------|
| `id` | INT UNSIGNED | Primary key, auto increment |
| `judul` | VARCHAR(200) | Judul artikel |
| `isi` | TEXT | Isi artikel |
| `gambar` | VARCHAR(255) | Path/nama file gambar |
| `status` | TINYINT(1) | 1=Published, 0=Draft |
| `slug` | VARCHAR(200) | Slug unik untuk URL |
| `id_kategori` | INT UNSIGNED | FK ke tabel kategori |
| `created_at` | DATETIME | Waktu dibuat (auto) |
| `updated_at` | DATETIME | Waktu diupdate (auto) |

**Relasi:** One-to-Many (1 kategori → banyak artikel)

---

### Tabel: `users`

```sql
CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(120) NOT NULL,
  useremail VARCHAR(120) UNIQUE NOT NULL,
  userpassword VARCHAR(255) NOT NULL
);
```

| Kolom | Tipe | Deskripsi |
|-------|------|-----------|
| `id` | INT UNSIGNED | Primary key, auto increment |
| `username` | VARCHAR(120) | Nama user |
| `useremail` | VARCHAR(120) | Email user (unik) |
| `userpassword` | VARCHAR(255) | Password (terenkripsi hash) |

---

## 📊 Query Builder & Database Queries

### ArtikelModel::withKategori()
Join artikel dengan kategori untuk menampilkan nama kategori:

```php
$artikel = $model
    ->withKategori()  // JOIN dengan kategori
    ->where('artikel.status', 1)  // Hanya artikel published
    ->orderBy('artikel.created_at', 'DESC')  // Terbaru dulu
    ->paginate(6);
```

### Pencarian Artikel
Cari di judul atau isi dengan LIKE:

```php
$model->groupStart()
    ->like('artikel.judul', $q)
    ->orLike('artikel.isi', $q)
    ->groupEnd();
```

### Filter Kategori
Filter artikel berdasarkan kategori:

```php
if ($kategoriId !== '') {
    $model->where('artikel.id_kategori', (int) $kategoriId);
}
```

---

## 🔧 Konfigurasi Penting

### `.env` (Environment Variables)
```
CI_ENVIRONMENT = development  # atau production

DB_HOST = db
DB_PORT = 3306
DB_DATABASE = lab_ci4
DB_USERNAME = ci4user
DB_PASSWORD = ci4pass

TZ = Asia/Jakarta
```

### `app/Config/Routes.php`
Definisi routing publik, user, dan admin dengan auth filter.

### `app/Config/Filters.php`
Register filter `auth` dan `apiauth` untuk proteksi routes.

### `app/Config/Cors.php`
Konfigurasi CORS untuk mengizinkan frontend mengakses API.

### `app/Filters/Auth.php`
Middleware untuk check session login sebelum akses admin routes.

### `app/Filters/ApiAuthFilter.php`
Middleware untuk check token Bearer pada API calls.

---

## 💡 Tips Pengembangan

### Menambah Fitur Baru

1. **Buat Migration** (jika ada perubahan database):
   ```bash
   docker exec web2_ci4_app php spark make:migration CreateTableName
   ```

2. **Buat Model**:
   ```bash
   docker exec web2_ci4_app php spark make:model ModelName
   ```

3. **Buat Controller**:
   ```bash
   docker exec web2_ci4_app php spark make:controller ControllerName
   ```

4. **Buat View**:
   Buat file di `app/app/Views/folder/nama_view.php`

### Debugging

```bash
# Lihat error aplikasi
docker compose logs app

# Akses shell container
docker exec -it web2_ci4_app bash

# Jalankan query langsung ke MySQL
docker exec -it web2_ci4_db mysql -uroot -p lab_ci4
```

---

## 📝 Catatan

- Seeder otomatis create akun admin: `admin@email.com` / `admin123`
- Slug artikel & kategori di-generate otomatis dari nama/judul
- Password di-hash menggunakan PHP built-in `password_hash()`
- Session disimpan di `writable/session/`
- Log ada di `writable/logs/`
- Upload/gambar bisa disimpan di `writable/uploads/`

---

## 📄 Lisensi

Project ini adalah hasil praktikum dan bebas digunakan sesuai kebutuhan.


## Dibuat dengan menggunakan CodeIgniter 4 dan VueJS
