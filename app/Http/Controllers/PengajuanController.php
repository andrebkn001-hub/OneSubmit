<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::where('user_id', Auth::id())->latest()->get();
        return view('mahasiswa.pengajuan.index', compact('pengajuans'));
    }

    public function create()
    {
        return view('mahasiswa.pengajuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $request->file('file')->store('proposals', 'public');

        Pengajuan::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'file_path' => $filePath,
            'status' => 'menunggu',
        ]);

        return redirect()->route('pengajuan.index')->with('success', 'Proposal berhasil diajukan!');
    }
}