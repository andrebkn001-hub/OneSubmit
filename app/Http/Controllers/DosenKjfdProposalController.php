<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenKjfdProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:dosen_kjfd']);
    }

    public function index(Request $request)
    {
        $query = Proposal::where('dosen_kjfd_id', Auth::id())
                         ->where('status', 'menunggu verifikasi dosen kjfd');

        if ($request->has('nim') && !empty($request->nim)) {
            $query->where('nim', 'like', '%' . $request->nim . '%');
        }

        $proposals = $query->latest()->get();
        return view('dosen_kjfd.proposals.index', compact('proposals'));
    }

    public function approve($id)
    {
        $proposal = Proposal::findOrFail($id);
        if ($proposal->dosen_kjfd_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menyetujui proposal ini.');
        }

        $proposal->status = 'disetujui';
        $proposal->save();

        return redirect()->back()->with('success', 'Proposal berhasil disetujui.');
    }

    public function revise(Request $request, $id)
    {
        $request->validate([
            'revision_message' => 'required|string|min:10',
        ]);

        $proposal = Proposal::findOrFail($id);
        if ($proposal->dosen_kjfd_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk merevisi proposal ini.');
        }

        $proposal->status = 'revisi';
        $proposal->revision_message = $request->revision_message;
        $proposal->save();

        return redirect()->back()->with('success', 'Proposal berhasil direvisi. Pesan revisi telah dikirim ke mahasiswa.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_message' => 'required|string|min:10',
        ]);

        $proposal = Proposal::findOrFail($id);
        if ($proposal->dosen_kjfd_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menolak proposal ini.');
        }

        $proposal->status = 'ditolak';
        $proposal->rejection_message = $request->rejection_message;
        $proposal->save();

        return redirect()->back()->with('error', 'Proposal berhasil ditolak dengan alasan: ' . $request->rejection_message);
    }
}
