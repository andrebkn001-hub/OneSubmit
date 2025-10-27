<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Services\ProposalService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; // <<< DITAMBAHKAN: Diperlukan untuk mengirim file

class AdminProposalController extends Controller
{
    public function __construct(
        private ProposalService $proposalService
    ) {}

    /**
     * Display list of proposals for admin.
     */
    public function index(Request $request): View
    {
        $query = Proposal::query();

        if ($request->has('nim') && !empty($request->nim)) {
            $query->where('nim', 'like', '%' . $request->nim . '%');
        }

        $proposals = $query->latest()->get();
        return view('admin.proposals.index', compact('proposals'));
    }

    /**
     * Approve proposal and assign to appropriate dosen KJFD.
     */
    public function approve(int $id): RedirectResponse
    {
        try {
            $proposal = Proposal::findOrFail($id);
            $dosenKjfd = $this->proposalService->findAvailableDosenKjfd($proposal->bidang_minat);

            if (!$dosenKjfd) {
                return redirect()->back()->with('error', 'Tidak ada dosen KJFD yang tersedia untuk bidang ' . $proposal->bidang_minat . '.');
            }

            $this->proposalService->updateProposal($proposal, [
                'status' => 'menunggu verifikasi dosen kjfd',
                'dosen_kjfd_id' => $dosenKjfd->id,
            ]);

            return redirect()->back()->with('success', 'Proposal berhasil diteruskan ke Dosen KJFD bidang ' . $proposal->bidang_minat . '.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui proposal. Silakan coba lagi.');
        }
    }

    /**
     * Reject proposal with rejection message.
     */
    public function reject(Request $request, int $id): RedirectResponse
    {
        try {
            $validatedData = $request->validate([
                'rejection_message' => 'required|string|min:10|max:1000',
            ]);

            $proposal = Proposal::findOrFail($id);

            $this->proposalService->updateProposal($proposal, [
                'status' => 'ditolak',
                'rejection_message' => $validatedData['rejection_message'],
            ]);

            return redirect()->back()->with('error', 'Proposal ditolak dengan alasan: ' . $validatedData['rejection_message']);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menolak proposal. Silakan coba lagi.');
        }
    }

    // 🚀 FUNGSI BARU UNTUK MENGATASI ERROR 404 (Lihat File)
    /**
     * View/Download file proposal untuk role Admin.
     */
    public function viewFile(int $id)
    {
        $proposal = Proposal::findOrFail($id);

        // Otorisasi: Cek keberadaan file saja, karena Admin memiliki akses penuh
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