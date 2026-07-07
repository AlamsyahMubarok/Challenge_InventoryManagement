# Inventra - Inventory Management System

Inventra adalah aplikasi manajemen inventaris berbasis web yang dibuat untuk membantu pengelolaan data barang, kategori, stok, peminjaman, pengembalian, laporan, upload gambar barang, notifikasi stok menipis, dan REST API.

Aplikasi ini dibangun menggunakan Laravel, Blade, Tailwind CSS, PostgreSQL Supabase, Supabase Storage, Laravel Breeze, Laravel Sanctum, Chart.js, dan Pest Testing.

## Deskripsi Project

Inventra dibuat sebagai prototype sistem manajemen inventaris untuk membantu proses pencatatan barang, pengelompokan kategori, pemantauan stok, peminjaman barang, pengembalian barang, dan pembuatan laporan inventaris.

Sistem ini menggunakan role-based access control sehingga setiap pengguna hanya dapat mengakses fitur sesuai tanggung jawabnya.

## Link Demo

Production URL:

```txt
https://inventra.koreacentral.cloudapp.azure.com
```

Production API Base URL:

```txt
https://inventra.koreacentral.cloudapp.azure.com/api
```

## Akun Demo

Gunakan akun berikut untuk mencoba aplikasi.

| Role | Email | Password |
|---|---|---|
| Admin | admin@example.com | admin123 |
| Staff | staff@example.com | staff123 |
| Manager | manager@example.com | manager123 |

## Role dan Hak Akses

| Role | Hak Akses |
|---|---|
| Admin | Dashboard, kategori, barang, peminjaman, laporan, profile |
| Staff | Dashboard, kategori, barang, peminjaman, profile |
| Manager | Dashboard, laporan, profile |

## Fitur Utama

### Authentication

Inventra menggunakan Laravel Breeze untuk fitur autentikasi.

Fitur autentikasi:

- Register
- Login
- Logout
- Forgot password
- Reset password melalui email
- Update profile
- Update password
- Hapus akun

### Email Registration Restriction

Registrasi publik hanya mengizinkan email dengan domain `@gmail.com`.

Jika pengguna register menggunakan email selain `@gmail.com`, sistem akan menampilkan pesan:

```txt
Harap gunakan email valid @gmail.com.
```

Akun demo berikut tetap dikecualikan agar dapat digunakan untuk kebutuhan testing role:

```txt
admin@example.com
staff@example.com
manager@example.com
```

Pembatasan email diterapkan pada register dan login. Akun non-Gmail yang bukan akun demo tidak dapat digunakan untuk login.

### Auto Logout

Inventra menerapkan auto logout jika pengguna tidak aktif selama 30 menit.

Aktivitas yang dihitung oleh sistem:

- Klik
- Scroll
- Input keyboard
- Sentuhan layar
- Pergerakan pointer

Jika tidak ada aktivitas selama 30 menit, pengguna akan diarahkan ke halaman login dan sistem menampilkan pesan:

```txt
Sesi Anda telah berakhir karena tidak ada aktivitas selama 30 menit. Silakan masuk kembali.
```

### Splash Screen Login

Halaman login memiliki splash screen berisi logo Inventra dan teks penyambut:

```txt
Selamat datang di aplikasi Inventra
```

Splash screen menggunakan animasi halus pada logo, teks, dan progress bar.

### Dashboard Inventaris

Dashboard menampilkan:

- Total barang
- Barang tersedia
- Barang dipinjam
- Transaksi selesai
- Grafik peminjaman bulanan
- Peminjaman terbaru
- Aksi cepat
- Notifikasi stok menipis
- Dark mode

### Manajemen Kategori

Fitur kategori:

- Daftar kategori
- Pencarian kategori
- Tambah kategori
- Edit kategori
- Hapus kategori
- Validasi kategori tidak dapat dihapus jika masih memiliki barang
- Detail kategori

### Detail Kategori

Halaman detail kategori menampilkan:

- Nama kategori
- Deskripsi kategori
- Jumlah barang dalam kategori
- Total stok tersedia
- Jumlah barang stok menipis
- Daftar barang dalam kategori

Setiap barang pada halaman detail kategori dapat diklik untuk membuka halaman detail barang.

