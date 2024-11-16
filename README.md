# 🌟 Sistem Manajemen Magang

Selamat datang di Sistem Manajemen Magang! 🎉

## Deskripsi Proyek

Sistem Manajemen Magang adalah aplikasi berbasis Laravel yang dirancang untuk memudahkan pengelolaan absensi peserta magang dan pengunggahan laporan magang. Proyek ini bertujuan untuk menciptakan pengelolaan yang efisien, transparan, dan terstruktur dalam mengelola peserta magang dan laporan mereka.

## Instalasi

1. Clone repositori ini:
   ```bash
   git clone https://github.com/dhindonk/laravel-manajemen-magang.git
2. Masuk ke direktori proyek:
   ```bash
   cd laravel-manajemen-magang
3. 
   ```bash
   composer install
4.  
   ```bash
   cp .env.example .env
5. 
   ```bash
   php artisan key:generate
6. Open .env
   Sesuaikan konfigurasi database di file .env
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db-magang
   DB_USERNAME=root
   DB_PASSWORD=
7.
   ```bash
   php artisan migrate --seed
8.
   ```bash
   php artisan serve
