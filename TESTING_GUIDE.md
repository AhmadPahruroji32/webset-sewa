# Panduan Testing Website Sewa Camping

## ✅ Perbaikan yang Telah Dilakukan

### 1. Fixed RentalController Error
- **Masalah**: `Call to undefined method App\Http\Controllers\RentalController::middleware()`
- **Penyebab**: Constructor dengan `$this->middleware('auth')` tidak diperlukan karena middleware sudah diaplikasikan di routes
- **Solusi**: Menghapus constructor dari RentalController
- **Status**: ✅ FIXED

### 2. Admin CRUD Interface
- **Status**: ✅ TERSEDIA
- Routes: Semua route admin CRUD sudah terdaftar
- Views: Semua view admin sudah ada
- Navigation: Sidebar admin sudah memiliki link ke semua menu

## 🧪 Cara Testing

### A. Testing Login Admin

1. **Buka browser dan akses**: `http://localhost/sewa-camping/public/login`

2. **Login dengan kredensial admin**:
   - Email: `admin@sewacamping.com`
   - Password: `admin123`

3. **Setelah login, Anda akan diarahkan ke**: `/admin/dashboard`

4. **Verifikasi menu sidebar kiri**:
   - ✓ Dashboard
   - ✓ Kategori
   - ✓ Alat Camping
   - ✓ Penyewaan
   - ✓ Laporan
   - ✓ Ke Website
   - ✓ Logout

### B. Testing Admin CRUD - Kategori

1. **Klik menu "Kategori" di sidebar**
   - Halaman akan menampilkan daftar kategori
   - Tombol: "Tambah Kategori"

2. **Test Create (Tambah)**:
   - Klik "Tambah Kategori"
   - Isi form:
     - Nama: "Test Kategori"
     - Deskripsi: "Kategori untuk testing"
   - Klik "Simpan"
   - ✓ Success message muncul
   - ✓ Kategori baru muncul di daftar

3. **Test Edit (Ubah)**:
   - Klik tombol "Edit" pada kategori yang baru dibuat
   - Ubah nama menjadi: "Test Kategori Updated"
   - Klik "Simpan"
   - ✓ Success message muncul
   - ✓ Perubahan tersimpan

4. **Test Delete (Hapus)**:
   - Klik tombol "Hapus" pada kategori yang baru dibuat
   - Konfirmasi penghapusan
   - ✓ Success message muncul
   - ✓ Kategori terhapus dari daftar

### C. Testing Admin CRUD - Alat Camping

1. **Klik menu "Alat Camping" di sidebar**
   - Halaman akan menampilkan daftar alat camping
   - Tombol: "Tambah Alat"

2. **Test Create (Tambah)**:
   - Klik "Tambah Alat"
   - Isi form:
     - Kategori: Pilih salah satu
     - Nama: "Sleeping Bag Test"
     - Deskripsi: "Sleeping bag untuk testing"
     - Harga/Hari: 50000
     - Stok: 10
     - Kondisi: Pilih "Sangat Baik"
     - Gambar: Upload gambar (opsional)
   - Klik "Simpan"
   - ✓ Success message muncul
   - ✓ Alat baru muncul di daftar
   - ✓ Stok Tersedia = 10

3. **Test Edit (Ubah)**:
   - Klik tombol "Edit" pada alat yang baru dibuat
   - Ubah:
     - Stok: 15
     - Harga/Hari: 60000
   - Klik "Simpan"
   - ✓ Success message muncul
   - ✓ Perubahan tersimpan
   - ✓ Stok Tersedia = 15

4. **Test Delete (Hapus)**:
   - Klik tombol "Hapus" pada alat yang baru dibuat
   - Konfirmasi penghapusan
   - ✓ Success message muncul
   - ✓ Alat terhapus dari daftar

### D. Testing "Sewa Sekarang" (User Rental)

#### Login sebagai User

1. **Logout dari admin** (klik Logout di sidebar)

2. **Register akun user baru** atau login dengan:
   - Email: `user@example.com`
   - Password: `password`

#### Test Rental Flow

1. **Di Homepage**:
   - Klik salah satu alat camping
   - Atau buka: `/equipment` untuk melihat semua alat

2. **Di halaman detail alat**:
   - Klik tombol "Sewa Sekarang"
   - ✓ Anda akan diarahkan ke form penyewaan

3. **Isi form penyewaan**:
   - Jumlah: 2
   - Tanggal Mulai: Pilih hari ini atau besok
   - Tanggal Selesai: Pilih 3 hari dari tanggal mulai
   - Catatan: "Test penyewaan" (opsional)
   - ✓ Ringkasan harga akan otomatis terhitung

4. **Klik "Buat Pesanan"**:
   - ✓ Success message muncul
   - ✓ Diarahkan ke halaman "Pesanan Saya"
   - ✓ Status: "Pending"
   - ✓ Kode pesanan tergenerate (contoh: RNT-20260104-001)

5. **Verifikasi stok berkurang**:
   - Logout dan login sebagai admin
   - Buka menu "Alat Camping"
   - ✓ Stok Tersedia berkurang sesuai jumlah yang disewa

#### Test Admin Approval

1. **Login sebagai admin**

