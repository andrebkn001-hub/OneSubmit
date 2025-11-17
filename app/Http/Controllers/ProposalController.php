<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Services\ProposalService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; // <<< IMPORT STORAGE SUDAH BENAR

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
                'status' => 'menunggu_verifikasi',
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
    public function updateRevisi(Request $request, int $id): RedirectResponse
    {
        try {
            // Validasi input
            $request->validate([
                'judul' => [
                    'required',
                    'string',
                    'max:255',
                    function ($attribute, $value, $fail) {
                        $normalized = trim(preg_replace('/\s+/u', ' ', $value));
                        $words = preg_split('/\s+/u', $normalized, -1, PREG_SPLIT_NO_EMPTY);
                        $count = count($words);
                        if ($count < 7 || $count > 15) {
                            $fail('Judul proposal harus terdiri dari 7 hingga 15 kata. Saat ini: '.$count.' kata.');
                        }
                    }
                ],
                'bidang_minat' => 'required|string|max:100',
                'file_proposal' => 'required|file|mimes:pdf,doc,docx|min:200|max:5120',
            ]);

            $proposal = Proposal::findOrFail($id);

            // Cek kepemilikan dan status
            if ($proposal->user_id !== Auth::id() || $proposal->status !== 'revisi') {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengupload revisi proposal ini.');
            }

            // Upload file baru
            $file = $request->file('file_proposal');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('proposals', $fileName, 'public');

            // Update proposal
            $proposal->update([
                'judul' => $request->judul,
                'bidang_minat' => $request->bidang_minat,
                'file_path' => $filePath,
                'status' => 'menunggu_verifikasi_dosen_kjfd',
                'revision_message' => null,
            ]);

            // Set flash message dan status
            session()->flash('success', 'Revisi proposal berhasil diupload.');
            session()->flash('revision_uploaded', $proposal->id);

            return redirect()->route('mahasiswa.status');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate proposal. Silakan coba lagi.');
        }
    }

    /**
     * Download surat ACC proposal.
     */
    public function downloadAccLetter(int $id)
    {
        try {
            $proposal = Proposal::findOrFail($id);

            // Verifikasi kepemilikan dan status
            if (!$this->proposalService->userOwnsProposal($proposal, Auth::id()) || 
                $proposal->status !== 'disetujui' || 
                !$proposal->acc_letter_path) {
                abort(403, 'Anda tidak memiliki akses ke surat ACC ini.');
            }

            // Verifikasi keberadaan file
            if (!Storage::disk('public')->exists($proposal->acc_letter_path)) {
                abort(404, 'File surat ACC tidak ditemukan.');
            }

            // Kirim file ke browser
            return Storage::disk('public')->response(
                $proposal->acc_letter_path,
                'Surat_ACC_' . $proposal->nim . '.pdf',
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="Surat_ACC_' . $proposal->nim . '.pdf"'
                ]
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunduh surat ACC. Silakan coba lagi.');
        }
    }

    /**
     * Download surat pemberitahuan proposal disetujui.
     */
    public function downloadSurat(int $id)
    {
        try {
            $proposal = Proposal::findOrFail($id);

            if (!$this->proposalService->userOwnsProposal($proposal, Auth::id()) ||
                !$proposal->isApproved()) {
                abort(403, 'Anda tidak memiliki izin untuk mengunduh surat ini.');
            }

            if (!$proposal->acc_letter_path) {
                return redirect()->back()->with('error', 'Surat ACC belum tersedia.');
            }

            // Verifikasi keberadaan file
            if (!Storage::disk('public')->exists($proposal->acc_letter_path)) {
                return redirect()->back()->with('error', 'File surat ACC tidak ditemukan.');
            }

            // Kirim file ke browser
            return Storage::disk('public')->response(
                $proposal->acc_letter_path,
                'Surat_ACC_' . $proposal->nim . '.pdf',
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="Surat_ACC_' . $proposal->nim . '.pdf"'
                ]
            );

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunduh surat. Silakan coba lagi.');
        }
    }

    // 🚀 FUNGSI BARU UNTUK MENGATASI ERROR 404 (Pengiriman File)
    /**
     * Mengirim file proposal secara paksa dari storage/app/public ke browser.
     */
    public function viewFile($id)
    {
        // 1. Cari Proposal berdasarkan ID
        $proposal = Proposal::findOrFail($id);

        // 2. Ambil path file (misalnya: proposals/namafile.pdf)
        $filePath = $proposal->file_path; 

        // 3. Verifikasi Keberadaan File
        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            // Jika path kosong atau file tidak ditemukan
            return abort(404, 'Berkas proposal tidak ditemukan di sistem penyimpanan. Silakan hubungi admin.');
        }

        // 4. Mengirimkan Respons File ke Browser
        // Menggunakan response() untuk mengirim file secara langsung dari storage
        return Storage::disk('public')->response($filePath, $proposal->judul . '.pdf', [
            'Content-Type' => 'application/pdf', 
            // 'inline' memaksa browser menampilkan file
            'Content-Disposition' => 'inline; filename="' . $proposal->judul . '.pdf"'
        ]);
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