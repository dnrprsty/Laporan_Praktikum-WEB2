## 📖 Dokumentasi Praktikum

Berikut adalah dokumentasi lengkap setiap modul praktikum yang telah dikerjakan:

---

## 📋 Modul 1-3: Dasar-Dasar CodeIgniter 4 dan Database

### 📖 Modul 1: Pengenalan CodeIgniter 4 dan Instalasi
**Tujuan**: Mengenal struktur CodeIgniter 4 dan instalasi awal
**Topik**:
- Arsitektur MVC (Model-View-Controller)
- Struktur folder CodeIgniter 4
- Konfigurasi dasar `.env`
- Membuat project baru dengan Composer
- Memahami routing dasar

**Hasil**: Project CodeIgniter 4 base yang siap dikembangkan

---

### 📖 Modul 2: Database dan Migration
**Tujuan**: Implementasi database dengan migration
**Topik**:
- Konfigurasi database di `.env`
- Membuat migration file
- Struktur tabel database
- Menjalankan migration
- Relationship antar tabel

**Hasil**: Database structure dengan tabel kategori, artikel, dan users

---

### 📖 Modul 3: Models dan CRUD dasar
**Tujuan**: Membuat models dan operasi CRUD dasar
**Topik**:
- Membuat model entities
- Query builder methods
- Insert, Read, Update, Delete dasar
- Validasi data
- Pagination

**Hasil**: Models functional untuk operasi database

---

## 📋 Modul 4-6: Fitur Administrasi dan User Interface

### 📖 Modul 4: Autentikasi dan Session
**Tujuan**: Implementasi sistem login dan session management
**Topik**:
- Session handling di CodeIgniter 4
- Password hashing dengan `password_hash()`
- Form login dan validasi
- Session data management
- Authentication filters

**Hasil**: Sistem login yang aman dengan password terenkripsi

---

### 📖 Modul 5: Manajemen Artikel Lengkap
**Tujuan**: CRUD lengkap untuk artikel dengan fitur-fitur admin
**Topik**:
- Create artikel dengan form validation
- Read artikel dengan pagination
- Update artikel dengan data pre-population
- Delete artikel dengan konfirmasi
- Status artikel (Published/Draft)
- Image upload management

**Hasil**: Sistem manajemen artikel yang lengkap

---

### 📖 Modul 6: Manajemen Kategori dan Relasi
**Tujuan**: Implementasi kategori dan relasi dengan artikel
**Topik**:
- CRUD untuk kategori
- One-to-Many relationship
- Foreign key constraints
- Dropdown kategori di form artikel
- Slug generation otomatis
- Prevent delete kategori yang masih dipakai

**Hasil**: Sistem kategori yang terintegrasi dengan artikel

---

## 📋 Modul 7-9: Fitur Publik dan Frontend

### 📖 Modul 7: Halaman Publik dan Layout
**Tujuan**: Membuat halaman publik yang user-friendly
**Topik**:
- Layout system dengan reusable components
- View Cells untuk artikel terkini
- Halaman about dan contact
- Responsive design dengan CSS
- Dynamic sidebar

**Hasil**: Halaman publik yang menarik dan fungsional

---

### 📖 Modul 8: Pencarian dan Filter
**Tujuan**: Implementasi fitur pencarian dan filter
**Topik**:
- Search functionality dengan LIKE query
- Filter berdasarkan kategori
- Combined search and filter
- Query builder groupStart/groupEnd
- Parameter persistence di URL

**Hasil**: Fitur pencarian dan filter yang powerful

---

### 📖 Modul 9: Detail Artikel dan SEO
**Tujuan**: Membuat halaman detail dan SEO optimization
**Topik**:
- Dynamic routing dengan slug
- Detail artikel page
- SEO optimization dengan meta tags
- Related articles
- Breadcrumb navigation

**Hasil**: Halaman detail yang SEO-friendly

---

## 📋 Modul 10-12: Docker dan Advanced Features

### 📖 Modul 10: Containerisasi dengan Docker
**Tujuan**: Mengimplementasikan Docker untuk development environment
**Topik**:
- Dockerfile untuk CodeIgniter 4
- Docker Compose untuk multi-container
- Database containerization
- Volume management
- Development workflow dengan Docker

**Hasil**: Development environment yang terisolasi dan portable

---

### 📖 Modul 11: Advanced Query dan Performance
**Tujuan**: Optimasi query dan performance
**Topik**:
- Query optimization
- Database indexing
- Eager loading untuk relationships
- Query caching
- Performance monitoring

**Hasil**: Aplikasi yang lebih performant

---

### 📖 Modul 12: Testing dan Deployment
**Tujuan**: Testing preparation dan deployment strategy
**Topik**:
- Unit testing dengan PHPUnit
- Integration testing
- Deployment checklist
- Production configuration
- Security hardening

**Hasil**: Aplikasi siap untuk production

---

## 🔐 Modul 13: VueJS Autentikasi dan Navigation Guards (SPA Security)

### Deskripsi
Praktikum ini mengimplementasikan **Client-Side Security** menggunakan Vue Router Navigation Guards dan **Server-Side API Login** pada backend CodeIgniter 4.

### Fitur
- **API Login Endpoint** (`POST /api/login`) — Memvalidasi username/password dan mengembalikan token base64
- **Login Component** (VueJS) — Form login yang mengirim kredensial ke backend via Axios
- **Navigation Guards** (`router.beforeEach`) — Mencegat akses ke rute yang membutuhkan autentikasi
- **Dynamic Nav Menu** — Tombol Login/Logout berubah secara dinamis berdasarkan status login