Alur fitur:

```txt
Halaman Kategori
  |
  | Klik nama kategori atau tombol Detail
  v
Halaman Detail Kategori
  |
  | Klik salah satu barang
  v
Halaman Detail Barang
```

### Manajemen Barang

Fitur barang:

- Daftar barang
- Pencarian barang berdasarkan kode, nama, kategori, lokasi, dan kondisi
- Tambah barang
- Edit barang
- Detail barang
- Hapus barang
- Upload gambar barang ke Supabase Storage
- Filter stok menipis
- Pagination

Field barang:

- Kode barang
- Nama barang
- Kategori
- Deskripsi
- Stok siap dipinjam
- Minimum stok
- Stok rusak ringan
- Stok rusak berat
- Stok maintenance
- Lokasi penyimpanan
- Kondisi barang
- Gambar barang

### Model Stok Barang

Inventra membedakan stok berdasarkan kondisi barang.

| Jenis Stok | Keterangan |
|---|---|
| Stok siap dipinjam | Barang yang dapat dipinjam |
| Barang dipinjam | Barang yang sedang dipinjam |
| Rusak ringan | Barang rusak ringan |
| Rusak berat | Barang rusak berat |
| Maintenance | Barang dalam perawatan |
| Total fisik | Total stok fisik dari semua kondisi |
| Minimum stok | Batas minimum untuk notifikasi stok menipis |

### Manajemen Peminjaman

Fitur peminjaman:

- Riwayat peminjaman
- Pencarian peminjaman
- Tambah peminjaman
- Detail peminjaman
- Pengembalian barang
- Status peminjaman
- Pengurangan stok otomatis saat barang dipinjam
- Penambahan stok otomatis sesuai kondisi pengembalian

Field peminjaman:

- Nama peminjam
- Barang
- Jumlah barang
- Tanggal pinjam
- Tanggal kembali
- Status
- Catatan

### Pengembalian Barang

Saat barang dikembalikan, sistem memperbarui stok sesuai kondisi akhir.

| Kondisi Setelah Dikembalikan | Dampak pada Stok |
|---|---|
| Baik | Menambah stok siap dipinjam |
| Rusak Ringan | Menambah stok rusak ringan |
| Rusak Berat | Menambah stok rusak berat |
| Maintenance | Menambah stok maintenance |

### Laporan Inventaris

Fitur laporan:

- Ringkasan jumlah barang
- Ringkasan stok tersedia
- Ringkasan barang dipinjam
- Ringkasan total peminjaman
- Ringkasan keterlambatan
- Ringkasan transaksi selesai
- Grafik peminjaman bulanan
- Distribusi status peminjaman
- Daftar barang stok menipis
- Filter laporan berdasarkan tanggal dan status
- Cetak laporan
- Export laporan sebagai CSV yang dapat dibuka di Excel

### Notifikasi Stok Menipis

Inventra menyediakan notifikasi stok menipis pada dashboard.

Fitur notifikasi:

- Icon notifikasi
- Popup daftar stok menipis
- Link langsung ke detail barang
- Indikator stok berdasarkan `minimum_stock`

### Popup Sukses

Inventra menampilkan popup sukses saat pengguna berhasil menambahkan data utama seperti:

- Kategori
- Barang
- Peminjaman

Popup menampilkan ikon dan gambar checklist sebagai tanda proses berhasil.

### Dark Mode

Dark mode tersedia pada halaman utama aplikasi.

Cakupan dark mode:

- Dashboard
- Kategori
- Detail kategori
- Barang
- Peminjaman
- Laporan
- Profile
- Tabel
- Card
- Form

### REST API

Inventra menyediakan REST API untuk kebutuhan integrasi dengan aplikasi lain seperti mobile app, frontend terpisah, dashboard eksternal, scanner barcode, atau sistem otomasi.

Autentikasi API menggunakan Laravel Sanctum dengan Bearer Token.

## Teknologi yang Digunakan

