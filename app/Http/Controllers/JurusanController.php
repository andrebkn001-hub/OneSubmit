<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JurusanController extends Controller
{
    /**
     * Display KJFD selection page for ketua jurusan.
     */
    public function kjfdSelection(): View
    {
        return view('jurusan.proposals.kjfd');
    }

    /**
     * Display list of proposals for a specific KJFD bidang.
     */
    public function proposalsIndex(Request $request, string $bidang): View
    {
        $bidangFormatted = ucwords(str_replace('_', ' ', $bidang));
        $query = Proposal::where('bidang_minat', $bidangFormatted);

        if ($request->has('nim') && !empty($request->nim)) {
            $query->where('nim', 'like', '%' . $request->nim . '%');
        }

        $proposals = $query->latest()->get();

        return view('jurusan.proposals.index', compact('proposals', 'bidang'));
    }
}