### Alur Kerja
1. User membuka halaman `/artikel` tanpa login → Navigation guard mendeteksi `requiresAuth: true` → Alert ditampilkan → Redirect ke `/login`
2. User mengisi form login → Axios POST ke `http://localhost:8082/api/login` → Backend memverifikasi kredensial → Mengembalikan token
3. Token disimpan di `localStorage` → User diarahkan ke halaman artikel
4. Saat logout → `localStorage` dibersihkan → Redirect ke beranda

### Implementasi Backend (CI4)

**Controller:** `app/app/Controllers/Api/Auth.php`
```php
public function login()
{
    $username = $this->request->getVar('username');
    $password = $this->request->getVar('password');
    $user = (new UserModel())->where('username', $username)
                  ->orWhere('useremail', $username)->first();

    if ($user && password_verify($password, $user['userpassword'])) {
        return $this->respond([
            'status' => 200, 'error' => null, 'messages' => 'Login Berhasil',
            'data' => ['id' => $user['id'], 'username' => $user['username'],
                       'token' => base64_encode('TOKEN-SECRET-' . $user['username'])]
        ]);
    }
    return $this->failUnauthorized('Username atau Password salah.');
}
```

**Route:** `$routes->post('api/login', 'Api\Auth::login');`

### Implementasi Frontend (VueJS SPA)

**Navigation Guard:** `frontend/assets/js/app.js`
```javascript
router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('isLoggedIn') === 'true';
    if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated) {
        alert('Akses Ditolak! Anda harus login terlebih dahulu.');
        next('/login');
    } else {
        next();
    }
});
```

**File yang dibuat/modified:**
- `app/app/Controllers/Api/Auth.php` - API endpoint untuk login
- `frontend/assets/js/components/Login.js` - Vue component untuk login
- `frontend/assets/js/app.js` - Router configuration dan navigation guards
- `frontend/index.html` - Template HTML untuk SPA
- `frontend/assets/css/style.css` - Styling untuk form login

---

## 🔒 Modul 14: Keamanan API, Autentikasi Token, dan Axios Interceptors

### Deskripsi
Praktikum ini menambahkan **Server-Side Security** menggunakan Token-Based Authentication pada REST API dan **Axios Interceptors** pada sisi frontend untuk auto-inject token.

### Fitur
- **API Auth Filter** (`apiauth`) — Filter CodeIgniter yang memeriksa token Bearer pada setiap request
- **Token Validation** — Memeriksa keberadaan token di HTTP Header `Authorization`
- **Axios Request Interceptor** — Auto-inject token dari `localStorage` ke setiap request
- **Axios Response Interceptor** — Global handler untuk error 401 (auto logout)
- **CORS Configuration** — Mengizinkan cross-origin request dari frontend SPA

### Perbedaan Keamanan: Client-Side vs Server-Side

| Aspek | Vue Router Guards (Client) | CodeIgniter Filters (Server) |
|-------|---------------------------|------------------------------|
| **Lokasi** | Browser (JavaScript) | Server (PHP) |
| **Bypass possible?** | Ya (nonaktifkan JS) | Tidak (server langsung blokir) |
| **Melindungi** | Tampilan halaman | Endpoint API & data |
| **Cara kerja** | Cek localStorage | Cek HTTP Header Authorization |
| **Tools bypass** | Browser dev tools | Postman / curl tanpa token |

### Implementasi Backend (CI4)

**Filter:** `app/app/Filters/ApiAuthFilter.php`
```php
public function before(RequestInterface $request, $arguments = null)
{
    $authHeader = $request->getServer('HTTP_AUTHORIZATION');
    if (!$authHeader) {
        return Services::response()
            ->setStatusCode(401)
            ->setJSON(['status' => 401, 'error' => 401, 'messages' => 'Token tidak ditemukan!']);
    }
    // Extract Bearer token and validate...
}
```

**Route Protection:**
```php
$routes->post('api/artikel', 'Api\Artikel::create', ['filter' => 'apiauth']);
$routes->put('api/artikel/(:segment)', 'Api\Artikel::update/$1', ['filter' => 'apiauth']);
$routes->delete('api/artikel/(:segment)', 'Api\Artikel::delete/$1', ['filter' => 'apiauth']);
```

### Implementasi Frontend (VueJS SPA)

**Axios Interceptors:** `frontend/assets/js/app.js`
```javascript
// Request Interceptor — Auto-inject token
axios.interceptors.request.use((config) => {
    const token = localStorage.getItem('userToken');
    if (token) config.headers['Authorization'] = 'Bearer ' + token;
    return config;
});

// Response Interceptor — Handle 401 globally
axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response && error.response.status === 401) {
            alert('Sesi berakhir. Silakan login kembali.');
            localStorage.clear();
            window.location.href = '#/login';
        }
        return Promise.reject(error);
    }
);
```

### Struktur Frontend SPA

```
frontend/
├── index.html                          # Entry point SPA
├── assets/
│   ├── css/
│   │   └── style.css                   # Stylesheet SPA
│   └── js/
│       ├── app.js                      # Vue router, guards, Axios interceptors
│       └── components/
│           ├── Home.js                  # Halaman beranda
│           ├── Artikel.js              # Daftar artikel (terproteksi)
│           └── Login.js                # Form login
```

### File yang dibuat/modified:**
- `app/app/Filters/ApiAuthFilter.php` - Filter untuk validasi token API
- `app/app/Config/Filters.php` - Registrasi filter apiauth
- `app/app/Config/Cors.php` - Konfigurasi CORS
- `app/app/Controllers/Api/Artikel.php` - API endpoints untuk artikel CRUD
- `frontend/assets/js/app.js` - Tambahkan Axios interceptors
- `frontend/assets/js/components/Artikel.js` - Vue component untuk artikel dengan API calls
