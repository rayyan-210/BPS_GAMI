# BPS UMKM Gamification (PHP Native + MySQL)

Sistem sederhana pendataan UMKM dengan reward system. Tugas kuliah.

## Tech
- PHP 7.4+ / 8.x (native, tanpa framework)
- MySQL 5.7+ / MariaDB
- Vanilla CSS (tanpa framework JS)

## Struktur Folder
```
umkm-php/
├── admin/              # Halaman admin (CRUD tugas, validasi, reward)
├── user/               # Halaman user (dashboard, tugas, survey, reward, profil)
├── config/database.php # Koneksi MySQL
├── includes/           # auth, header, footer
├── assets/
│   ├── css/style.css   # Styling
│   └── uploads/        # Foto UMKM & reward (otomatis dibuat)
├── sql/database.sql    # Skema + seed
├── index.php           # Landing page
├── login.php
├── register.php
└── logout.php
```

## Cara Install (XAMPP / Laragon)

1. **Copy folder** `umkm-php/` ke `htdocs/` (XAMPP) atau `www/` (Laragon).
2. **Jalankan MySQL** (Apache + MySQL via XAMPP control panel).
3. **Import database**:
   - Buka `http://localhost/phpmyadmin`
   - Buat database baru `bps_umkm` (atau langsung import — file otomatis CREATE)
   - Klik tab **Import** → pilih `sql/database.sql` → Go
4. **Set password admin** (karena hash di seed adalah placeholder):
   ```bash
   php -r "echo password_hash('Hamadamisan78', PASSWORD_DEFAULT);"
   ```
   Lalu di phpMyAdmin → SQL:
   ```sql
   UPDATE users SET password='<hash dari command di atas>' WHERE email='sa@gmail.com';
   ```
   ATAU lebih mudah: register user baru dari halaman register, kemudian:
   ```sql
   UPDATE users SET role='admin' WHERE email='sa@gmail.com';
   ```
5. **Akses**: `http://localhost/umkm-php/`

## Akun Default
- **Admin**: sa@gmail.com / Hamadamisan78 (setelah update password)
- **User**: register sendiri

## Konfigurasi DB
Edit `config/database.php` jika username/password MySQL Anda berbeda:
```php
$host='localhost'; $user='root'; $pass=''; $db='bps_umkm';
```

## Fitur
**User**: Register/Login · Lihat tugas · Isi survey UMKM (upload foto + bukti lokasi) · Lihat status validasi · Tukar poin dengan reward · Profil

**Admin**: Dashboard statistik · CRUD Tugas · Validasi survey (approve/reject + auto add poin) · CRUD Reward (dengan gambar)

## Catatan Keamanan (Sederhana untuk Tugas)
- Password di-hash dengan `password_hash()` (bcrypt)
- Query menggunakan prepared statement
- Validasi tipe & ukuran upload (max 5MB, jpg/png/webp)
- Session-based auth dengan role check