| Teknologi | Fungsi |
|---|---|
| Laravel | Backend framework |
| Blade | Template engine |
| Tailwind CSS | Styling UI |
| Vite | Asset bundler |
| PostgreSQL Supabase | Database |
| Supabase Storage | Penyimpanan gambar barang |
| Laravel Breeze | Autentikasi web |
| Laravel Sanctum | Autentikasi API |
| Chart.js | Grafik dashboard dan laporan |
| Gmail SMTP | Pengiriman email reset password |
| Pest | Automated testing |
| PHPUnit | Test runner Laravel |

## Versi Pengembangan

| Komponen | Versi |
|---|---|
| PHP | 8.4.21 |
| Laravel Framework | 13.18.1 |
| Database | PostgreSQL Supabase |
| Frontend | Blade, Tailwind CSS, Vite |
| Testing | Pest, PHPUnit |

## Entity Relationship Diagram

Berikut adalah ERD dari sistem Inventra.

```txt
docs/erd-inventra.png
```

Jika file ERD tersedia di repository, gambar akan ditampilkan dengan path berikut:

![ERD Inventra](docs/erd-inventra.png)

## Struktur Database Utama

### roles

Menyimpan data role pengguna.

| Kolom | Tipe |
|---|---|
| id | bigint |
| name | varchar |
| created_at | timestamp |
| updated_at | timestamp |

### users

Menyimpan data pengguna.

| Kolom | Tipe |
|---|---|
| id | bigint |
| role_id | bigint |
| name | varchar |
| email | varchar |
| password | varchar |
| email_verified_at | timestamp |
| remember_token | varchar |
| created_at | timestamp |
| updated_at | timestamp |

### categories

Menyimpan data kategori barang.

| Kolom | Tipe |
|---|---|
| id | bigint |
| name | varchar |
| description | text |
| created_at | timestamp |
| updated_at | timestamp |

### products

Menyimpan data barang.

| Kolom | Tipe |
|---|---|
| id | bigint |
| category_id | bigint |
| code | varchar |
| name | varchar |
| description | text |
| stock | integer |
| minimum_stock | integer |
| light_damage_stock | integer |
| heavy_damage_stock | integer |
| maintenance_stock | integer |
| location | varchar |
| condition | varchar |
| image | varchar |
| created_at | timestamp |
| updated_at | timestamp |

### borrowings

Menyimpan data transaksi peminjaman.

| Kolom | Tipe |
|---|---|
| id | bigint |
| user_id | bigint |
| borrower_name | varchar |
| borrow_date | date |
| due_date | date |
| return_date | date |
| status | varchar |
| notes | text |
| created_at | timestamp |
| updated_at | timestamp |

### borrowing_details

Menyimpan detail barang yang dipinjam.

| Kolom | Tipe |
|---|---|
| id | bigint |
| borrowing_id | bigint |
| product_id | bigint |
| quantity | integer |
| condition_before | varchar |
| condition_after | varchar |
| notes | text |
| created_at | timestamp |
| updated_at | timestamp |

### personal_access_tokens

Menyimpan token API Laravel Sanctum.

| Kolom | Tipe |
|---|---|
| id | bigint |
| tokenable_type | varchar |
| tokenable_id | bigint |
| name | varchar |
| token | varchar |
| abilities | text |
| last_used_at | timestamp |
| expires_at | timestamp |
| created_at | timestamp |
| updated_at | timestamp |

## Relasi Database

| Relasi | Keterangan |
|---|---|
| roles 1 - N users | Satu role dapat dimiliki banyak user |
| users 1 - N borrowings | Satu user dapat membuat banyak peminjaman |
| categories 1 - N products | Satu kategori memiliki banyak barang |
| borrowings 1 - N borrowing_details | Satu peminjaman memiliki banyak detail |
| products 1 - N borrowing_details | Satu barang dapat muncul di banyak detail peminjaman |

## File Database SQL

File database hasil export tersedia pada:

```txt
database/inventra_database.sql
```

File ini digunakan sebagai output database untuk kebutuhan pengumpulan project.

Data yang tidak disertakan dalam export:

- Session
- Cache
- Job queue
- Failed jobs
- Password reset token
- Personal access token

Contoh command export database menggunakan `pg_dump`:

