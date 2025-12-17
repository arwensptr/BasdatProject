# FARMACHEAT: SISTEM INFORMASI APOTEK ONLINE

**FarmaCheat** adalah aplikasi berbasis web yang dirancang untuk mempermudah transaksi jual beli obat, baik obat bebas maupun obat resep dokter. Aplikasi ini juga dilengkapi dengan dashboard analitik untuk memantau performa penjualan dan inventaris.

---

## Identitas Kelompok

**Nomor Kelompok:** J

**Anggota Kelompok:**
1. FIRMAN HASIBUAN (164221051)
2. SHIDQY BAIHAQY EL MUHAMMADY (164231016)
3. ARWEN SUTANTO PUTRA (164231041)
4. ANELIA IKA SHAFIYAH (164231078)
5. MUHAMMAD ILHAM GUSTAMI (164231089)

---

## Fitur Utama

### Halaman Pengguna (Customer)
- **Katalog Obat:** Pencarian dan filter obat berdasarkan kategori.
- **Upload Resep:** Mengunggah foto resep dokter untuk diperiksa apoteker.
- **Keranjang & Checkout:** Transaksi pembelian obat.
- **Upload Bukti Bayar:** Konfirmasi pembayaran manual.
- **Riwayat Pesanan:** Melacak status pesanan (Pending, Dikirim, Selesai).

### Halaman Admin (Apoteker/Manajer)
- **Manajemen Inventaris:** CRUD Data Obat, Kategori, dan Stok.
- **Verifikasi Resep:** Menyetujui atau menolak resep yang diunggah user.
- **Verifikasi Pembayaran:** Memeriksa bukti transfer pelanggan.
- **Dashboard Analitik (OLAP):** Grafik penjualan, tren pendapatan, dan obat terlaris (Terintegrasi Data Warehouse).

---

## Teknologi & Library

**Backend:**
- Laravel Framework (^12.0)
- Laravel Breeze (Authentication)
- Laravel Sail (Docker support)
- FakerPHP (Data Seeding)
- PHPUnit (Testing)

**Frontend:**
- Tailwind CSS
- Alpine.js
- Vite
- Axios

**Database & Tools:**
- MySQL (OLTP)
- Pentaho Data Integration (ETL - Optional)
- MySQL Data Warehouse (OLAP - Optional)

---

## Persyaratan Sistem (Requirements)

Sebelum menginstall, pastikan PC anda memiliki:
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL

---

## Tata Cara Instalasi (Installation Guide)

Ikuti langkah-langkah berikut untuk menjalankan project di local machine:

### 1. Clone & Install Dependencies
Buka terminal di folder project, lalu jalankan perintah berikut secara berurutan:

composer install
npm install

### 2. Konfigurasi Environment
Salin file .env.example menjadi .env dan generate key aplikasi:

cp .env.example .env
php artisan key:generate

### 3. Setup Database & Storage
Pastikan database kosong sudah dibuat di MySQL, lalu jalankan migrasi dan seeder:

php artisan migrate --seed
php artisan storage:link

### 4. Menjalankan Aplikasi
Buka dua terminal berbeda untuk menjalankan server dan assets:

Terminal 1 (Laravel Server):
php artisan serve

Terminal 2 (Vite Assets):
npm run dev

Akses aplikasi di browser melalui: http://127.0.0.1:8000/

Akun Demo (Default Credentials)
Setelah menjalankan php artisan migrate --seed, gunakan akun berikut untuk login:

1. Akun Admin:

Email: admin@demo.test

Password: password

2. Akun User (Contoh):

Email: Customer@demo.test

Password: password

atau bisa membuat akun baru.
