# Inbox Aksi Saya - Fitur Ketua Jurusan

## 📋 Ringkasan
Fitur **Inbox Aksi Saya** memberikan Ketua Jurusan satu dashboard terpusat untuk melihat semua proposal yang membutuhkan aksi/perhatian. Badge count real-time di sidebar menampilkan jumlah item yang perlu ditindaklanjuti.

## ✨ Fitur Utama

### 1. Badge Sidebar Real-Time
- **Badge merah** di menu "Inbox Aksi Saya" menampilkan jumlah proposal butuh aksi
- **Cache 60 detik** untuk performa optimal
- **Animasi pulse** untuk menarik perhatian
- Otomatis update saat halaman di-refresh

### 2. Statistik Dashboard
Empat kartu KPI:
- **Total Butuh Aksi**: Semua proposal menunggu verifikasi atau revisi
- **Menunggu Verifikasi**: Proposal baru yang belum diproses
- **Perlu Revisi**: Proposal yang dikembalikan untuk diperbaiki
- **Aging (>3 hari)**: Proposal yang menunggu lebih dari 3 hari (highlight merah)

### 3. Filter & Pencarian
- **Cari**: Berdasarkan judul, NIM, atau nama mahasiswa
- **Status**: Filter menunggu_verifikasi atau revisi
- **Bidang Minat**: Filter per kategori KJFD
- **Aging**: Filter proposal >3, >7, atau >14 hari
- **Sort**: Terlama dulu (default) atau terbaru dulu

### 4. Tabel Proposal
- **Highlight kuning**: Proposal aging >3 hari
- **Badge aging**: Menampilkan jumlah hari menunggu
- **Link aksi**: Klik untuk ke halaman detail verifikasi
- **Pagination**: 15 item per halaman

## 🗂️ Struktur File

```
app/
├── Services/
│   └── SidebarService.php          # Service untuk hitung badge (cached)
├── Http/Controllers/Jurusan/
│   └── InboxController.php         # Controller inbox Ketua Jurusan
├── Models/
│   └── Proposal.php                # Tambah scopes: needsKetuaAction, aging, dll
└── Providers/
    └── AppServiceProvider.php      # Register SidebarService sebagai singleton

resources/views/
├── jurusan/inbox/
│   └── index.blade.php             # Halaman inbox dengan filter & tabel
└── layouts/
    └── app.blade.php               # Sidebar update dengan badge count

routes/
└── web.php                         # Routes: /jurusan/inbox
```

## 🔧 Query Scopes Baru di Proposal Model

```php
// Proposals butuh aksi Ketua Jurusan
Proposal::needsKetuaAction()->get();

// Proposals menunggu verifikasi
Proposal::waitingVerification()->get();

// Proposals aging lebih dari N hari
Proposal::aging(3)->get();
Proposal::aging(7)->get();
```

## 🎯 Cara Kerja Badge Sidebar

1. **SidebarService** menghitung count dari database
2. **Cache 60 detik** untuk mengurangi query database
3. Badge ditampilkan di sidebar jika `inbox_total > 0`
4. Animasi pulse untuk menarik perhatian
5. Cache otomatis clear saat:
   - Status proposal berubah (bisa ditambahkan via observer)
   - Manual clear: `app(\App\Services\SidebarService::class)->clearCache()`

## 📊 Status Proposal yang Masuk Inbox

- `menunggu_verifikasi`: Proposal baru dari mahasiswa
- `revisi`: Proposal yang dikembalikan untuk diperbaiki

Status lain (disetujui, ditolak, menunggu_verifikasi_dosen_kjfd) **tidak masuk** inbox karena tidak butuh aksi langsung Ketua Jurusan.

## 🚀 Penggunaan

### Akses Inbox
```
URL: http://127.0.0.1:8000/jurusan/inbox
Route Name: jurusan.inbox.index
```

### Filter dengan Query String
```
/jurusan/inbox?status=menunggu_verifikasi
/jurusan/inbox?bidang=Business Intelligence
/jurusan/inbox?aging=3
/jurusan/inbox?search=machine learning
/jurusan/inbox?sort=oldest
```

### Programatik - Clear Cache
```php
// Di controller setelah approve/reject proposal
$sidebarService = app(\App\Services\SidebarService::class);
$sidebarService->clearCache();
```

## 🔄 Integrasi dengan Flow Yang Ada

Fitur ini **tidak mengubah** alur existing:
- ✅ Read-only pada tahap ini
- ✅ Agregasi data yang sudah ada
- ✅ Tidak menambah status baru
- ✅ Tidak memaksa perubahan skema database
- ✅ Compatible dengan JurusanController yang sudah ada

## 📈 Next Steps (Opsional)

1. **Observer Pattern**: Auto-clear cache saat proposal status berubah
2. **Notifikasi Email**: Reminder H-1 untuk aging proposals
3. **Bulk Actions**: Approve/reject multiple proposals sekaligus
4. **Export**: Download laporan inbox sebagai PDF/Excel
5. **SLA Tracking**: Tambah kolom `due_at` untuk deadline verifikasi
6. **Dashboard Widget**: Mini inbox widget di dashboard utama

## 🐛 Troubleshooting

### Badge tidak muncul
- Pastikan ada proposal dengan status `menunggu_verifikasi` atau `revisi`
- Clear cache: `php artisan cache:clear`
- Check role user: `Auth::user()->role === 'ketua_jurusan'`

### Query lambat
- Index database: `created_at`, `status`
- Cache berfungsi dengan baik (60 detik TTL)
- Pagination batas 15 item sudah optimal

## 📝 Catatan Pengembangan

- **Performa**: SidebarService menggunakan singleton + cache untuk efisiensi
- **Keamanan**: Middleware `auth` dan `role:ketua_jurusan` sudah terpasang
- **UX**: Aging highlight (kuning + badge hari) membantu prioritas
- **Extensible**: Mudah tambah filter atau statistik baru

---
**Tanggal**: 18 November 2025  
**Versi**: 1.0  
**Developer**: GitHub Copilot