```bash
export PGSSLMODE=require

pg_dump \
  -h "HOST_POOLER_SUPABASE" \
  -p 5432 \
  -U "USERNAME_POOLER_SUPABASE" \
  -d "postgres" \
  --clean \
  --if-exists \
  --no-owner \
  --no-privileges \
  --exclude-table-data=personal_access_tokens \
  --exclude-table-data=password_reset_tokens \
  --exclude-table-data=sessions \
  --exclude-table-data=cache \
  --exclude-table-data=cache_locks \
  --exclude-table-data=jobs \
  --exclude-table-data=job_batches \
  --exclude-table-data=failed_jobs \
  -f database/inventra_database.sql
```

Jangan menulis password database langsung di command atau README.

## REST API Documentation

Base URL local:

```txt
http://127.0.0.1:8000/api
```

Base URL production:

```txt
https://inventra.koreacentral.cloudapp.azure.com/api
```

Semua endpoint selain login membutuhkan Bearer Token.

### Auth API

| Method | Endpoint | Keterangan |
|---|---|---|
| POST | /api/login | Login API dan membuat token |
| GET | /api/user | Mengambil data user login |
| POST | /api/logout | Logout API dan mencabut token |

Contoh login API menggunakan PowerShell:

```powershell
$body = @{
    email = "admin@example.com"
    password = "admin123"
    device_name = "Inventra API Test"
} | ConvertTo-Json

Invoke-RestMethod `
  -Method POST `
  -Uri "http://127.0.0.1:8000/api/login" `
  -Headers @{
      "Accept" = "application/json"
      "Content-Type" = "application/json"
  } `
  -Body $body
```

Contoh akses endpoint menggunakan token:

```powershell
Invoke-RestMethod `
  -Method GET `
  -Uri "http://127.0.0.1:8000/api/user" `
  -Headers @{
      "Accept" = "application/json"
      "Authorization" = "Bearer TOKEN_ANDA"
  }
