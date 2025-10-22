<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Services\ProposalService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function __construct(
        private ProposalService $proposalService
    ) {}

    /**
     * Display the mahasiswa dashboard.
     */
    public function dashboard(): View
    {
        return view('mahasiswa.dashboard');
    }

    /**
     * Store a new proposal.
     */
    public function storeProposal(Request $request): RedirectResponse
    {
        try {
            $validatedData = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'nim' => 'required|string|max:20',
                'judul' => 'required|string|max:255',
                'bidang_minat' => 'required|string|max:100',
                'file_proposal' => 'required|file|mimes:pdf,doc,docx|max:2048',
            ]);

            $filePath = $this->proposalService->uploadProposalFile($request);

            $this->proposalService->createProposal([
                'user_id' => Auth::id(),
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'nim' => $validatedData['nim'],
                'judul' => $validatedData['judul'],
                'bidang_minat' => $validatedData['bidang_minat'],
                'file_path' => $filePath,
                'status' => 'menunggu verifikasi',
            ]);

            return redirect()->route('mahasiswa.status')->with('success', 'Proposal berhasil diajukan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengajukan proposal. Silakan coba lagi.');
        }
    }

    /**
     * Display proposal status for the authenticated mahasiswa.
     */
    public function status(Request $request): View
    {
        $query = Proposal::where('user_id', Auth::id());

        if ($request->has('nim') && !empty($request->nim)) {
            $query->where('nim', 'like', '%' . $request->nim . '%');
        }

        $proposals = $query->latest()->get();

        return view('mahasiswa.status', compact('proposals'));
    }
}
