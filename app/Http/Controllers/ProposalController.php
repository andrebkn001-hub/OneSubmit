<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;

class ProposalController extends Controller
{
    // 🟢 Menyimpan proposal baru
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string',
            'judul_proposal' => 'required|string',
            'bidang_minat' => 'required|string',
            'file_proposal' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        // Simpan file ke storage/public/proposals
        $filePath = $request->file('file_proposal')->store('proposals', 'public');

        // Simpan data ke database
        Proposal::create([
            'user_id' => auth()->id(),
            'nama_lengkap' => auth()->user()->name,
            'nim' => $request->nim,
            'judul_proposal' => $request->judul_proposal,
            'bidang_minat' => $request->bidang_minat,
            'file_proposal' => $filePath,
            'status' => 'Menunggu Validasi',
        ]);

        return redirect()->back()->with('success', 'Proposal berhasil diajukan!');
    }

    // 🟣 Menampilkan status proposal mahasiswa
    public function status()
    {
        // Ambil semua proposal milik user yang sedang login
        $proposals = Proposal::where('user_id', auth()->id())->get();

        // Kirim data ke view mahasiswa.status
        return view('mahasiswa.status', compact('proposals'));
    }
}