```

### Category API

| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /api/categories | Menampilkan daftar kategori |
| POST | /api/categories | Menambah kategori |
| GET | /api/categories/{id} | Menampilkan detail kategori |
| PUT/PATCH | /api/categories/{id} | Mengubah kategori |
| DELETE | /api/categories/{id} | Menghapus kategori |

Contoh body tambah kategori:

```json
{
  "name": "Kategori API Test",
  "description": "Kategori dibuat melalui REST API"
}
```

### Product API

| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /api/products | Menampilkan daftar barang |
| POST | /api/products | Menambah barang |
| GET | /api/products/{id} | Menampilkan detail barang |
| PUT/PATCH | /api/products/{id} | Mengubah barang |
| DELETE | /api/products/{id} | Menghapus barang |

Filter stok menipis:

```txt
GET /api/products?low_stock=1
```

Contoh body tambah barang:

```json
{
  "category_id": 1,
  "code": "API-BRG-001",
  "name": "Barang API Test",
  "description": "Barang dibuat melalui REST API",
  "stock": 10,
  "minimum_stock": 5,
  "light_damage_stock": 0,
  "heavy_damage_stock": 0,
  "maintenance_stock": 0,
  "location": "Gudang API",
  "condition": "Baik"
}
```

### Borrowing API

| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /api/borrowings | Menampilkan daftar peminjaman |
| POST | /api/borrowings | Membuat peminjaman |
| GET | /api/borrowings/{id} | Menampilkan detail peminjaman |
| PATCH | /api/borrowings/{id}/return | Mengembalikan barang |

Contoh body tambah peminjaman:

```json
{
  "borrower_name": "Peminjam API Test",
  "borrow_date": "2026-07-05",
  "due_date": "2026-07-10",
  "notes": "Peminjaman dibuat melalui REST API",
  "details": [
    {
      "product_id": 1,
      "quantity": 1,
      "notes": "Barang dipinjam via API"
    }
  ]
}
```

Contoh body pengembalian:

```json
{
  "condition_after": "Baik",
  "return_notes": "Dikembalikan melalui REST API dalam kondisi baik"
}
```

### Report API

| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /api/reports | Menampilkan data laporan |

Filter laporan:

```txt
GET /api/reports?start_date=2026-07-01&end_date=2026-07-31
GET /api/reports?status=returned
```

## Automated Testing

Inventra dilengkapi automated testing menggunakan Pest dan PHPUnit.

Testing dibuat untuk memastikan fitur utama aplikasi berjalan sesuai requirement challenge, terutama pada bagian authentication, role access, master data kategori, master data barang, dashboard, laporan, REST API, profile, reset password, dan validasi stok barang.

Testing dijalankan menggunakan SQLite in-memory sehingga proses test tidak menyentuh database Supabase production.

### Tujuan Testing

Testing pada project ini digunakan untuk memverifikasi:

- Proses authentication berjalan dengan benar.
- Pembatasan register hanya untuk email `@gmail.com` berjalan sesuai aturan.
- Akun demo tetap dapat digunakan untuk login.
- Hak akses Admin, Staff, dan Manager berjalan sesuai role.
- CRUD kategori berjalan dengan benar.
- Detail kategori dapat menampilkan barang sesuai kategori.
- CRUD barang berjalan dengan benar.
- Dashboard dapat diakses oleh role yang sesuai.
- Laporan dapat diakses oleh Admin dan Manager.
- Export CSV laporan dapat dijalankan.
- Endpoint REST API utama dapat diakses menggunakan Laravel Sanctum.
- Profile management berjalan dengan benar.
- Forgot password dan reset password berjalan dengan benar.
- Accessor stok barang dapat menghitung status stok menipis dan stok tidak tersedia.

### Konfigurasi Testing

Konfigurasi testing berada pada file:

```txt
phpunit.xml
```

Konfigurasi penting:

```xml
<env name="APP_ENV" value="testing"/>
<env name="APP_DEBUG" value="true"/>
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
<env name="CACHE_STORE" value="array"/>
<env name="SESSION_DRIVER" value="array"/>
<env name="QUEUE_CONNECTION" value="sync"/>
<env name="MAIL_MAILER" value="array"/>
<env name="FILESYSTEM_DISK" value="local"/>
<env name="SESSION_LIFETIME" value="30"/>
```

Dengan konfigurasi tersebut, semua test berjalan pada database sementara di memory dan tidak memengaruhi data asli di Supabase.

### Struktur Folder Testing

```txt
tests/
├── Feature/
│   ├── Auth/
│   │   ├── AuthenticationTest.php
│   │   ├── EmailVerificationTest.php
│   │   ├── PasswordConfirmationTest.php
│   │   ├── PasswordResetTest.php
│   │   ├── PasswordUpdateTest.php
│   │   └── RegistrationTest.php
│   ├── ApiSmokeTest.php
│   ├── AuthEmailRestrictionTest.php
│   ├── CategoryCrudTest.php
│   ├── CategoryDetailTest.php
│   ├── DashboardAndReportTest.php
│   ├── ProductCrudTest.php
│   ├── ProfileTest.php
│   └── RoleAccessTest.php
│
├── Unit/
│   └── ProductStockAccessorTest.php
│
├── Pest.php
└── TestCase.php
```

### Cakupan Feature Test

| Test File | Cakupan |
|---|---|
| `tests/Feature/Auth/AuthenticationTest.php` | Login, gagal login, dan logout |
| `tests/Feature/Auth/EmailVerificationTest.php` | Halaman verifikasi email dan proses verifikasi |
| `tests/Feature/Auth/PasswordConfirmationTest.php` | Konfirmasi password |
| `tests/Feature/Auth/PasswordResetTest.php` | Forgot password dan reset password |
| `tests/Feature/Auth/PasswordUpdateTest.php` | Update password pengguna |
| `tests/Feature/Auth/RegistrationTest.php` | Register user baru menggunakan email Gmail |
| `tests/Feature/AuthEmailRestrictionTest.php` | Validasi email `@gmail.com`, pengecualian akun demo, dan blokir akun non-Gmail |
| `tests/Feature/RoleAccessTest.php` | Hak akses Admin, Staff, dan Manager |
| `tests/Feature/CategoryCrudTest.php` | Tambah, edit, hapus, validasi hapus, dan pencarian kategori |
| `tests/Feature/CategoryDetailTest.php` | Detail kategori dan daftar barang dalam kategori |
| `tests/Feature/ProductCrudTest.php` | Detail, tambah, edit, hapus, dan pencarian barang |
| `tests/Feature/DashboardAndReportTest.php` | Akses dashboard, laporan, dan export CSV |
| `tests/Feature/ApiSmokeTest.php` | Endpoint API user, categories, products, low stock products, dan reports |
| `tests/Feature/ProfileTest.php` | Halaman profile, update profile, dan hapus akun |

### Cakupan Unit Test

| Test File | Cakupan |
|---|---|
| `tests/Unit/ProductStockAccessorTest.php` | Pengujian accessor stok barang, status stok menipis, dan stok tidak tersedia |

### Detail Pengujian Penting

Beberapa skenario penting yang diuji:

- User dengan email selain `@gmail.com` tidak dapat melakukan register.
- User dengan email Gmail dapat register dan otomatis mendapatkan role Staff.
- Akun demo `admin@example.com`, `staff@example.com`, dan `manager@example.com` tetap dapat digunakan.
- Staff tidak dapat mengakses laporan.
- Manager tidak dapat mengakses kategori dan barang.
- Admin dapat mengakses fitur kategori, barang, peminjaman, dan laporan.
- Kategori yang masih memiliki barang tidak dapat dihapus.
- Barang dapat dibuat tanpa gambar.
- Barang dapat dicari berdasarkan keyword.
- Halaman detail kategori hanya menampilkan barang dari kategori terkait.
- API dapat mengembalikan data user login.
- API dapat menampilkan categories, products, low stock products, dan reports.
- Product accessor dapat mendeteksi stok menipis jika `stock <= minimum_stock`.

### Menjalankan Semua Test

```bash
php artisan test
```

Atau menggunakan Pest secara langsung:

```bash
./vendor/bin/pest
```

Pada Windows PowerShell:

```powershell
php artisan test
.\vendor\bin\pest
```

### Menjalankan Test Tertentu

```bash
php artisan test tests/Feature/AuthEmailRestrictionTest.php
php artisan test tests/Feature/RoleAccessTest.php
php artisan test tests/Feature/CategoryCrudTest.php
php artisan test tests/Feature/ProductCrudTest.php
php artisan test tests/Feature/ApiSmokeTest.php
php artisan test tests/Unit/ProductStockAccessorTest.php
```

### Hasil Testing Terbaru

Hasil testing terakhir:

```txt
Tests: 63 passed
Assertions: 150
Duration: 8.51s
```

Output tersebut menunjukkan seluruh automated test berhasil dijalankan tanpa error.

### Catatan Testing

- Testing tidak menggunakan database Supabase production.
- Testing menggunakan SQLite in-memory.
- Testing tidak mengirim email asli karena `MAIL_MAILER` menggunakan mode `array`.
- Testing tidak mengunggah file ke Supabase Storage karena `FILESYSTEM_DISK` menggunakan disk local.
- Testing dapat dijalankan secara lokal sebelum melakukan commit atau deployment.

## Instalasi Local

### 1. Clone Repository

```bash
git clone https://github.com/username/inventra.git
cd inventra
```

Ganti `username` dengan username GitHub kamu.

### 2. Install Dependency PHP

```bash
composer install
```

### 3. Install Dependency Frontend

```bash
npm install
```

### 4. Buat File Environment

Linux atau macOS:

```bash
cp .env.example .env
```

Windows PowerShell:

```powershell
copy .env.example .env
```

### 5. Generate App Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Ubah konfigurasi database pada file `.env`.

```env
DB_CONNECTION=pgsql
DB_HOST=your_database_host
DB_PORT=5432
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
DB_SSLMODE=require
```

### 7. Konfigurasi Session

```env
SESSION_LIFETIME=30
SESSION_EXPIRE_ON_CLOSE=false
```

### 8. Konfigurasi Supabase Storage

Tambahkan konfigurasi Supabase Storage pada `.env`.

```env
SUPABASE_STORAGE_BUCKET=product-images
SUPABASE_S3_ACCESS_KEY_ID=your_access_key
SUPABASE_S3_SECRET_ACCESS_KEY=your_secret_key
SUPABASE_S3_REGION=ap-northeast-1
SUPABASE_S3_ENDPOINT=https://your-project-ref.storage.supabase.co/storage/v1/s3
SUPABASE_STORAGE_PUBLIC_URL=https://your-project-ref.supabase.co/storage/v1/object/public/product-images
```

### 9. Konfigurasi Email

Contoh konfigurasi SMTP:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="Inventra"
```

