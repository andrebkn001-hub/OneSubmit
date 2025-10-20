<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    // Tampilkan form pengajuan proposal
    public function create()
    {
        return view('proposals.create');
    }

    // Simpan proposal ke database
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:20',
            'judul' => 'required|string|max:255',
            'bidang_minat' => 'required|string|max:100',
            'file_proposal' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Upload file proposal
        $file = $request->file('file_proposal');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('proposals', $fileName, 'public');

        // Simpan ke database
        Proposal::create([
            'user_id' => Auth::id(),
            'nama_lengkap' => Auth::user()->name,
            'nim' => $request->nim,
            'judul' => $request->judul,
            'bidang_minat' => $request->bidang_minat,
            'file_path' => $filePath,
            'status' => 'menunggu verifikasi',
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Proposal berhasil dikirim!');
    }

    // Tampilkan status proposal mahasiswa
    public function status(Request $request)
    {
        $query = Proposal::where('user_id', Auth::id());

        if ($request->has('nim') && !empty($request->nim)) {
            $query->where('nim', 'like', '%' . $request->nim . '%');
        }

        $proposals = $query->get();
        return view('proposals.status', compact('proposals'));
    }

    // Update proposal untuk revisi (upload ulang)
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'bidang_minat' => 'required|string|max:100',
            'file_proposal' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $proposal = Proposal::findOrFail($id);
        if ($proposal->user_id !== Auth::id() || $proposal->status !== 'revisi') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengupdate proposal ini.');
        }

        // Upload file baru
        $file = $request->file('file_proposal');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('proposals', $fileName, 'public');

        $proposal->judul = $request->judul;
        $proposal->bidang_minat = $request->bidang_minat;
        $proposal->file_path = $filePath;
        $proposal->status = 'menunggu verifikasi'; // Reset status setelah upload ulang
        $proposal->revision_message = null; // Clear revision message
        $proposal->save();

        return redirect()->route('mahasiswa.status')->with('success', 'Proposal berhasil diupdate dan dikirim ulang untuk verifikasi.');
    }
}
