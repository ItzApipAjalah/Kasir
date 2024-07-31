# Kasir Laravel

## Deskripsi Proyek

Kasir Laravel adalah aplikasi berbasis web yang dirancang untuk membantu pemilik usaha dalam proses transaksi penjualan. Aplikasi ini dibuat menggunakan framework Laravel dan menyediakan antarmuka yang mudah digunakan untuk manajemen penjualan, inventaris, dan laporan keuangan.

### Fitur Utama

- **Manajemen Penjualan**: Tambah, edit, dan hapus transaksi penjualan dengan mudah.
- **Manajemen Inventaris**: Kelola produk, termasuk menambah, mengedit, dan menghapus item inventaris.
- **Laporan Keuangan**: Lihat laporan penjualan dan ringkasan keuangan untuk periode tertentu.
- **Autentikasi Pengguna**: Sistem login dan registrasi untuk mengamankan akses aplikasi.

### Instalasi

Ikuti langkah-langkah berikut untuk menginstal dan menjalankan aplikasi ini di lingkungan lokal Anda.

1. **Clone Repositori**

    ```bash
    git clone https://github.com/ItzApipAjalah/Kasir.git
    ```

2. **Masuk ke Direktori Proyek**

    ```bash
    cd kasir-laravel
    ```

3. **Instal Dependensi**

    Pastikan Anda telah menginstal Composer. Kemudian jalankan:

    ```bash
    composer install
    ```

4. **Buat Salinan File `.env`**

    Salin file `.env.example` ke `.env`:

    ```bash
    cp .env.example .env
    ```

5. **Generate Kunci Aplikasi**

    ```bash
    php artisan key:generate
    ```

6. **Konfigurasi Database**

    Edit file `.env` dan sesuaikan pengaturan database sesuai dengan konfigurasi Anda. Misalnya:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=kasir_laravel
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7. **Migrasi Database**

    Jalankan migrasi untuk membuat tabel di database:

    ```bash
    php artisan migrate
    ```

8. **Jalankan Server**

    Jalankan server lokal:

    ```bash
    php artisan serve
    ```

    Aplikasi akan tersedia di `http://localhost:8000`.

### Penggunaan

1. **Akses Aplikasi**

    Buka aplikasi di browser dan masuk menggunakan akun admin yang telah Anda buat.

2. **Manajemen Penjualan**

    Navigasikan ke bagian penjualan untuk menambahkan, mengedit, dan menghapus transaksi penjualan.

3. **Manajemen Inventaris**

    Kelola produk dan item inventaris dari antarmuka yang disediakan.

4. **Laporan Keuangan**

    Lihat laporan keuangan dan ringkasan penjualan di menu laporan.