### 10. Jalankan Migration dan Seeder

```bash
php artisan migrate --seed
```

### 11. Jalankan Development Server

```bash
php artisan serve
```

### 12. Jalankan Vite

```bash
npm run dev
```

Aplikasi local dapat diakses melalui:

```txt
http://127.0.0.1:8000
```

## Build Frontend

Untuk production build:

```bash
npm run build
```

## Perintah Penting

Clear cache Laravel:

```bash
php artisan optimize:clear
php artisan route:clear
php artisan view:clear
php artisan config:clear
```

Cek route web:

```bash
php artisan route:list
```

Cek route API:

```bash
php artisan route:list --path=api
```

Cek status migration:

```bash
php artisan migrate:status
```

Jalankan testing:

```bash
php artisan test
```

## Struktur Folder Penting

```txt
app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/

database/
├── factories/
├── migrations/
├── seeders/
└── inventra_database.sql

public/
├── images/

resources/
├── views/
│   ├── auth/
│   ├── categories/
│   ├── products/
│   ├── borrowings/
│   ├── reports/
│   ├── profile/
│   └── layouts/

routes/
├── web.php
└── api.php

tests/
├── Feature/
└── Unit/
```

## Deployment

Inventra telah berhasil dideploy ke Azure Virtual Machine.

