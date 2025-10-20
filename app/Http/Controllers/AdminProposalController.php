<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use Illuminate\Support\Facades\Log;

class AdminProposalController extends Controller
{
    public function index()
    {
        $proposals = Proposal::all();
        return view('admin.proposal.index', compact('proposals'));
    }

    public function edit($id)
    {
        $proposal = Proposal::findOrFail($id);
        return view('admin.proposal.edit', compact('proposal'));
    }

    public function update(Request $request, $id)
    {
        try {
            $proposal = Proposal::findOrFail($id);
            $proposal->update([
                'dosen_kjfd' => $request->dosen_kjfd,
                'status' => 'Diarahkan'
            ]);

            // simulasi kirim notifikasi
            if (rand(0,1) === 0) { // misal gagal random
                throw new \Exception('Gagal mengirim notifikasi ke dosen.');
            }

            return redirect()->route('admin.proposal.index')->with('success', 'Proposal berhasil diarahkan.');
        } catch (\Exception $e) {
            Log::error('Error pengarahan: '.$e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }
}
