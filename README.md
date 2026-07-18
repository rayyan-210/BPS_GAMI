# BPS_GAMI

Aplikasi web profesional yang dibangun dengan PHP untuk mengelola data dan administrasi BPS (Badan Pusat Statistik) UMKM.

## Ringkasan

BPS_GAMI adalah sistem manajemen komprehensif yang dirancang untuk menangani data UMKM (Usaha Mikro, Kecil, dan Menengah) dengan autentikasi pengguna dan kontrol akses berbasis peran. Aplikasi ini menyediakan platform yang aman untuk manajemen data dan operasi administratif.

## Fitur Utama

- **Autentikasi Pengguna** - Sistem login yang aman dengan manajemen kredensial pengguna
- **Kontrol Akses Berbasis Peran** - Diferensiasi peran admin dan pengguna
- **Manajemen Data UMKM** - Database komprehensif untuk mengelola informasi UMKM
- **Integrasi Database** - Dibangun dengan arsitektur database yang robust untuk integritas data
- **Antarmuka Responsif** - Antarmuka berbasis web yang ramah pengguna untuk interaksi yang mulus

## Stack Teknologi

- **Backend** - PHP
- **Database** - MySQL
- **Manajemen Database** - phpMyAdmin

## Persyaratan

Sebelum memulai, pastikan Anda telah menginstal:
- PHP 7.4 atau lebih tinggi
- MySQL Server
- phpMyAdmin (untuk manajemen database)
- Web server (Apache/Nginx)

## Instalasi & Konfigurasi

### 1. Konfigurasi Database

1. Akses phpMyAdmin melalui web server Anda
2. Buat atau gunakan database `bps_umkm` yang sudah ada
3. Impor atau konfigurasi tabel-tabel database yang diperlukan
4. Atur tabel `user` dengan opsi peran admin/pengguna

### 2. Setup Akun Admin

1. Navigasi ke phpMyAdmin
2. Akses tabel `user` di database `bps_umkm`
3. Buat entri pengguna baru
4. Atur kolom peran untuk memberikan hak akses admin
5. Konfigurasi kredensial login sesuai kebutuhan

### 3. Konfigurasi Aplikasi

1. Clone atau unduh repository
2. Konfigurasi parameter koneksi database di aplikasi
3. Pastikan perizinan file diatur dengan benar
4. Akses aplikasi melalui web server Anda

## Cara Penggunaan

1. Buka aplikasi di browser web Anda
2. Login dengan kredensial Anda
3. Pilih peran Anda (Admin/Pengguna) berdasarkan tingkat akses
4. Navigasi ke modul yang sesuai untuk manajemen data

## Struktur Proyek

```
BPS_GAMI/
├── index.php
├── config/
├── assets/
├── views/
└── database/
```

## Tim Pengembang

- **Rayyan** - Pengembang Utama
- **Tafftadia Imada** - Pengembang
- **Wildan Mukorrobin** - Pengembang

## Lisensi

Proyek ini adalah open source dan tersedia di bawah lisensi yang sesuai.

## Dukungan

Untuk masalah, pertanyaan, atau kontribusi, silakan merujuk ke repository proyek atau hubungi tim pengembangan.

---

**Diperbarui Terakhir:** 18 Mei 2026  
**Repository:** [rayyan-210/BPS_GAMI](https://github.com/rayyan-210/BPS_GAMI)