Production URL:

```txt
https://inventra.koreacentral.cloudapp.azure.com
```

Aplikasi menggunakan HTTPS dengan SSL dari Let's Encrypt.

## Production Environment

Stack production:

- Azure Virtual Machine
- Ubuntu Server 24.04 LTS
- Nginx
- PHP 8.4 FPM
- Composer
- Node.js
- Laravel 13
- Supabase PostgreSQL
- Supabase Storage
- Supabase Session Pooler
- Let's Encrypt SSL
- Certbot

## Deployment Architecture

Inventra berjalan di Azure VM dengan Nginx sebagai web server. Nginx diarahkan ke folder `public` milik Laravel.

Database production menggunakan Supabase PostgreSQL. Untuk menghindari masalah koneksi IPv6 dari Azure VM ke Supabase, production menggunakan Supabase Session Pooler.

Penyimpanan gambar barang menggunakan Supabase Storage dengan konfigurasi S3-compatible storage disk pada Laravel.

Alur deployment production:

```txt
User
  |
  | HTTPS
  v
Azure VM
  |
  | Nginx
  v
Laravel Public Directory
  |
  | PHP 8.4 FPM
  v
Laravel Application
  |
  | PostgreSQL Session Pooler
  v
Supabase PostgreSQL

Laravel Application
  |
  | Supabase S3-compatible Storage
  v
Supabase Storage
```

## Production Configuration

Konfigurasi penting pada file `.env` production:

```env
APP_NAME=Inventra
APP_ENV=production
APP_DEBUG=false
APP_URL=https://inventra.koreacentral.cloudapp.azure.com

DB_CONNECTION=pgsql
DB_SSLMODE=require

SESSION_LIFETIME=30
SESSION_EXPIRE_ON_CLOSE=false
SESSION_SECURE_COOKIE=true
```

Nilai sensitif seperti database password, SMTP password, Supabase access key, Supabase secret key, dan credential lainnya hanya disimpan di file `.env` server.

File `.env` tidak disertakan dalam repository GitHub.

## SSL and HTTPS

Inventra menggunakan SSL gratis dari Let's Encrypt.

SSL dikonfigurasi menggunakan Certbot dan Nginx.

Aplikasi production harus diakses melalui:

```txt
https://inventra.koreacentral.cloudapp.azure.com
```

Alamat IP mentah hanya digunakan untuk kebutuhan teknis server.

## Server Directory

Project Inventra disimpan di server pada direktori:

```bash
/var/www/inventra
```

Nginx diarahkan ke:

```bash
/var/www/inventra/public
```

## Server Update Workflow

Setelah melakukan perubahan kode di lokal dan push ke GitHub, update aplikasi di server dengan langkah berikut:

```bash
cd /var/www/inventra

git pull origin main
npm install
npm run build

php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

sudo systemctl restart php8.4-fpm
sudo systemctl reload nginx
```

