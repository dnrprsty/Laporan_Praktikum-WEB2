# Laporan Praktikum - Pemrograman Web 2

Single Page Application (SPA) berbasis Vue.js dengan REST API backend CodeIgniter 4, dilengkapi sistem autentikasi JWT-like token dan proteksi akses Client-Side serta Server-Side.

---

## Tech Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| Backend Framework | CodeIgniter 4 | 4.7.x |
| Frontend Framework | Vue.js 3 | 3.x |
| Router | Vue Router 4 | 4.x |
| HTTP Client | Axios | 1.x |
| Database | MySQL | 8.0 |
| Web Server | Apache (Docker) | Latest |
| Containerization | Docker Compose | Latest |
| Language (Backend) | PHP | 8.2+ |
| Language (Frontend) | JavaScript (ES6) | - |

---

## Module 12 - REST API dengan CodeIgniter 4

### Objective
Membangun RESTful Web Service menggunakan CodeIgniter 4 yang menyediakan endpoint CRUD untuk resource artikel.

### Implementation

**Controller API:** `app/app/Controllers/Api/Artikel.php`

```php
public function index()
{
    $model = new ArtikelModel();
    $data = $model->withKategori()->orderBy('artikel.created_at', 'DESC')->findAll();
    return $this->respond(['status' => 200, 'error' => null, 'data' => $data], 200);
}
```

### Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/artikel` | Retrieve all articles with category |
| POST | `/api/artikel` | Create new article (requires token) |
| PUT | `/api/artikel/{id}` | Update existing article (requires token) |
| DELETE | `/api/artikel/{id}` | Delete article (requires token) |

### Key Features
- Menggunakan `CodeIgniter\RESTful\ResourceController` untuk standarisasi method REST
- Response format JSON melalui properti `$format = 'json'`
- Join tabel artikel dengan kategori menggunakan method `withKategori()`
- Error handling dengan `failNotFound()` dan `failUnauthorized()`

---

## Module 13 - Vue.js Authentication & Navigation Guards (Client-Side Security)

### Objective
Menerapkan keamanan pada sisi klien (Client-Side Security) menggunakan Vue Router Navigation Guards, serta membuat API login endpoint pada backend CodeIgniter 4.

### Backend Implementation

**Login API Controller:** `app/app/Controllers/Api/Auth.php`

Auth controller menerima kredensial username/password via POST request, memverifikasi ke database, dan mengembalikan token base64 jika valid.

```php
public function login()
{
    $username = $this->request->getVar('username');
    $password = $this->request->getVar('password');
    $user = (new UserModel())->where('username', $username)
        ->orWhere('useremail', $username)->first();

    if ($user && password_verify($password, $user['userpassword'])) {
        return $this->respond([
            'status' => 200,
            'error' => null,
            'messages' => 'Login Berhasil',
            'data' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'token' => base64_encode('TOKEN-SECRET-' . $user['username'])
            ]
        ], 200);
    }
    return $this->failUnauthorized('Username atau Password yang Anda masukkan salah.');
}
```

**Route Registration:**
```php
$routes->post('api/login', 'Api\Auth::login');
```

### Frontend Implementation

**Login Component:** `frontend/assets/js/components/Login.js`

Komponen login dengan form username/password dan menggunakan Axios untuk mengirim kredensial ke API backend.

```javascript
handleLogin() {
    axios.post(apiUrl + '/api/login', {
        username: this.username,
        password: this.password
    })
    .then(response => {
        if (response.data.status === 200) {
            localStorage.setItem('isLoggedIn', 'true');
            localStorage.setItem('userToken', response.data.data.token);
            this.$router.push('/artikel');
            window.location.reload();
        }
    })
    .catch(error => {
        this.errorMessage = error.response?.data?.messages || 'Terjadi kesalahan jaringan.';
    });
}
```

**Navigation Guard:** `frontend/assets/js/app.js`

Vue Router Navigation Guard memeriksa status autentikasi sebelum mengizinkan akses ke halaman tertentu.

