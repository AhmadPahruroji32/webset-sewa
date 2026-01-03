# TROUBLESHOOTING GUIDE - Website Sewa Camping

## ✅ Perbaikan yang Sudah Dilakukan

### 1. **Fix Equipment Model**
- Mengubah `averageRating()` dan `totalReviews()` menjadi attribute accessors
- Sekarang bisa dipanggil sebagai `$equipment->average_rating` dan `$equipment->total_reviews`

### 2. **Fix Rental Validation**
- Memperbaiki validasi tanggal dari `after_or_equal:today` ke `after_or_equal:` + tanggal saat ini
- Menambahkan error message yang lebih jelas untuk stok tidak cukup

### 3. **Fix Admin Middleware**
- Mengubah `abort(403)` menjadi redirect yang user-friendly
- Admin yang belum login akan diredirect ke halaman login
- User biasa yang coba akses admin akan diredirect ke home

### 4. **Fix Equipment Stock Management**
- Memperbaiki perhitungan available_stock saat update equipment
- Mempertimbangkan jumlah yang sedang disewa

### 5. **Storage Setup**
- Memastikan storage link sudah dibuat
- Membuat directory equipment untuk menyimpan gambar

## 🧪 Testing

Jalankan command test untuk memverifikasi sistem:

```bash
php artisan test:system
```

Expected output:
- ✓ Admin user exists
- ✓ Admin password correct
- ✓ Total equipment: 12
- ✓ Storage link exists
- ✓ Equipment directory exists

## 🔐 Kredensial Login

### Admin
- URL: http://localhost:8000/login
- Email: `admin@sewacamping.com`
- Password: `admin123`

### User Test
- Email: `user@example.com`
- Password: `password`

## 📝 Cara Test Fitur

### Test Login Admin
1. Buka http://localhost:8000/login
2. Login dengan admin credentials
3. Seharusnya redirect ke http://localhost:8000/admin/dashboard

### Test Tambah Equipment (Admin)
1. Login sebagai admin
2. Klik menu "Alat Camping" 
3. Klik "Tambah Alat"
4. Isi semua field (gambar optional)
5. Submit - seharusnya berhasil

### Test Update Stock (Admin)
1. Login sebagai admin
2. Klik menu "Alat Camping"
3. Klik icon edit pada salah satu alat
4. Ubah stock (misal dari 10 jadi 15)
5. Submit - stok available akan disesuaikan otomatis

### Test Penyewaan (User)
1. Logout dari admin
2. Login sebagai user atau register baru
3. Browse equipment
4. Klik "Detail" pada salah satu alat
5. Klik "Sewa Sekarang"
6. Isi form:
   - Jumlah: 1
   - Tanggal Mulai: pilih tanggal hari ini atau setelahnya
   - Tanggal Selesai: pilih tanggal setelah tanggal mulai
7. Submit - seharusnya berhasil dan status "Menunggu Persetujuan"

### Test Approval (Admin)
1. Login sebagai admin
2. Klik menu "Penyewaan"
3. Klik icon mata pada penyewaan yang pending
4. Klik "Setujui Pesanan"
5. Status berubah jadi "Disetujui"

## 🐛 Error yang Mungkin Terjadi

### Error: "Storage link not found"
**Solusi:**
```bash
php artisan storage:link
```

### Error: "Class 'Equipment' not found"
**Solusi:**
```bash
composer dump-autoload
php artisan config:clear
```

### Error: "SQLSTATE[HY000] [1045]"
**Solusi:**
- Cek database credentials di .env
- Pastikan MySQL service berjalan
- Pastikan database 'sewa_camping' sudah dibuat

### Error: Validation "after_or_equal:today"
**Solusi:** Sudah diperbaiki! Gunakan format date yang benar di form.

### Error: "Call to undefined method averageRating()"
**Solusi:** Sudah diperbaiki! Sekarang gunakan `$equipment->average_rating` (property, bukan method)

### Gambar tidak muncul
**Solusi:**
```bash
# Pastikan storage link ada
php artisan storage:link

# Pastikan directory ada
mkdir storage/app/public/equipment
```

## 🔧 Commands Penting

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Test system
php artisan test:system

# Check routes
php artisan route:list

# Check migrations
php artisan migrate:status

# Rollback and migrate fresh with seed
php artisan migrate:fresh --seed
```

## ✅ Checklist Sebelum Test

- [ ] Laravel server running (`php artisan serve`)
- [ ] MySQL service running
- [ ] Database 'sewa_camping' created
- [ ] Migrations ran (`php artisan migrate`)
- [ ] Seeders ran (`php artisan db:seed`)
- [ ] Storage link created (`php artisan storage:link`)
- [ ] All caches cleared

## 📞 Support

Jika masih ada error:
1. Cek file `storage/logs/laravel.log`
2. Screenshot error message
3. Cek browser console untuk JavaScript errors
4. Pastikan semua langkah di checklist sudah dilakukan
