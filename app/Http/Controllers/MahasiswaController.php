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
     * Display halaman pencarian judul skripsi yang disetujui.
     */
    public function judulSkripsi(): View
    {
        $approvedProposals = Proposal::where('status', 'disetujui')
            ->select('judul', 'bidang_minat')
            ->orderBy('judul')
            ->get();

        return view('judul-skripsi', compact('approvedProposals'));
    }

    /**
     * Display halaman dosen dan staff.
     */
    public function dosenStaff(): View
    {
        $dosenStaff = [
            // KETUA JURUSAN
            ['nama' => 'Tisha Melia, B.Sc., M.Sc, Ph.D', 'jabatan' => 'KETUA JURUSAN', 'nip' => '198403082022032001'],

            // SEKRETARIS JURUSAN
            ['nama' => 'Fetsyia, S.Kom., M.Kom', 'jabatan' => 'SEKRETARIS JURUSAN', 'nip' => '197907082005012002'],

            // KO PRODI S1- SISTEM INFORMASI
            ['nama' => 'Drs. Sukamto, M. Kom', 'jabatan' => 'KO PRODI S1- SISTEM INFORMASI', 'nip' => '196403041991031003'],

            // KO PRODI D3- MANAJEMEN INFORMATIKA
            ['nama' => 'Aldi Fitriansyah, S. Kom, MIT', 'jabatan' => 'KO PRODI D3- MANAJEMEN INFORMATIKA', 'nip' => '197809052003121002'],

            // STAFF AKADEMIK
            ['nama' => 'Fitria Malinda, ST', 'jabatan' => 'STAFF AKADEMIK', 'nip' => ''],
            ['nama' => 'Marsalinur, S. Sos', 'jabatan' => 'STAFF AKADEMIK', 'nip' => ''],

            // Information Management KJFD
            ['nama' => 'Yanti Andriyani, ST, MTI, Ph.D', 'jabatan' => 'KJFD Information Management - KETUA', 'nip' => '198105122008122001'],
            ['nama' => 'Fetsyia, S.Kom., M.Kom', 'jabatan' => 'KJFD Information Management', 'nip' => '197907082005012002'],
            ['nama' => 'Joko Risanto, S. Kom, M. Kom', 'jabatan' => 'KJFD Information Management', 'nip' => '19891030202003121002'],
            ['nama' => 'Rila Ario Nugroho, S. Si., M. Kom', 'jabatan' => 'KJFD Information Management', 'nip' => '198501232019031006'],
            ['nama' => 'Sonya Metari, S.Sc, M.Sc', 'jabatan' => 'KJFD Information Management', 'nip' => '198905042022032005'],
            ['nama' => 'Mirdatul Husnah, M.Kom', 'jabatan' => 'KJFD Information Management', 'nip' => '199007112024062001'],
            ['nama' => 'Lina Purwanti, S.Kom., M.Kom', 'jabatan' => 'KJFD Information Management', 'nip' => '199308062025062005'],
            ['nama' => 'Boy Syahfari Nugraha, H, ST., M.Kom', 'jabatan' => 'KJFD Information Management', 'nip' => '199701032025061007'],

            // Information Retrieval KJFD
            ['nama' => 'Zaitul Bahri, S.Si., M. Kom', 'jabatan' => 'KJFD Information Retrieval - KETUA', 'nip' => '198012311997021001'],
            ['nama' => 'Ai Anisah, Sh., SI., M. Sc', 'jabatan' => 'KJFD Information Retrieval', 'nip' => '198901262019031006'],
            ['nama' => 'Gita Santria, ST, MIT', 'jabatan' => 'KJFD Information Retrieval', 'nip' => '198004292008121002'],
            ['nama' => 'Astried, M. Kom', 'jabatan' => 'KJFD Information Retrieval', 'nip' => '197810092005012002'],
            ['nama' => 'Teguh Sujana, M. Kom', 'jabatan' => 'KJFD Information Retrieval', 'nip' => '199301282024061003'],
            ['nama' => 'Yandiko Saputra Sy, ST, M. Kom', 'jabatan' => 'KJFD Information Retrieval', 'nip' => '199001022024061001'],
            ['nama' => 'Khairmi Sukmawati, S.T., M.Kom', 'jabatan' => 'KJFD Information Retrieval', 'nip' => '199001312025062005'],

            // Data Engineering KJFD
            ['nama' => 'Roni Salambue, S.Kom, M. Si', 'jabatan' => 'KJFD Data Engineering - KETUA', 'nip' => '197409301971121001'],
            ['nama' => 'Prof. Dr. Riftus, S. Si, M. Kom', 'jabatan' => 'KJFD Data Engineering', 'nip' => '196010091987032002'],
            ['nama' => 'Zul Indra, ST, M.Sc', 'jabatan' => 'KJFD Data Engineering', 'nip' => '198603032022031003'],
            ['nama' => 'Affirman, S. Kom, M. Kom', 'jabatan' => 'KJFD Data Engineering', 'nip' => '198005202005011002'],
            ['nama' => 'Tisha Melia, B.Sc., M.Sc, Ph.D', 'jabatan' => 'KJFD Data Engineering', 'nip' => '198403082022032001'],
            ['nama' => 'Rahmat Hidayat, M. Kom', 'jabatan' => 'KJFD Data Engineering', 'nip' => '199605032024061000'],
            ['nama' => 'Haris Tri Saputra, M. Kom', 'jabatan' => 'KJFD Data Engineering', 'nip' => '199003242024061001'],
            ['nama' => 'Chairun Nas, S.Kom., M.Kom', 'jabatan' => 'KJFD Data Engineering', 'nip' => '199505082025061005'],
            ['nama' => 'Herlina, S.Kom., M.Cs', 'jabatan' => 'KJFD Data Engineering', 'nip' => '199111292025062004'],

            // Business Intelligence KJFD
            ['nama' => 'Evfi Mahdiyah, S. Kom., MIT', 'jabatan' => 'KJFD Business Intelligence - KETUA', 'nip' => '197502192001122002'],
            ['nama' => 'Dr. Ibnu Daqiqil Id, S. Kom, M. TI', 'jabatan' => 'KJFD Business Intelligence', 'nip' => '198603202019031009'],
            ['nama' => 'Dr. Rahmad Kurniawan, ST, MIT', 'jabatan' => 'KJFD Business Intelligence', 'nip' => '198001112003121001'],
            ['nama' => 'Aldi Fitriansyah, S. Kom, MIT', 'jabatan' => 'KJFD Business Intelligence', 'nip' => '197809052003121002'],
            ['nama' => 'Drs. Sukamto, M. Kom', 'jabatan' => 'KJFD Business Intelligence', 'nip' => '196403041991031003'],
            ['nama' => 'Finanta Okmayura, T, M.Kom', 'jabatan' => 'KJFD Business Intelligence', 'nip' => '199110232024062001'],
            ['nama' => 'Khairul Fajri Ilahi, S.Kom., M.Kom', 'jabatan' => 'KJFD Business Intelligence', 'nip' => '199403042025061006'],
        ];

        return view('dosen-staff', compact('dosenStaff'));
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
