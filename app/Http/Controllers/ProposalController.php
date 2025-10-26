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
        return view('mahasiswa.status', compact('proposals'));
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
                'status' => 'menunggu verifikasi dosen kjfd',
                'revision_message' => null,
                'rejection_message' => null,
            ]);

            return redirect()->route('mahasiswa.status')->with('success', 'Proposal revisi berhasil diupload dan dikirim kembali ke dosen KJFD untuk verifikasi.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate proposal. Silakan coba lagi.');
        }
    }

    /**
     * Download surat pemberitahuan proposal disetujui.
     */
    public function downloadSurat(int $id): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        try {
            $proposal = Proposal::findOrFail($id);

            if (!$this->proposalService->userOwnsProposal($proposal, Auth::id()) ||
                !$proposal->isApproved()) {
                abort(403, 'Anda tidak memiliki izin untuk mengunduh surat ini.');
            }

            // Generate PDF surat pemberitahuan
            $pdf = $this->generateSuratPemberitahuan($proposal);

            $filename = 'surat_pemberitahuan_' . $proposal->nim . '_' . now()->format('Y-m-d') . '.pdf';

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $filename);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunduh surat. Silakan coba lagi.');
        }
    }

    /**
     * Generate surat pemberitahuan PDF.
     */
    private function generateSuratPemberitahuan(Proposal $proposal)
    {
        // Menggunakan TCPDF atau library PDF lainnya
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator('OneSubmit');
        $pdf->SetAuthor('Universitas');
        $pdf->SetTitle('Surat Pemberitahuan Proposal Disetujui');
        $pdf->SetSubject('Surat Pemberitahuan');

        // Set margins
        $pdf->SetMargins(20, 25, 20);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 15);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Header
        $pdf->Cell(0, 10, 'UNIVERSITAS [NAMA UNIVERSITAS]', 0, 1, 'C');
        $pdf->Cell(0, 10, 'FAKULTAS [NAMA FAKULTAS]', 0, 1, 'C');
        $pdf->Cell(0, 10, 'PROGRAM STUDI [NAMA PRODI]', 0, 1, 'C');
        $pdf->Ln(10);

        // Nomor surat
        $pdf->Cell(0, 10, 'Nomor: ' . $this->generateNomorSurat($proposal), 0, 1, 'L');
        $pdf->Ln(5);

        // Perihal
        $pdf->Cell(0, 10, 'Perihal: Pemberitahuan Persetujuan Proposal Tugas Akhir', 0, 1, 'L');
        $pdf->Ln(5);

        // Tanggal
        $pdf->Cell(0, 10, 'Jakarta, ' . now()->format('d F Y'), 0, 1, 'L');
        $pdf->Ln(10);

        // Kepada
        $pdf->Cell(0, 10, 'Kepada Yth.', 0, 1, 'L');
        $pdf->Cell(0, 10, $proposal->nama_lengkap, 0, 1, 'L');
        $pdf->Cell(0, 10, 'NIM: ' . $proposal->nim, 0, 1, 'L');
        $pdf->Ln(10);

        // Isi surat
        $pdf->MultiCell(0, 10, 'Dengan hormat,', 0, 'L');
        $pdf->Ln(5);

        $isi = "Berdasarkan hasil verifikasi yang telah dilakukan, kami informasikan bahwa proposal tugas akhir dengan judul:

\"{$proposal->judul}\"

Bidang Minat: {$proposal->bidang_minat}

Telah disetujui untuk dilanjutkan ke tahap selanjutnya.

Demikian pemberitahuan ini disampaikan untuk diketahui dan dilaksanakan sebagaimana mestinya.";

        $pdf->MultiCell(0, 10, $isi, 0, 'L');
        $pdf->Ln(15);

        // Penutup
        $pdf->Cell(0, 10, 'Hormat kami,', 0, 1, 'L');
        $pdf->Ln(20);

        // Tanda tangan
        $pdf->Cell(0, 10, 'Dosen Pembimbing KJFD', 0, 1, 'L');
        $pdf->Ln(15);
        $pdf->Cell(0, 10, $proposal->dosenKjfd->name ?? 'Dosen KJFD', 0, 1, 'L');
        $pdf->Cell(0, 10, 'NIP: [NIP DOSEN]', 0, 1, 'L');

        return $pdf;
    }

    /**
     * Generate nomor surat.
     */
    private function generateNomorSurat(Proposal $proposal): string
    {
        $tahun = now()->format('Y');
        $bulan = now()->format('m');
        $nomor = str_pad($proposal->id, 3, '0', STR_PAD_LEFT);

        return "UNIV/{$tahun}/{$bulan}/{$nomor}";
    }
}
