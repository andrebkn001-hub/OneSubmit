# TODO: Tambahkan Fitur "Judul Skripsi" di Header Landing Page

## Tasks
- [x] Update header di `resources/views/landing.blade.php` untuk tambahkan tombol "Judul Skripsi" samping tombol "Masuk"
- [x] Tambahkan method `judulSkripsi()` di `app/Http/Controllers/MahasiswaController.php` untuk ambil data proposal disetujui
- [x] Buat view `resources/views/judul-skripsi.blade.php` untuk tampilkan tabel judul proposal dan bidang minat
- [x] Tambahkan route GET '/judul-skripsi' di `routes/web.php` untuk akses halaman baru
- [x] Test halaman baru untuk memastikan data tampil dengan benar
- [x] Verifikasi route dan controller method berfungsi
- [x] Pastikan styling konsisten dengan landing page
