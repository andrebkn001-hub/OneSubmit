<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; // <<< DITAMBAHKAN: Diperlukan untuk mengirim file

class JurusanController extends Controller
{
    /**
     * Display KJFD selection page for ketua jurusan.
     */
    public function kjfdSelection(): View
    {
        return view('jurusan.proposals.kjfd');
    }

    /**
     * Display list of proposals for a specific KJFD bidang.
     */
    public function proposalsIndex(Request $request, string $bidang): View
    {
        // 1. BUAT PEMETAAN BIDANG MINAT dari URL singkat ke nilai Database (Factory)
        $bidangMap = [
            // Pastikan kode di URL cocok dengan nama lengkap di Factory
            'im' => 'Information Management',
            'bi' => 'Business Intelligence',
            'de' => 'Data Engineering', // Contoh: URL /proposals/de akan mencari Data Engineering
            'ir' => 'Information Retrieval',
        ];
        
        $bidangDB = $bidangMap[strtolower($bidang)] ?? null;

        // Cek jika bidang tidak valid
        if (!$bidangDB) {
            // Jika bidang tidak ditemukan, kembalikan array kosong
            return view('jurusan.proposals.index', [
                'proposals' => collect(),
                'bidang' => $bidang
            ]);
        }

        // Mulai query dengan filter Bidang Minat yang sudah dipetakan
        $query = Proposal::where('bidang_minat', $bidangDB);


        if ($request->has('nim') && !empty($request->nim)) {
            // Filter NIM hanya jika NIM diisi di form
            $query->where('nim', 'like', '%' . $request->nim . '%');
        }

        $proposals = $query->latest()->get();

        return view('jurusan.proposals.index', compact('proposals', 'bidang'));
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