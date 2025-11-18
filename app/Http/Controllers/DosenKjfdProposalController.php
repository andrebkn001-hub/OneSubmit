<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Services\ProposalService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; // <<< DITAMBAHKAN: Diperlukan untuk mengirim file
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class DosenKjfdProposalController extends Controller
{
    public function __construct(
        private ProposalService $proposalService
    ) {
        $this->middleware(['auth', 'role:dosen_kjfd']);
    }

    /**
     * Display proposals assigned to this dosen KJFD.
     */
    public function index(Request $request): View
    {
        $query = Proposal::where('dosen_kjfd_id', Auth::id());

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter NIM
        if ($request->filled('nim')) {
            $query->where('nim', 'like', '%' . $request->nim . '%');
        }

        // Filter nama mahasiswa
        if ($request->filled('nama_lengkap')) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        // Filter judul proposal
        if ($request->filled('judul')) {
            $query->where('judul', 'like', '%' . $request->judul . '%');
        }

        $proposals = $query->latest()->get();
        return view('dosen_kjfd.proposals.index', compact('proposals'));
    }

    /**
     * Approve proposal.
     */
    public function approve(int $id): RedirectResponse
    {
        try {
            $proposal = Proposal::findOrFail($id);

            if (!$this->proposalService->dosenKjfdAssignedToProposal($proposal, Auth::id())) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menyetujui proposal ini.');
            }

            // Generate surat ACC
            $pdf = Pdf::loadView('pdf.acc-letter', [
                'proposal' => $proposal,
                'tanggal' => now()->translatedFormat('d F Y'),
                'dosenKjfd' => Auth::user(),
            ]);

            // Simpan file PDF
            $accLetterPath = 'acc-letters/' . $proposal->nim . '_' . now()->format('Ymd_His') . '.pdf';
            Storage::disk('public')->put($accLetterPath, $pdf->output());

            // Update proposal dengan status dan path surat ACC
            $this->proposalService->updateProposal($proposal, [
                'status' => 'disetujui',
                'acc_letter_path' => $accLetterPath
            ]);

            // Kirim notifikasi email ke mahasiswa
            $mahasiswa = $proposal->user;
            if ($mahasiswa && $mahasiswa->email) {
                $mahasiswa->notify(new \App\Notifications\ProposalActionAlert($proposal, 'mahasiswa', Auth::user()));
            }

            return redirect()->back()->with('success', 'Proposal berhasil disetujui dan surat ACC telah dibuat. Notifikasi email telah dikirim ke mahasiswa.');
    } catch (\Exception $e) {
            // Catat error detail ke log untuk debugging
            Log::error('Error saat approve proposal id=' . $id . ' oleh dosen KJFD id=' . Auth::id() . ': ' . $e->getMessage(), [
                'exception' => $e,
                'proposal_id' => $id,
                'dosen_id' => Auth::id(),
            ]);

            // Kembalikan pesan error yang lebih informatif ke UI sementara (tanpa stacktrace)
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui proposal: ' . $e->getMessage());
        }
    }

    /**
     * Send proposal for revision with message.
     */
    public function revise(Request $request, int $id): RedirectResponse
    {
        try {
            $validatedData = $request->validate([
                'revision_message' => 'required|string|min:10|max:1000',
            ]);

            $proposal = Proposal::findOrFail($id);

            if (!$this->proposalService->dosenKjfdAssignedToProposal($proposal, Auth::id())) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk merevisi proposal ini.');
            }

            $this->proposalService->updateProposal($proposal, [
                'status' => 'revisi',
                'revision_message' => $validatedData['revision_message'],
            ]);

            // Kirim notifikasi email ke mahasiswa
            $mahasiswa = $proposal->user;
            if ($mahasiswa && $mahasiswa->email) {
                $mahasiswa->notify(new \App\Notifications\ProposalActionAlert($proposal, 'mahasiswa', Auth::user()));
            }

            return redirect()->back()->with('success', 'Proposal berhasil direvisi. Pesan revisi dan notifikasi email telah dikirim ke mahasiswa.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat merevisi proposal. Silakan coba lagi.');
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

            if (!$this->proposalService->dosenKjfdAssignedToProposal($proposal, Auth::id())) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menolak proposal ini.');
            }

            $this->proposalService->updateProposal($proposal, [
                'status' => 'ditolak',
                'rejection_message' => $validatedData['rejection_message'],
            ]);

            // Kirim notifikasi email ke mahasiswa
            $mahasiswa = $proposal->user;
            if ($mahasiswa && $mahasiswa->email) {
                $mahasiswa->notify(new \App\Notifications\ProposalActionAlert($proposal, 'mahasiswa', Auth::user()));
            }

            return redirect()->back()->with('error', 'Proposal berhasil ditolak dengan alasan: ' . $validatedData['rejection_message'] . ' Notifikasi email telah dikirim ke mahasiswa.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menolak proposal. Silakan coba lagi.');
        }
    }

    // 🚀 FUNGSI BARU: MENGIRIM FILE PROPOSAL VIA CONTROLLER (FIX 404)
    /**
     * View/Download file proposal.
     * Menggunakan mekanisme Controller untuk menghindari masalah Symbolic Link.
     */
    public function viewFile(int $id)
    {
        $proposal = Proposal::findOrFail($id);

        // Otorisasi: Pastikan dosen KJFD yang ditugaskan dapat melihat file
        if (!$this->proposalService->dosenKjfdAssignedToProposal($proposal, Auth::id())) {
            abort(403, 'Anda tidak memiliki izin untuk melihat file proposal ini.');
        }

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