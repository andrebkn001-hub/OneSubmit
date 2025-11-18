<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; // <<< DITAMBAHKAN: Diperlukan untuk mengirim file
use App\Models\KjfdQuota;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class JurusanController extends Controller
{
    /**
     * Display KJFD selection page for ketua jurusan.
     */
    public function kjfdSelection(): View
    {
        // Ambil mapping bidang dari config supaya mudah di-maintain
        $fieldMap = Config::get('kjfd.fields', [
            'bi' => 'Business Intelligence',
            'de' => 'Data Engineering',
            'im' => 'Information Management',
            'ir' => 'Information Retrieval',
        ]);

        $limitDefault = Config::get('kjfd.default_quota', 50);

        // konfigurasi tampilan untuk tiap field (warna/icon)
        $fieldsConfig = [
            'bi' => ['code' => 'bi', 'short' => 'BI', 'name' => $fieldMap['bi'], 'color' => 'primary', 'icon' => 'chart-line'],
            'de' => ['code' => 'de', 'short' => 'DE', 'name' => $fieldMap['de'], 'color' => 'success', 'icon' => 'database'],
            'im' => ['code' => 'im', 'short' => 'IM', 'name' => $fieldMap['im'], 'color' => 'info', 'icon' => 'folder-open'],
            'ir' => ['code' => 'ir', 'short' => 'IR', 'name' => $fieldMap['ir'], 'color' => 'warning', 'icon' => 'search'],
        ];

        $fields = [];

        foreach ($fieldsConfig as $code => $f) {
            // Ambil kuota dari DB jika tersedia, jika tidak gunakan default
            $quotaRecord = KjfdQuota::where('bidang', $f['name'])->first();
            $limit = $quotaRecord?->quota ?? $limitDefault;

            // Cache accepted counts singkat (30 detik) untuk performa
            $cacheKey = "kjfd_accepted_{$code}";
            
            // Store the cache key for later clearing
            $cachedKeys = Cache::get('cached_kjfd_keys', []);
            if (!in_array($cacheKey, $cachedKeys)) {
                $cachedKeys[] = $cacheKey;
                Cache::put('cached_kjfd_keys', $cachedKeys, 3600); // Store for 1 hour
            }

            $accepted = Cache::remember($cacheKey, 30, function() use ($f) {
                return Proposal::where('bidang_minat', $f['name'])->where('status', 'disetujui')->count();
            });

            $remaining = max(0, $limit - $accepted);
            $pct = $accepted > 0 ? min(100, (int) round(($accepted / $limit) * 100)) : 0;

            $f['accepted'] = $accepted;
            $f['remaining'] = $remaining;
            $f['pct'] = $pct;
            $f['limit'] = $limit;

            $fields[] = $f;
        }

        return view('jurusan.proposals.kjfd', compact('fields'));
    }

    /**
     * Display list of proposals for a specific KJFD bidang.
     */
    public function proposalsIndex(Request $request, string $bidang): View
    {
        // 1. BUAT PEMETAAN BIDANG MINAT dari URL singkat ke nilai Database (Factory)
        $bidangMap = [
            // Kode singkat
            'im' => 'Information Management',
            'bi' => 'Business Intelligence',
            'de' => 'Data Engineering',
            'ir' => 'Information Retrieval',
            // Format dengan dash (untuk backward compatibility)
            'business-intelligence' => 'Business Intelligence',
            'data-engineering' => 'Data Engineering',
            'information-management' => 'Information Management',
            'information-retrieval' => 'Information Retrieval',
        ];

        // Normalisasi parameter dan cari kecocokan
        $param = strtolower(trim($bidang));

        // 1) Cek kode singkat atau format dash
        if (isset($bidangMap[$param])) {
            $bidangDB = $bidangMap[$param];
        } else {
            // 2) Cek apakah parameter sudah berupa nama lengkap (case-insensitive)
            $bidangDB = null;
            foreach ($bidangMap as $code => $fullName) {
                if (strtolower($fullName) === $param) {
                    $bidangDB = $fullName;
                    break;
                }
                // juga coba cocokkan tanpa spasi (mis. dari URL atau input lain)
                if (str_replace(' ', '', strtolower($fullName)) === str_replace(' ', '', $param)) {
                    $bidangDB = $fullName;
                    break;
                }
            }
        }

        // Jika tetap tidak ditemukan, kembalikan view kosong (lebih aman daripada error)
        if (!$bidangDB) {
            return view('jurusan.proposals.index', [
                'proposals' => collect(),
                'bidang' => $bidang,
            ]);
        }

        // Mulai query dengan filter Bidang Minat yang sudah dipetakan
        $query = Proposal::where('bidang_minat', $bidangDB);


        if ($request->has('nim') && !empty($request->nim)) {
            // Filter NIM hanya jika NIM diisi di form
            $query->where('nim', 'like', '%' . $request->nim . '%');
        }

        $proposals = $query->latest()->get();

        // Pastikan view menerima nama bidang yang sesungguhnya (full name)
        $bidangDisplay = $bidangDB;

        return view('jurusan.proposals.index', compact('proposals'))
            ->with('bidang', $bidangDisplay);
    }

    // 🚀 FUNGSI BARU UNTUK MENGATASI ERROR 404 (Lihat File)
    /**
     * View/Download file proposal untuk role Jurusan.
     */
    public function viewFile(int $id)
    {
        $proposal = Proposal::findOrFail($id);

        // Otorisasi: Cek keberadaan file saja, karena route sudah dilindungi middleware Jurusan
        $filePath = $proposal->file_path;

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return abort(404, 'Berkas proposal tidak ditemukan di sistem penyimpanan.');
        }

        // Mengirimkan respons file ke browser
        return Storage::disk('public')->response($filePath, $proposal->judul . '.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $proposal->judul . '.pdf"'
        ]);
    }
}