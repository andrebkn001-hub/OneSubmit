<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;

class AdminProposalController extends Controller
{
    public function index()
    {
        $proposals = Proposal::latest()->get();
        return view('admin.proposals.index', compact('proposals'));
    }

    public function approve($id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->status = 'disetujui';
        $proposal->save();

        return redirect()->back()->with('success', 'Proposal disetujui!');
    }

    public function reject($id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->status = 'ditolak';
        $proposal->save();

        return redirect()->back()->with('error', 'Proposal ditolak!');
    }
}
