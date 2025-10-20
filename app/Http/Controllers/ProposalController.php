<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProposalController extends Controller
{
    // =====================================================
    // 📁 AREA ADMIN / KETUA KJFD
    // =====================================================

    /**
     * Menampilkan semua proposal untuk diverifikasi.
     */
    public function verifikasi()
    {
        $proposals = Proposal::with(['mahasiswa', 'dosen'])->get();

        return view('proposal.verifikasi', compact('proposals'));
    }

    /**
     * Menampilkan detail proposal untuk proses verifikasi / penugasan dosen.
     */
    public function verifikasiDetail($id)
    {
        $proposal = Proposal::with('mahasiswa')->findOrFail($id);
        $dosens = Dosen::all();

        return view('proposal.verifikasi_detail', compact('proposal', 'dosens'));
    }

    /**
     * Menugaskan dosen ke proposal tertentu.
     */
    public function assignDosen(Request $request, $id)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
        ]);

        $proposal = Proposal::findOrFail($id);
        $proposal->update(['dosen_id' => $validated['dosen_id']]);

        // Simulasi log penugasan
        Log::info("Proposal '{$proposal->judul}' ditugaskan ke Dosen ID: {$validated['dosen_id']}");

        return redirect()->route('verifikasi.index')
            ->with('success', 'Proposal berhasil ditugaskan ke Dosen KJFD.');
    }

    // =====================================================
    // 🎓 AREA DOSEN KJFD
    // =====================================================

    /**
     * Menampilkan daftar proposal yang ditugaskan ke dosen.
     */
    public function index()
    {
        $proposals = Proposal::with('mahasiswa')
            ->whereNotNull('dosen_id')
            ->get();

        return view('proposal.index', compact('proposals'));
    }

    /**
     * Menampilkan detail proposal yang ditugaskan.
     */
    public function show($id)
    {
        $proposal = Proposal::with('mahasiswa')->findOrFail($id);

        return view('proposal.show', compact('proposal'));
    }

    /**
     * Menyimpan hasil review dosen KJFD.
     */
    public function review(Request $request, $id)
    {
        $validated = $request->validate([
            'catatan' => 'required|string',
            'status' => 'required|in:diterima,ditolak',
        ]);

        $proposal = Proposal::findOrFail($id);
        $proposal->update([
            'catatan' => $validated['catatan'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('proposal.index')
            ->with('success', 'Review proposal berhasil disimpan.');
    }
}
