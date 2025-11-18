# 🏥 Sistem Antrian Pasien Klinik – Laravel 12

Sistem antrian pasien berbasis website menggunakan **Laravel 12**.  
Pasien dapat mengambil nomor antrian **tanpa login**, dan admin dapat mengelola antrian melalui panel khusus.

---

## 📌 Fitur Utama

### 👥 Fitur Pasien

-   Mengambil nomor antrian tanpa login
-   Barcode otomatis dihasilkan untuk setiap antrian
-   Informasi yang tampil di tiket antrian:
    -   Nomor antrian
    -   Poli
    -   Loket
    -   Jenis pembayaran (BPJS / Umum)
    -   Estimasi waktu panggilan
    -   Nomor yang sedang dipanggil
    -   Jumlah pasien yang menunggu di depan
    -   Daftar berkas yang harus dibawa (otomatis, mengikuti jenis pembayaran)
-   Cek posisi antrian dengan 2 pilihan:
    -   Nomor Antrian
    -   NIK
-   Halaman hasil cek antrian menampilkan:
    -   Detail antrian
    -   Posisi antrian terkini
    -   Barcode untuk keperluan scan ulang di loket

---

### 🛠️ Fitur Admin

-   Login admin
-   Manajemen data poli:
    -   Nama poli
    -   Loket (ditampilkan juga di tiket pasien)
-   Manajemen antrian harian:
    -   Panggil pasien
    -   Tandai antrian sebagai selesai
    -   Filter data berdasarkan poli & tanggal
-   Menampilkan ringkasan total pasien per hari
-   Tabel antrian dengan status:
    -   Menunggu
    -   Dipanggil
    -   Selesai

---

## 📦 Teknologi yang Digunakan

-   Laravel **12.x**
-   PHP **8.2+**
-   MySQL
-   Bootstrap 5 (template admin)
-   [milon/barcode](https://github.com/milon/barcode) untuk generate barcode
-   [Carbon](https://carbon.nesbot.com/) untuk manipulasi date/time

---

## 📁 Struktur Folder (Singkat)

```text
app/
    Http/Controllers/
        Admin/
        AntrianController.php
    Models/
        Antrian.php
        Poli.php

resources/
    views/
        antrian/
            form.blade.php
            tiket.blade.php
            cek.blade.php
            hasil_cek.blade.php
        admin/
            antrian/
            poli/

routes/
    web.php

database/
    migrations/
    seeders/

🔧 Cara Install
1. Clone / extract project
git clone <repo-anda>.git
cd <nama-folder-project>

atau extract file ZIP ke folder yang diinginkan.

2. Install dependency PHP & JS
composer install
npm install
npm run build

3. Copy file environment
cp .env.example .env

4. Atur konfigurasi database di file .env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=antrian-pasien
DB_USERNAME=root
DB_PASSWORD=

(Sesuaikan DB_DATABASE, DB_USERNAME, dan DB_PASSWORD dengan pengaturan lokal Anda.)

5. Generate application key
php artisan key:generate

6. Jalankan migrasi & seeder
php artisan migrate --seed

7. Jalankan server lokal
php artisan serve

Aplikasi biasanya dapat diakses di:
http://127.0.0.1:8000

🧪 Akun Admin (contoh)

Gunakan akun berikut untuk login ke halaman admin:

Email    : admin@example.com
Password : password123


Ganti dengan data akun admin sebenarnya sesuai seeder/proyek Anda.
```
