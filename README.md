# Proyek IT Fullstack Developer - PT Aneka Search Indonesia

Repositori ini dibuat untuk mengerjakan tes teknis posisi **IT Fullstack Developer** di **PT Aneka Search Indonesia**. Proyek ini bertujuan membangun aplikasi web sederhana menggunakan **Laravel** sebagai backend, **PostgreSQL** sebagai database, **Redis** sebagai cache system, dan **Amazon S3** untuk manajemen file storage.

**Jawaban ada di: app/Http/Controllers/MyClientController.php**

## Fitur Utama

- **CRUD** data klien
- **Soft delete** dengan `deleted_at`
- **Validasi data** sesuai kebutuhan field
- **Redis cache** untuk menyimpan data klien berdasarkan `slug`
- **Amazon S3** untuk menyimpan file logo klien

## Instalasi

1. **Clone repositori**
   ```bash
   git clone https://github.com/novirachmahwati/php-fullstact-test
   cd php-fullstact-test
   ```

2. **Install dependency**
   ```bash
   composer install
   npm install
   ```

3. **Buat file `.env`**
   ```bash
   cp .env.example .env
   ```

4. **Atur konfigurasi database** di `.env`:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=nama_database
   DB_USERNAME=username
   DB_PASSWORD=password
   ```

5. **Atur konfigurasi Redis** di `.env`:
   ```env
   CACHE_DRIVER=redis
   REDIS_HOST=127.0.0.1
   REDIS_PASSWORD=null
   REDIS_PORT=6379
   ```

6. **Atur konfigurasi Amazon S3** di `.env`:
   ```env
   FILESYSTEM_DISK=s3
   AWS_ACCESS_KEY_ID=your_access_key
   AWS_SECRET_ACCESS_KEY=your_secret_key
   AWS_DEFAULT_REGION=your_region
   AWS_BUCKET=your_bucket
   ```

7. **Jalankan migration**
   ```bash
   php artisan migrate
   ```

8. **Jalankan server lokal**
   ```bash
   php artisan serve
   ```

## Endpoint API

- **GET** `/api/clients` → Menampilkan semua klien
- **POST** `/api/clients` → Menambah klien baru
- **GET** `/api/clients/{id}` → Menampilkan detail klien
- **PUT** `/api/clients/{id}` → Mengupdate klien
- **DELETE** `/api/clients/{id}` → Soft delete klien

## Penutup

Proyek ini dibuat sebagai bagian dari tes teknis. Semua feedback dan saran sangat dihargai. 🚀

