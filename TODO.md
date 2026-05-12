# TODO - Status “Total Survey Selesai” & Penentuan Status di Profile

- [x] Analisis alur validasi: survey dinyatakan sukses saat `surveys.status_validasi='approved'`.
- [x] Update `user/profile.php` untuk:
  - [x] Query `COUNT(*)` survey approved milik user
  - [x] Mapping threshold (1/3/5/10/20) ke label status
  - [x] Tampilkan `Total Survey Selesai` dan `Status` di halaman profile
- [ ] Jalankan pengecekan cepat (akses profile user setelah admin approve minimal 1 survey) untuk memastikan status ter-update


