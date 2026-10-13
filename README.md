# SIRSA

SIRSA adalah aplikasi pengaduan Desa Pangkah berbasis Laravel 13.

## Requirement

- PHP `>= 8.3` beserta ekstensi PHP yang dibutuhkan Laravel.
- Composer `2.x`.
- Node.js `^20.19` atau `>= 22.12` (disarankan menggunakan versi LTS terbaru).
- npm (sudah termasuk ketika memasang Node.js).
- MySQL atau MariaDB.

Cek versi yang sudah terpasang:

```bash
php -v
composer --version
node -v
npm -v
```

## Rekomendasi: Laravel Herd

Cara paling praktis menjalankan proyek ini di Windows atau macOS adalah menggunakan [Laravel Herd](https://herd.laravel.com/). Herd menyediakan PHP, Composer, Node.js, npm, Nginx, serta pengelolaan versi PHP dalam satu aplikasi, sehingga tidak perlu melakukan konfigurasi web server secara manual.

Jika tidak menggunakan Herd, instal PHP, Composer, Node.js, npm, dan MySQL secara manual. Composer dapat diunduh melalui [dokumentasi resminya](https://getcomposer.org/download/) dan Node.js melalui [halaman unduhan resmi](https://nodejs.org/en/download).

Untuk panduan instalasi PHP, Composer dan environment Laravel secara lengkap sesuai sistem operasi yang digunakan, silakan merujuk ke [dokumentasi instalasi Laravel 13](https://laravel.com/framework/docs/13.x/installation#installing-php).

## Instalasi Proyek

Clone repository SIRSA dari GitHub:

```bash
git clone https://github.com/Hikuroshi/sirsa.git
```

Masuk ke direktori proyek:

```bash
cd sirsa
```

Pastikan MySQL atau MariaDB berjalan. Setelah itu, jalankan seluruh proses setup dengan satu perintah:

```bash
composer run setup
```

Perintah tersebut otomatis menginstal dependency Composer dan npm, membuat `.env`, generate application key, membuat database, menjalankan migration dan seeder, serta build asset frontend.

## Konfigurasi AI (opsional)

Aplikasi tetap bisa menerima laporan tanpa AI. Untuk mengaktifkannya, tambahkan satu atau beberapa blok berikut ke `.env`:

```dotenv
AI_1_NAME="Kunci utama"
AI_1_PROVIDER=gemini
AI_1_MODEL=nama-model-dari-provider
AI_1_KEY=api-key-anda
AI_1_RPM=10
AI_1_RPD=1000
AI_1_TPM=100000

AI_2_NAME="Kunci cadangan"
AI_2_PROVIDER=gemini
AI_2_MODEL=nama-model-cadangan
AI_2_KEY=api-key-cadangan
AI_2_RPM=10
AI_2_RPD=1000
AI_2_TPM=100000
```

Provider yang tersedia saat ini: `gemini`. Nilai model dan limit diisi sesuai akun provider Anda; angka di atas hanya contoh. Jumlah slot tidak dibatasi. Nomor boleh melompat dan angka terkecil dicoba lebih dulu. Bila satu slot penuh atau gagal, slot berikutnya dicoba, termasuk jika provider atau modelnya berbeda. Slot yang tidak lengkap diabaikan. Jangan bagikan `.env` atau cache konfigurasi karena keduanya memuat API key.

Setelah mengubah `.env` pada deployment yang memakai cache konfigurasi, jalankan `php artisan config:cache` dan mulai ulang worker queue. Laporan yang sudah berstatus `Tidak Aktif` tidak diproses AI secara otomatis.

Data login bawaan dari seeder:

```text
Username : testuser
Password : password
```

## Menjalankan Aplikasi

Jalankan server aplikasi dengan:

```bash
php artisan serve
```

Buka alamat yang tampil di terminal, biasanya:

```text
http://localhost:8000
```

### Menggunakan Laravel Herd

Dari direktori proyek, ketik perintah berikut untuk hubungkan proyek ke Herd lalu buka di browser:

```bash
herd link

herd open
```

### Menjalankan worker queue

Jalankan worker queue untuk memroses laporan:

```bash
php artisan queue:work
```