```javascript
const routes = [
    { path: '/', component: Home },
    { path: '/login', component: Login },
    { path: '/artikel', component: Artikel, meta: { requiresAuth: true } }
];

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

### Security Flow
1. User navigates ke halaman `/artikel` tanpa login
2. Navigation guard mendeteksi `meta.requiresAuth: true` and `isLoggedIn = false`
3. Alert muncul, user diarahkan ke halaman `/login`
4. User login dengan kredensial valid
5. Token disimpan di localStorage, user diarahkan ke halaman artikel

---

## Module 14 - Token Authentication & Axios Interceptors (Server-Side Security)

### Objective
Menambahkan Server-Side Security menggunakan Token-Based Authentication pada REST API, serta Axios Interceptors untuk auto-inject token dari sisi frontend.

### Backend Implementation

**API Auth Filter:** `app/app/Filters/ApiAuthFilter.php`

Filter ini mengekstrak token Bearer dari HTTP Header Authorization setiap request. Jika token tidak ditemukan, server mengembalikan HTTP 401 Unauthorized.

```php
public function before(RequestInterface $request, $arguments = null)
{
    $authHeader = $request->getServer('HTTP_AUTHORIZATION');

    if (!$authHeader) {
        $response = Services::response();
        $response->setStatusCode(401);
        return $response->setJSON([
            'status' => 401,
            'error' => 401,
            'messages' => 'Akses Ditolak. Token tidak ditemukan pada request!'
        ]);
    }

    $token = null;
    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    if (!$token || empty($token)) {
        $response = Services::response();
        $response->setStatusCode(401);
        return $response->setJSON([
            'status' => 401,
            'error' => 401,
            'messages' => 'Sesi Token tidak valid atau kedaluwarsa!'
        ]);
    }
}
```

**Filter Registration:** `app/app/Config/Filters.php`

```php
public array $aliases = [
    'apiauth' => \App\Filters\ApiAuthFilter::class,
];
```

**Protected Routes:** `app/app/Config/Routes.php`

```php
$routes->post('api/artikel', 'Api\Artikel::create', ['filter' => 'apiauth']);
$routes->put('api/artikel/(:segment)', 'Api\Artikel::update/$1', ['filter' => 'apiauth']);
$routes->delete('api/artikel/(:segment)', 'Api\Artikel::delete/$1', ['filter' => 'apiauth']);
```

### Frontend Implementation

**Axios Request Interceptor:** `frontend/assets/js/app.js`

Interceptor ini secara otomatis menyisipkan token Bearer ke setiap HTTP request sebelum dikirim ke server.

```javascript
axios.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('userToken');
        if (token) {
            config.headers['Authorization'] = 'Bearer ' + token;
        }
        return config;
    },
    (error) => Promise.reject(error)
);
```

**Axios Response Interceptor:** `frontend/assets/js/app.js`

Interceptor response global menangani error HTTP 401. Jika token tidak valid atau kadaluarsa, user akan diarahkan ke halaman login secara otomatis.

```javascript
axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response && error.response.status === 401) {
            alert('Sesi Anda telah berakhir atau Token tidak sah. Silakan login kembali.');
            localStorage.clear();
            window.location.href = '#/login';
            window.location.reload();
        }
        return Promise.reject(error);
    }
);
```

### Client-Side vs Server-Side Security

| Aspect | Vue Router Guards (Client) | CodeIgniter Filters (Server) |
|--------|---------------------------|------------------------------|
| Location | Browser (JavaScript) | Server (PHP) |
| Bypass Possible | Yes (disable JavaScript) | No (server intercepts all requests) |
| Protection Target | Page/View access | API endpoint & data |
| Mechanism | Check localStorage | Validate HTTP Authorization header |
| Bypass Tools | Browser DevTools | Postman / cURL without token |
| Response on Failure | Alert + route redirect | HTTP 401 JSON response |

### CORS Configuration

CORS diaktifkan secara global melalui `app/app/Config/Filters.php` dan dikonfigurasi di `app/app/Config/Cors.php` untuk mengizinkan akses dari origin mana pun dengan metode HTTP standar.

```php
public array $globals = [
    'before' => ['cors'],
    'after' => ['cors'],
];
```

```php
public array $default = [
    'allowedOrigins' => ['*'],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
    'supportsCredentials' => true,
];
```

---

## Complete API Endpoint Reference

### REST API

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/api/login` | None | User login, returns token |
| GET | `/api/artikel` | None | List all articles |
| POST | `/api/artikel` | apiauth | Create new article |
| PUT | `/api/artikel/{id}` | apiauth | Update article |
| DELETE | `/api/artikel/{id}` | apiauth | Delete article |

### Server-Side MVC Routes

