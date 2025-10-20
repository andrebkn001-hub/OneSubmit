<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\Request;

class AdminProposalController extends Controller
{
    public function index(Request $request)
    {
        $query = Proposal::query();

        if ($request->has('nim') && !empty($request->nim)) {
            $query->where('nim', 'like', '%' . $request->nim . '%');
        }

        $proposals = $query->latest()->get();
        return view('admin.proposals.index', compact('proposals'));
    }

    public function approve($id)
    {
        $proposal = Proposal::findOrFail($id);
        $dosenKjfd = User::where('role', 'dosen_kjfd')
                         ->where('bidang', $proposal->bidang_minat)
                         ->first();

        if (!$dosenKjfd) {
            return redirect()->back()->with('error', 'Tidak ada dosen KJFD yang tersedia untuk bidang ' . $proposal->bidang_minat . '.');
        }

        $proposal->status = 'menunggu verifikasi dosen kjfd'; // Status mahasiswa tetap "menunggu verifikasi"
        $proposal->dosen_kjfd_id = $dosenKjfd->id;
        $proposal->save();

        return redirect()->back()->with('success', 'Proposal berhasil diteruskan ke Dosen KJFD bidang ' . $proposal->bidang_minat . '.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_message' => 'required|string|min:10',
        ]);

        $proposal = Proposal::findOrFail($id);
        $proposal->status = 'ditolak';
        $proposal->rejection_message = $request->rejection_message;
        $proposal->save();

        return redirect()->back()->with('error', 'Proposal ditolak dengan alasan: ' . $request->rejection_message);
    }
}
