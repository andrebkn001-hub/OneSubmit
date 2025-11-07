<?php

namespace App\Http\Controllers;

use App\Models\KjfdQuota;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;

class AdminQuotaController extends Controller
{
    public function index(): View
    {
        $quotas = KjfdQuota::orderBy('bidang')->get();
        return view('admin.quotas.index', compact('quotas'));
    }

    public function edit(int $id): View
    {
        $quota = KjfdQuota::findOrFail($id);
        return view('admin.quotas.edit', compact('quota'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'quota' => 'required|integer|min:0|max:10000',
        ]);

        $quota = KjfdQuota::findOrFail($id);
        $quota->quota = (int) $request->input('quota');
        $quota->save();

        // Clear all kjfd cache keys to reflect changes immediately
        $kjfdKeys = \Illuminate\Support\Facades\Cache::get('cached_kjfd_keys', []);
        foreach ($kjfdKeys as $key) {
            \Illuminate\Support\Facades\Cache::forget($key);
        }
        \Illuminate\Support\Facades\Cache::forget('cached_kjfd_keys');

        return Redirect::route('admin.quotas.index')->with('success', 'Quota berhasil diperbarui.');
    }
}
