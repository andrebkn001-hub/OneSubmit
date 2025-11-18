# FIX: Link Aksi Inbox ke Daftar Proposal

## 🐛 Masalah
Ketika klik tombol "Aksi" (ikon mata) di halaman Inbox, halaman daftar proposal menampilkan "Belum ada proposal yang diajukan untuk bidang business-intelligence" meskipun data proposal ada di database.

## 🔍 Root Cause
1. **Link di inbox** menggunakan format `business-intelligence` (dengan dash)
2. **Controller** hanya mengenali kode singkat (`bi`, `de`, `im`, `ir`)
3. **Mismatch parameter** menyebabkan query tidak menemukan data

## ✅ Solusi yang Diterapkan

### 1. Update Inbox View
**File**: `resources/views/jurusan/inbox/index.blade.php`

**Perubahan**: Link aksi sekarang menggunakan kode singkat yang benar
```php
@php
    $bidangCode = match($proposal->bidang_minat) {
        'Business Intelligence' => 'bi',
        'Data Engineering' => 'de',
        'Information Management' => 'im',
        'Information Retrieval' => 'ir',
        default => strtolower(str_replace(' ', '-', $proposal->bidang_minat))
    };
@endphp
<a href="{{ route('jurusan.proposals.index', $bidangCode) }}" ...>
```

### 2. Enhance JurusanController
**File**: `app/Http/Controllers/JurusanController.php`

**Perubahan**: Tambah mapping format dash untuk backward compatibility
```php
$bidangMap = [
    // Kode singkat (primary)
    'im' => 'Information Management',
    'bi' => 'Business Intelligence',
    'de' => 'Data Engineering',
    'ir' => 'Information Retrieval',
    // Format dash (backward compatibility)
    'business-intelligence' => 'Business Intelligence',
    'data-engineering' => 'Data Engineering',
    'information-management' => 'Information Management',
    'information-retrieval' => 'Information Retrieval',
];
```

## 🎯 Hasil
✅ Link dari inbox sekarang menggunakan kode singkat (`bi`, `im`, etc.)  
✅ Controller support kedua format (kode singkat & dash format)  
✅ Data proposal muncul dengan benar  
✅ Backward compatible dengan URL lama  

## 🧪 Testing
```bash
# Test URL yang seharusnya bekerja:
/jurusan/proposals/bi          # Business Intelligence
/jurusan/proposals/de          # Data Engineering
/jurusan/proposals/im          # Information Management
/jurusan/proposals/ir          # Information Retrieval

# Backward compatible:
/jurusan/proposals/business-intelligence
/jurusan/proposals/data-engineering
```

## 📝 Mapping Bidang Minat

| Bidang Minat Database    | Kode Singkat | Format Dash (Alt) |
|--------------------------|--------------|-------------------|
| Business Intelligence    | `bi`         | `business-intelligence` |
| Data Engineering         | `de`         | `data-engineering` |
| Information Management   | `im`         | `information-management` |
| Information Retrieval    | `ir`         | `information-retrieval` |

---
**Fixed**: 18 November 2025
