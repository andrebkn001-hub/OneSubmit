<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Services\ProposalService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProposalController extends Controller
{
    public function __construct(
        private ProposalService $proposalService
    ) {}

    /**
     * Display the proposal creation form.
     */
    public function create(): View
    {
        return view('proposals.create');
    }

    /**
     * Store a new proposal.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $this->proposalService->validateProposalData($request);

            $filePath = $this->proposalService->uploadProposalFile($request);

            $this->proposalService->createProposal([
                'user_id' => Auth::id(),
                'nama_lengkap' => Auth::user()->name,
                'nim' => $request->nim,
                'judul' => $request->judul,
                'bidang_minat' => $request->bidang_minat,
                'file_path' => $filePath,
                'status' => 'menunggu verifikasi',
            ]);

            return redirect()->route('mahasiswa.dashboard')->with('success', 'Proposal berhasil dikirim!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengirim proposal. Silakan coba lagi.');
        }
    }

    /**
     * Display proposal status for the authenticated user.
     */
    public function status(Request $request): View
    {
        $query = Proposal::where('user_id', Auth::id());

        if ($request->has('nim') && !empty($request->nim)) {
            $query->where('nim', 'like', '%' . $request->nim . '%');
        }

        $proposals = $query->latest()->get();
        return view('proposals.status', compact('proposals'));
    }

    /**
     * Update proposal for revision (re-upload).
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            $this->proposalService->validateProposalData($request, true);

            $proposal = Proposal::findOrFail($id);

            if (!$this->proposalService->userOwnsProposal($proposal, Auth::id()) ||
                !$this->proposalService->isProposalInRevision($proposal)) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengupdate proposal ini.');
            }

            $filePath = $this->proposalService->uploadProposalFile($request);

            $this->proposalService->updateProposal($proposal, [
                'judul' => $request->judul,
                'bidang_minat' => $request->bidang_minat,
                'file_path' => $filePath,
                'status' => 'menunggu verifikasi',
                'revision_message' => null,
            ]);

            return redirect()->route('mahasiswa.status')->with('success', 'Proposal berhasil diupdate dan dikirim ulang untuk verifikasi.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate proposal. Silakan coba lagi.');
        }
    }
}