| Method | Endpoint | Controller | Description |
|--------|----------|------------|-------------|
| GET | `/` | Home::index | Homepage |
| GET | `/about` | Page::about | About page |
| GET | `/contact` | Page::contact | Contact page |
| GET | `/artikel` | Artikel::index | Public article list |
| GET | `/artikel/{slug}` | Artikel::view | Article detail |
| GET/POST | `/user/login` | User::login | Admin login page |
| GET | `/user/logout` | User::logout | Admin logout |

### Protected Admin Routes

| Method | Endpoint | Controller | Description |
|--------|----------|------------|-------------|
| GET | `/admin/artikel` | Artikel::admin_index | Article management (with search & filter) |
| GET/POST | `/admin/artikel/add` | Artikel::add | Create article |
| GET/POST | `/admin/artikel/edit/{id}` | Artikel::edit | Edit article |
| GET | `/admin/artikel/delete/{id}` | Artikel::delete | Delete article |
| GET | `/admin/kategori` | Kategori::index | Category list |
| GET/POST | `/admin/kategori/add` | Kategori::add | Create category |
| GET/POST | `/admin/kategori/edit/{id}` | Kategori::edit | Edit category |
| GET | `/admin/kategori/delete/{id}` | Kategori::delete | Delete category |

---

## Project Structure

```
web2/
├── app/                              # CodeIgniter 4 application
│   ├── app/
│   │   ├── Config/                   # Application configuration
│   │   │   ├── Routes.php           # Route definitions
│   │   │   ├── Filters.php          # Filter/middleware registration
│   │   │   ├── Cors.php            # CORS configuration
│   │   │   └── ...
│   │   ├── Controllers/
│   │   │   ├── Api/                 # REST API controllers
│   │   │   │   ├── Auth.php        # Login endpoint
│   │   │   │   └── Artikel.php     # Article CRUD endpoint
│   │   │   ├── Home.php            # Homepage
│   │   │   ├── Artikel.php         # Server-side article CRUD
│   │   │   ├── Kategori.php        # Category management
│   │   │   ├── Page.php            # Static pages
│   │   │   └── User.php            # Login/logout
│   │   ├── Filters/
│   │   │   ├── Auth.php            # Session auth filter
│   │   │   └── ApiAuthFilter.php   # Token-based auth filter
│   │   ├── Models/                  # Database models
│   │   ├── Views/                   # Server-side templates
│   │   └── Database/               # Migrations & seeds
│   ├── public/                      # Document root
│   ├── vendor/                      # Composer dependencies
│   ├── writable/                    # Cache, logs, sessions
│   └── .env                        # Environment configuration
├── frontend/                        # Vue.js SPA frontend
│   ├── index.html                  # SPA entry point
│   └── assets/
│       ├── css/
│       │   └── style.css           # SPA stylesheet
│       └── js/
│           ├── app.js              # Vue Router, Axios interceptors, app instance
│           └── components/
│               ├── Home.js         # Homepage component
│               ├── Artikel.js      # Protected article list component
│               └── Login.js        # Login form component
├── docker/                          # Docker configuration
├── docker-compose.yml               # Docker Compose setup
└── README.md
```

---

## How to Run

### Prerequisites
- Docker and Docker Compose installed
- Git

### Installation

```bash
# Clone repository
git clone https://github.com/dnrprsty/Laporan_Praktikum-WEB2.git
cd web2

# Build and run containers
docker compose up --build -d

# Wait for initialization (1-2 minutes)
docker compose logs -f app
```

### Access

| Service | URL/Port |
|---------|----------|
| Web Application | http://localhost:8082 |
| MySQL Database | localhost:3307 |

### Default Admin Account

| Field | Value |
|-------|-------|
| Email | admin@email.com |
| Password | admin123 |

Login URL: http://localhost:8082/user/login

### Development Commands

```bash
# View container status
docker compose ps

# View application logs
docker compose logs -f app

# SSH into container
docker exec -it web2_ci4_app bash

# Run migrations
docker exec web2_ci4_app php spark migrate

# Stop containers
docker compose down

# Rebuild containers
docker compose up --build -d
```

---

## Notes

- Token authentication menggunakan format base64 sederhana (`base64_encode("TOKEN-SECRET-" + username)`)
- Untuk production, gunakan JWT (JSON Web Token) library seperti `firebase/php-jwt`
- Password pengguna di-hash menggunakan PHP native `password_hash()` dengan algoritma `PASSWORD_DEFAULT` (bcrypt)
- Frontend Vue.js SPA diakses melalui file `frontend/index.html` secara langsung atau melalui web server terpisah
- CORS diaktifkan untuk development; sesuaikan `allowedOrigins` untuk production