2. **Klik menu "Penyewaan"**:
   - ✓ Pesanan user muncul dengan status "Pending"

3. **Klik "Lihat Detail"** pada pesanan:
   - Klik tombol "Setujui"
   - ✓ Status berubah menjadi "Approved"

4. **Aktifkan penyewaan**:
   - Klik tombol "Aktifkan"
   - ✓ Status berubah menjadi "Active"

5. **Selesaikan penyewaan**:
   - Klik tombol "Selesaikan"
   - ✓ Status berubah menjadi "Completed"
   - ✓ Stok kembali bertambah

### E. Testing Review System

1. **Login sebagai user** (yang tadi membuat pesanan)

2. **Buka "Pesanan Saya"**:
   - Klik pesanan yang sudah "Completed"
   - Klik tombol "Beri Ulasan"

3. **Isi form ulasan**:
   - Rating: Pilih 5 bintang
   - Komentar: "Alat dalam kondisi bagus, sangat puas!"
   - Klik "Kirim Ulasan"
   - ✓ Success message muncul

4. **Verifikasi ulasan**:
   - Buka halaman detail alat yang disewa
   - ✓ Ulasan muncul di bagian bawah
   - ✓ Rating rata-rata terupdate

### F. Testing Report (Laporan)

1. **Login sebagai admin**

2. **Klik menu "Laporan"**:
   - Pilih tanggal mulai dan akhir
   - Klik "Tampilkan Laporan"
   - ✓ Tabel transaksi muncul
   - ✓ Total pendapatan terhitung
   - Klik "Export Excel" (opsional)
   - ✓ File Excel terdownload

## 🔧 Troubleshooting

### Jika "Sewa Sekarang" masih error:

1. **Cek apakah sudah login sebagai user** (bukan admin):
   ```
   User role harus = 'user' untuk bisa menyewa
   ```

2. **Cek error di browser console**:
   - Tekan F12
   - Buka tab "Console"
   - Lihat apakah ada JavaScript error

3. **Cek Laravel logs**:
   ```powershell
   Get-Content storage/logs/laravel.log -Tail 50
   ```

### Jika admin CRUD tidak muncul:

1. **Pastikan login sebagai admin**:
   ```
   Email: admin@sewacamping.com
   Password: admin123
   ```

2. **Cek role user di database**:
   ```sql
   SELECT name, email, role FROM users WHERE email = 'admin@sewacamping.com';
   ```
   Role harus = 'admin'

3. **Clear browser cache**:
   - Tekan Ctrl + Shift + Delete
   - Clear cookies and cached files

### Jika form submit error:

1. **Pastikan CSRF token ada**:
   - Buka halaman form
   - View page source
   - Cari `<input type="hidden" name="_token"`
   - Harus ada token

2. **Cek session configuration**:
   ```php
   // config/session.php
   'driver' => 'database', // harus database
   ```

## 📝 Checklist Testing

### Admin Panel
- [ ] Login admin berhasil
- [ ] Dashboard menampilkan statistik
- [ ] Menu sidebar terlihat semua
- [ ] Create kategori berhasil
- [ ] Edit kategori berhasil
- [ ] Delete kategori berhasil
- [ ] Create alat camping berhasil
- [ ] Edit alat camping berhasil
- [ ] Delete alat camping berhasil
- [ ] Upload gambar alat berhasil
- [ ] Lihat daftar penyewaan
- [ ] Setujui penyewaan
- [ ] Aktifkan penyewaan
- [ ] Selesaikan penyewaan
- [ ] Lihat laporan transaksi

### User Panel
- [ ] Register user berhasil
- [ ] Login user berhasil
- [ ] Browse alat camping
- [ ] Lihat detail alat
- [ ] Tombol "Sewa Sekarang" muncul dan bisa diklik
- [ ] Form penyewaan muncul
- [ ] Isi form dan submit berhasil
- [ ] Pesanan muncul di "Pesanan Saya"
- [ ] Beri ulasan setelah selesai
- [ ] Ulasan muncul di detail alat

### Sistem
- [ ] Stok berkurang saat disewa
- [ ] Stok bertambah saat selesai
- [ ] Rating rata-rata terhitung benar
- [ ] Notifikasi success/error muncul
- [ ] Gambar alat muncul
- [ ] Redirect setelah login benar

## 🎯 Hasil yang Diharapkan

Setelah semua testing di atas, sistem harus:
1. ✅ Admin bisa login dan akses semua CRUD
2. ✅ User bisa register, login, dan menyewa alat
3. ✅ Form "Sewa Sekarang" berfungsi tanpa error
4. ✅ Stok management berjalan otomatis
5. ✅ Review system berfungsi
6. ✅ Laporan bisa ditampilkan dan diexport
7. ✅ Semua notifikasi muncul dengan benar

## 📞 Jika Masih Ada Error

Jalankan command ini dan copy hasilnya:

```powershell
# Test system
php artisan test:system

# Cek routes
php artisan route:list --name=admin

# Cek logs
Get-Content storage/logs/laravel.log -Tail 20

# Cek user admin
php artisan tinker
>>> User::where('email', 'admin@sewacamping.com')->first()
>>> exit
```

Berikan hasil output di atas untuk troubleshooting lebih lanjut.
