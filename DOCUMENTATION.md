# Website Penyewaan Alat Camping dan Naik Gunung

Website penyewaan alat camping dan naik gunung dibangun menggunakan Laravel 11 dengan fitur lengkap untuk manajemen penyewaan peralatan outdoor.

## Fitur Utama

### Admin
- Dashboard dengan statistik lengkap
- Manajemen kategori alat
- Manajemen alat camping (CRUD)
- Manajemen penyewaan (Approve, Activate, Complete, Reject)
- Laporan transaksi dengan filter tanggal
- Monitoring stok alat

### User
- Registrasi dan login
- Browse alat camping berdasarkan kategori
- Pencarian alat
- Detail alat dengan rating dan review
- Pemesanan penyewaan dengan perhitungan otomatis
- Tracking status penyewaan
- Memberikan rating dan ulasan setelah penyewaan selesai

## Teknologi yang Digunakan

- **Backend**: Laravel 11
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Bootstrap Icons
- **Server Lokal**: Laragon
- **Text Editor**: Visual Studio Code

## Instalasi

### Prasyarat
- Laragon atau XAMPP/WAMP
- PHP >= 8.2
- Composer
- MySQL

### Langkah Instalasi

1. **Clone atau copy project ke folder laragon**
   ```bash
   cd c:\laragon\www\sewa-camping
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Copy file environment**
   ```bash
   copy .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Konfigurasi database di file .env**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sewa_camping
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Buat database**
   - Buka phpMyAdmin atau MySQL client
   - Buat database baru dengan nama `sewa_camping`

7. **Jalankan migrasi dan seeder**
   ```bash
   php artisan migrate --seed
   ```

8. **Buat symbolic link untuk storage**
   ```bash
   php artisan storage:link
   ```

9. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```

10. **Akses aplikasi**
    - Website: http://localhost:8000
    - Admin: http://localhost:8000/admin/dashboard

## Akun Default

### Admin
- Email: admin@sewacamping.com
- Password: admin123

### User
- Email: user@example.com
- Password: password

## Struktur Database

### Tabel Users
- Role: admin, user
- Menyimpan data pengguna, admin, dan pelanggan

### Tabel Categories
- Kategori peralatan camping

### Tabel Equipment
- Data alat camping
- Relasi dengan categories
- Tracking stok dan ketersediaan

### Tabel Rentals
- Data penyewaan
- Status: pending, approved, active, completed, cancelled
- Relasi dengan users dan equipment

### Tabel Reviews
- Rating dan ulasan
- Relasi dengan rentals, users, dan equipment

## Alur Sistem

### Proses Penyewaan
1. User registrasi/login
2. User memilih alat dan mengisi form penyewaan
3. Sistem menghitung total harga otomatis
4. User submit pesanan (status: pending)
5. Admin menerima notifikasi pesanan baru
6. Admin approve/reject pesanan
7. Jika approved, admin mengaktifkan penyewaan saat alat diserahkan
8. Setelah masa sewa selesai, admin menandai penyewaan sebagai completed
9. User dapat memberikan rating dan review

### Manajemen Stok
- Stok berkurang otomatis saat pesanan dibuat
- Stok kembali saat pesanan dibatalkan atau selesai
- Alert stok menipis di dashboard admin

## Fitur Keamanan

- Password hashing menggunakan bcrypt
- CSRF protection
- Middleware authentication
- Role-based access control (admin & user)
- SQL injection prevention (Eloquent ORM)
- XSS protection

## Pengembangan Lebih Lanjut

Fitur yang dapat ditambahkan:
- Payment gateway integration
- Email notification
- WhatsApp notification
- Export laporan ke PDF/Excel
- Multiple image upload untuk equipment
- Chat customer service
- Wishlist/favorite
- Recommendation system

## Troubleshooting

### Error 500
- Pastikan file .env sudah dikonfigurasi dengan benar
- Jalankan: `php artisan config:clear`
- Jalankan: `php artisan cache:clear`

### Gambar tidak muncul
- Pastikan sudah menjalankan: `php artisan storage:link`
- Periksa permission folder storage

### Database connection error
- Pastikan MySQL sudah berjalan
- Periksa konfigurasi database di .env
- Pastikan database sudah dibuat

## Lisensi

Project ini dibuat untuk keperluan pembelajaran dan pengembangan sistem penyewaan alat camping.

## Kontak

Untuk pertanyaan dan support, hubungi:
- Email: info@sewacamping.com
- Phone: +62 812-3456-7890
