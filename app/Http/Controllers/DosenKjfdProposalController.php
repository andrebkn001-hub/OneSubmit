<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Services\ProposalService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

        // Filter berdasarkan status jika ada
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        } else {
            // Default: tampilkan yang perlu diverifikasi atau dalam proses
            $query->whereIn('status', ['menunggu verifikasi dosen kjfd', 'revisi']);
        }

        if ($request->has('nim') && !empty($request->nim)) {
            $query->where('nim', 'like', '%' . $request->nim . '%');
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

            $this->proposalService->updateProposal($proposal, [
                'status' => 'disetujui',
            ]);

            return redirect()->back()->with('success', 'Proposal berhasil disetujui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui proposal. Silakan coba lagi.');
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

            return redirect()->back()->with('success', 'Proposal berhasil direvisi. Pesan revisi telah dikirim ke mahasiswa.');
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

            return redirect()->back()->with('error', 'Proposal berhasil ditolak dengan alasan: ' . $validatedData['rejection_message']);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menolak proposal. Silakan coba lagi.');
        }
    }
}
