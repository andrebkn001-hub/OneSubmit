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
                // file size rules are in kilobytes. min:200 => 200 KB, max:5120 => 5 MB
                'file_proposal' => 'required|file|mimes:pdf,doc,docx|min:200|max:5120',
            ]);

            $filePath = $this->proposalService->uploadProposalFile($request);

            $this->proposalService->createProposal([
                'user_id' => Auth::id(),
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'nim' => $validatedData['nim'],
                'judul' => $validatedData['judul'],
                'bidang_minat' => $validatedData['bidang_minat'],
                'file_path' => $filePath,
                'status' => 'menunggu_verifikasi',
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
        $proposals = Proposal::where('user_id', Auth::id())->latest()->get();

        return view('mahasiswa.status', compact('proposals'));
    }

    /**
     * Display layanan page for mahasiswa.
     */
    public function layanan(): View
    {
        $files = [
            [
                'name' => 'PEDOMAN SKRIPSI PRODI SISTEM INFORMASI',
                'filename' => 'pedoman_skripsi_prodi_sistem_informasi.pdf'
            ],
            [
                'name' => 'PEDOMAN SKRIPSI PRODI SISTEM INFORMASI (TAMBAHAN)',
                'filename' => 'pedoman_skripsi_prodi_sistem_informasi_tambahan.pdf'
            ],
            [
                'name' => 'PEDOMAN PROSEDUR PENULISAN SKRIPSI',
                'filename' => 'pedoman_prosedur_penulisan_skripsi.pdf'
            ],
            [
                'name' => 'PEDOMAN PROSEDUR PENULISAN SKRIPSI (FLOWCHART)',
                'filename' => 'pedoman_prosedur_penulisan_skripsi_flowchart.pdf'
            ],
            [
                'name' => 'SYARAT PROPOSAL SKRIPSI',
                'filename' => 'syarat_proposal_skripsi.pdf'
            ],
            [
                'name' => 'TEMPLATE PROPOSAL SKRIPSI',
                'filename' => 'template_proposal_skripsi.pdf'
            ],
        ];

        return view('mahasiswa.layanan', compact('files'));
    }

    /**
     * Download file from layanan.
     */
    public function downloadLayanan(string $file)
    {
        $allowedFiles = [
            'pedoman_skripsi_prodi_sistem_informasi.pdf',
            'pedoman_skripsi_prodi_sistem_informasi_tambahan.pdf',
            'pedoman_prosedur_penulisan_skripsi.pdf',
            'pedoman_prosedur_penulisan_skripsi_flowchart.pdf',
            'syarat_proposal_skripsi.pdf',
            'template_proposal_skripsi.pdf'
        ];

        if (!in_array($file, $allowedFiles)) {
            abort(404);
        }

        $path = public_path('layanan/skripsi/' . $file);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }
}
