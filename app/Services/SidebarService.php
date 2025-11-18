<?php

namespace App\Services;

use App\Models\Proposal;
use Illuminate\Support\Facades\Cache;

class SidebarService
{
    /**
     * Get badge counts for Ketua Jurusan sidebar.
     * Cached for 60 seconds to reduce database queries.
     *
     * @return array
     */
    public function getKetuaJurusanBadges(): array
    {
        return Cache::remember('sidebar.ketua_jurusan.badges', 60, function () {
            return [
                'inbox_total' => $this->getInboxCount(),
                'inbox_aging' => $this->getAgingCount(),
                'waiting_verification' => $this->getWaitingVerificationCount(),
                'in_process' => $this->getInProcessCount(),
            ];
        });
    }

    /**
     * Get total items in inbox (needs Ketua Jurusan action).
     *
     * @return int
     */
    private function getInboxCount(): int
    {
        return Proposal::needsKetuaAction()->count();
    }

    /**
     * Get proposals aging more than 3 days.
     *
     * @return int
     */
    private function getAgingCount(): int
    {
        return Proposal::needsKetuaAction()->aging(3)->count();
    }

    /**
     * Get proposals waiting for verification.
     *
     * @return int
     */
    private function getWaitingVerificationCount(): int
    {
        return Proposal::where('status', 'menunggu_verifikasi')->count();
    }

    /**
     * Get proposals in process (all non-final states).
     *
     * @return int
     */
    private function getInProcessCount(): int
    {
        return Proposal::whereIn('status', [
            'menunggu_verifikasi',
            'menunggu_verifikasi_dosen_kjfd',
            'revisi'
        ])->count();
    }

    /**
     * Clear sidebar cache.
     *
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget('sidebar.ketua_jurusan.badges');
    }
}