Gunakan workflow tersebut jika perubahan menyentuh:

- Blade view
- CSS
- JavaScript
- Controller
- Model
- Route
- Config
- Asset frontend
- File Laravel yang memengaruhi aplikasi

## Documentation Update Workflow

Jika perubahan hanya pada dokumentasi seperti `README.md`, server tidak wajib diupdate.

Cukup jalankan di lokal:

```bash
git add README.md
git commit -m "Update README documentation"
git push
```

Jika tetap ingin menyamakan isi repository di server, cukup jalankan:

```bash
cd /var/www/inventra
git pull origin main
```

Tidak perlu menjalankan:

```bash
npm install
npm run build
php artisan config:cache
sudo systemctl reload nginx
```

karena perubahan dokumentasi tidak memengaruhi aplikasi production.

## Production Server Commands

Cek status Nginx:

```bash
sudo systemctl status nginx --no-pager
```

Cek status PHP-FPM:

```bash
sudo systemctl status php8.4-fpm --no-pager
```

Cek status Laravel:

```bash
cd /var/www/inventra
php artisan about
```

Cek status migration:

```bash
cd /var/www/inventra
php artisan migrate:status
```

Cek log Laravel:

```bash
cd /var/www/inventra
tail -n 100 storage/logs/laravel.log
```

Cek log Nginx:

```bash
sudo tail -n 100 /var/log/nginx/error.log
```

Cek kapasitas disk:

```bash
df -h
```

Cek RAM dan swap:

```bash
free -h
```

## Production Deployment Notes

Catatan penting untuk production:

- `APP_ENV` harus bernilai `production`.
- `APP_DEBUG` harus bernilai `false`.
- `APP_URL` harus memakai URL HTTPS production.
- Database Supabase di server menggunakan Session Pooler.
- HTTPS dikelola dengan Certbot.
- File `.env` production hanya boleh ada di server.
- SSH private key tidak boleh masuk ke repository.
- Jangan menjalankan `php artisan migrate:fresh` di production karena akan menghapus data.

## Security Notes

Repository ini tidak menyertakan file atau credential sensitif seperti:

- `.env`
- SSH private key
- Database password
- SMTP password
- Supabase access key
- Supabase secret key
- Azure credential

Pastikan nilai berikut tidak pernah dipush ke GitHub:

```txt
DB_PASSWORD
MAIL_PASSWORD
SUPABASE_S3_ACCESS_KEY_ID
SUPABASE_S3_SECRET_ACCESS_KEY
```

Keamanan aplikasi:

- Registrasi publik dibatasi hanya untuk email `@gmail.com`.
- Akun demo dikecualikan untuk kebutuhan testing role.
- Akun non-Gmail yang bukan akun demo tidak dapat login.
- Session otomatis berakhir setelah 30 menit tidak aktif.
- Production menggunakan HTTPS.
- API menggunakan Bearer Token dari Laravel Sanctum.
- File `.env` tidak masuk repository.

## Output Pengumpulan

Output project:

| Output | Status |
|---|---|
| Source code GitHub | Tersedia |
| Hosting atau demo link | Tersedia |
| File database `.sql` | Tersedia di `database/inventra_database.sql` |
| Dokumentasi API | Tersedia di README |
| README instalasi dan penggunaan | Tersedia |
| Akun login testing | Tersedia |
| Link demo production | Tersedia |
| Automated testing | Tersedia menggunakan Pest |

## Final Deployment Status

Status deployment Inventra:

```txt
Status          : Deployed
Platform        : Azure Virtual Machine
OS              : Ubuntu Server 24.04 LTS
Web Server      : Nginx
Runtime         : PHP 8.4 FPM
Framework       : Laravel 13.18.1
Database        : Supabase PostgreSQL
Storage         : Supabase Storage
SSL             : Let's Encrypt
Domain          : inventra.koreacentral.cloudapp.azure.com
Production URL  : https://inventra.koreacentral.cloudapp.azure.com
Session Timeout : 30 minutes
Testing         : 63 passed, 150 assertions
```



## Author

Alamsyah Mubarok

Project ini dibuat untuk kebutuhan Inventory Management Challenge.
