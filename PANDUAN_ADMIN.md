# 🎯 Panduan Lengkap Admin Panel

## 🔐 Login Admin
```
URL: http://localhost/sewa-camping/public/login
Email: admin@sewacamping.com
Password: admin123
```

---

## 📱 Menu Admin Panel

### 1️⃣ Dashboard
**URL**: `/admin/dashboard`

**Yang Ditampilkan**:
- 📊 Total Equipment
- 📊 Total Kategori
- 📊 Total User
- 📊 Total Penyewaan
- ⏳ Pending Rentals
- ✅ Active Rentals
- 💰 Revenue Bulan Ini
- 📋 5 Penyewaan Terbaru
- ⚠️ Stok Alat Rendah

---

### 2️⃣ Kelola User ⭐ BARU!
**URL**: `/admin/users`

**Fitur**:
- ✅ Lihat semua user (admin & user biasa)
- ✅ Search by nama atau email
- ✅ Filter by role (Admin/User)
- ✅ Tambah user baru
- ✅ Edit user
- ✅ Hapus user
- ✅ Lihat detail user & riwayat rental

**Cara Tambah User**:
1. Klik tombol "Tambah User"
2. Isi form:
   - Nama
   - Email
   - Password
   - Konfirmasi Password
   - Role (Admin/User)
   - Telepon (opsional)
   - Alamat (opsional)
3. Klik "Simpan"

**Cara Edit User**:
1. Klik tombol Edit (ikon pensil)
2. Ubah data yang perlu diubah
3. Password: kosongkan jika tidak ingin mengubah
4. Klik "Update"

**Cara Hapus User**:
1. Klik tombol Hapus (ikon tempat sampah)
2. Konfirmasi
3. User terhapus (kecuali user sendiri & user dengan rental aktif)

---

### 3️⃣ Kategori
**URL**: `/admin/categories`

**Fitur**:
- ✅ Tambah kategori baru
- ✅ Edit kategori
- ✅ Hapus kategori
- ✅ Lihat jumlah alat per kategori

**Cara Tambah Kategori**:
1. Klik "Tambah Kategori"
2. Isi nama & deskripsi
3. Klik "Simpan"

---

### 4️⃣ Alat Camping
**URL**: `/admin/equipment`

**Fitur**:
- ✅ Tambah alat baru dengan upload gambar
- ✅ Edit alat
- ✅ Hapus alat
- ✅ Search alat
- ✅ Lihat stok tersedia

**Cara Tambah Alat**:
1. Klik "Tambah Alat"
2. Isi form:
   - Pilih Kategori
   - Nama Alat
   - Deskripsi
   - Harga per Hari (Rp)
   - Stok Total
   - Kondisi (Sangat Baik/Baik/Cukup)
   - Upload Gambar (opsional)
3. Klik "Simpan"

**Cara Edit Alat**:
1. Klik tombol Edit (ikon pensil)
2. Ubah data
3. Upload gambar baru (opsional)
4. Stok tersedia otomatis dihitung
5. Klik "Simpan"

**Cara Hapus Alat**:
1. Klik tombol Hapus (ikon tempat sampah)
2. Konfirmasi
3. Alat terhapus (kecuali yang sedang disewa)

---

### 5️⃣ Penyewaan (Persetujuan)
**URL**: `/admin/rentals`

**Fitur**:
- ✅ Lihat semua pesanan penyewaan
- ✅ Filter by status
- ✅ Approve pesanan
- ✅ Aktifkan penyewaan
- ✅ Selesaikan penyewaan
- ✅ Tolak pesanan

**Status Penyewaan**:
1. **Pending** 🟡 - Menunggu persetujuan admin
2. **Approved** 🔵 - Disetujui, siap diambil
3. **Active** 🟢 - Sedang disewa
4. **Completed** ✅ - Selesai & dikembalikan
5. **Rejected** 🔴 - Ditolak

**Workflow Persetujuan**:

#### A. Approve Pesanan (Pending → Approved)
1. Buka menu "Penyewaan"
2. Filter status "Pending"
3. Klik "Lihat Detail" pada pesanan
4. Klik tombol "Setujui"
5. Status berubah jadi "Approved"

#### B. Aktifkan Penyewaan (Approved → Active)
1. Filter status "Approved"
2. Klik "Lihat Detail"
3. Klik tombol "Aktifkan"
4. Status berubah jadi "Active"

#### C. Selesaikan Penyewaan (Active → Completed)
1. Filter status "Active"
2. Klik "Lihat Detail"
3. Klik tombol "Selesaikan"
4. Status berubah jadi "Completed"
5. Stok alat otomatis kembali

#### D. Tolak Pesanan (Pending → Rejected)
1. Filter status "Pending"
2. Klik "Lihat Detail"
3. Klik tombol "Tolak"
4. Status berubah jadi "Rejected"
5. Stok alat otomatis kembali

---

### 6️⃣ Laporan
**URL**: `/admin/reports`

**Fitur**:
- ✅ Laporan transaksi penyewaan
- ✅ Filter by tanggal
- ✅ Total revenue
- ✅ Total transaksi

**Cara Lihat Laporan**:
1. Buka menu "Laporan"
2. Pilih Tanggal Mulai
3. Pilih Tanggal Selesai
4. Klik "Tampilkan Laporan"
5. Lihat tabel transaksi & statistik

**Yang Ditampilkan**:
- Total Revenue (Rp)
- Total Penyewaan
- Completed Rentals
- Active Rentals
- Tabel detail transaksi

---

## ⚡ Tips Admin

### Manajemen Stok
- Stok tersedia otomatis berkurang saat ada rental
- Stok tersedia otomatis bertambah saat rental selesai/ditolak
- Stok tersedia = Total stok - Sedang disewa

### Manajemen User
- Tidak bisa hapus akun sendiri
- Tidak bisa hapus user yang punya rental aktif
- Bisa ubah role user dari User ke Admin atau sebaliknya

### Manajemen Alat
- Tidak bisa hapus alat yang sedang disewa
- Gambar lama otomatis dihapus saat upload baru
- Stok tersedia otomatis adjust saat edit

### Manajemen Pesanan
- Pesanan harus di-approve dulu baru bisa diaktifkan
- Pesanan active harus diselesaikan untuk return stok
- Pesanan rejected otomatis return stok

---

## 🎯 Checklist Harian Admin

### Pagi
- [ ] Cek dashboard untuk overview
- [ ] Cek pending rentals
- [ ] Approve pesanan yang valid
- [ ] Cek low stock equipment

### Siang
- [ ] Aktifkan rental yang sudah approved
- [ ] Cek active rentals

### Sore
- [ ] Selesaikan rental yang sudah dikembalikan
- [ ] Cek laporan harian

---

## 🆘 Troubleshooting

### Dashboard Error?
```powershell
php artisan optimize:clear
```

### CRUD Tidak Muncul?
1. Pastikan login sebagai admin (bukan user)
2. Clear browser cache (Ctrl+Shift+Delete)
3. Refresh halaman (F5)

### Gambar Tidak Muncul?
```powershell
php artisan storage:link
```

### Test System
```powershell
php artisan test:system
```

---

## ✅ Fitur Lengkap Yang Tersedia

- ✅ Dashboard dengan statistik lengkap
- ✅ Kelola User (CRUD lengkap)
- ✅ Kelola Kategori (CRUD lengkap)
- ✅ Kelola Alat Camping (CRUD lengkap + upload gambar)
- ✅ Kelola Penyewaan (Approve/Activate/Complete/Reject)
- ✅ Lihat Laporan dengan filter tanggal

**Semuanya sudah berfungsi dengan baik!** 🎉

---

## 📞 Support

Jika ada pertanyaan, jalankan:
```powershell
# Test system
php artisan test:system

# Cek routes
php artisan route:list --name=admin

# Cek logs
Get-Content storage/logs/laravel.log -Tail 20
```
