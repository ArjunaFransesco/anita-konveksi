# Panduan Hosting Dua Domain - Anita Konveksi

Project ini sudah disiapkan agar satu aplikasi Laravel dan satu database dipakai oleh:

- Domain utama: landing page / company profile.
- Subdomain staf: langsung menuju halaman login owner/admin.

## Persyaratan hosting

- PHP 8.3 atau lebih baru.
- MySQL/MariaDB.
- Composer 2.
- Ekstensi PHP umum Laravel: BCMath, Ctype, cURL, DOM, Fileinfo, Mbstring, OpenSSL, PDO, Tokenizer, XML.
- Akses SSH/Terminal sangat disarankan.
- SSL untuk domain utama dan subdomain staf.

## 1. Upload project

Upload folder project di luar folder publik apabila panel hosting memungkinkan. Document root kedua host harus mengarah ke folder `public` project ini.

Contoh:

- `domainutama.com` -> `/home/user/project-anita-konveksi/public`
- `staff.domainutama.com` -> `/home/user/project-anita-konveksi/public`

Kedua domain harus menunjuk ke folder `public` yang sama.

## 2. Instal dependency

Dari terminal, masuk ke folder project lalu jalankan:

```bash
composer install --no-dev --optimize-autoloader
```

## 3. Buat file .env

Salin `.env.hosting.example` menjadi `.env`, kemudian isi domain dan database yang sebenarnya.

Bagian penting:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domainutama.com

DOMAIN_ROUTING_ENABLED=true
PUBLIC_DOMAIN=domainutama.com
STAFF_DOMAIN=staff.domainutama.com

SESSION_DOMAIN=null
SESSION_SECURE_COOKIE=true
```

Nama domain ditulis tanpa `https://` dan tanpa `/` di belakang.

Generate application key apabila APP_KEY masih kosong:

```bash
php artisan key:generate
```

## 4. Import database

Buat satu database MySQL dari panel hosting, lalu import:

`database/hosting/anita_konveksi_import.sql`

File import sudah tidak berisi perintah `CREATE DATABASE` dan `USE`, sehingga lebih cocok untuk shared hosting.

## 5. Permission dan optimasi

```bash
chmod -R 775 storage bootstrap/cache
php artisan storage:link
php artisan optimize:clear
php artisan optimize
```

Jangan menjalankan `migrate:fresh` karena akan menghapus data.

## 6. Pengujian

- Buka `https://domainutama.com` -> landing page.
- `https://domainutama.com/login` -> tidak tersedia.
- Buka `https://staff.domainutama.com` -> otomatis ke login staf.
- Login owner/admin -> masuk ke dashboard sesuai role.

## Mode lokal

Secara default `.env.example` tidak mengaktifkan routing domain. Dengan demikian:

- `http://127.0.0.1:8000/` -> landing page.
- `http://127.0.0.1:8000/login` -> login staf.

Aktifkan pemisahan domain hanya ketika domain dan subdomain di hosting sudah siap.
