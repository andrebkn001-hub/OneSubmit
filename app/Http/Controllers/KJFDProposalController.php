<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;

class KJFDProposalController extends Controller
{
    public function index()
    {
        $proposals = Proposal::whereNotNull('dosen_kjfd')->get();
        return view('kjfd.proposal.index', compact('proposals'));
    }

    public function edit($id)
    {
        $proposal = Proposal::findOrFail($id);
        return view('kjfd.proposal.edit', compact('proposal'));
    }

    public function update(Request $request, $id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->update([
            'catatan' => $request->catatan,
            'status' => $request->status
        ]);

        return redirect()->route('kjfd.proposal.index')->with('success', 'Proposal telah diperbarui.');
    }
}
