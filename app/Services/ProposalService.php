<?php

namespace App\Services;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProposalService
{
    /**
     * Validate proposal data
     */
    public function validateProposalData(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'nim' => 'required|string|max:20',
            'judul' => 'required|string|max:255',
            'bidang_minat' => 'required|string|max:100',
            'file_proposal' => $isUpdate ? 'required|file|mimes:pdf,doc,docx|max:2048' : 'required|file|mimes:pdf,doc,docx|max:2048',
        ];

        return $request->validate($rules);
    }

    /**
     * Upload proposal file
     */
    public function uploadProposalFile(Request $request): string
    {
        $file = $request->file('file_proposal');
        if (!$file) {
            throw new \InvalidArgumentException('File proposal tidak ditemukan');
        }
        $fileName = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs('proposals', $fileName, 'public');
    }

    /**
     * Create a new proposal
     */
    public function createProposal(array $data): Proposal
    {
        try {
            return Proposal::create($data);
        } catch (\Exception $e) {
            Log::error('Failed to create proposal: ' . $e->getMessage());
            throw new \Exception('Gagal membuat proposal. Silakan coba lagi.');
        }
    }

    /**
     * Update an existing proposal
     */
    public function updateProposal(Proposal $proposal, array $data): Proposal
    {
        try {
            $proposal->update($data);
            return $proposal->fresh();
        } catch (\Exception $e) {
            Log::error('Failed to update proposal: ' . $e->getMessage());
            throw new \Exception('Gagal mengupdate proposal. Silakan coba lagi.');
        }
    }

    /**
     * Find available dosen KJFD for a specific bidang
     */
    public function findAvailableDosenKjfd(string $bidangMinat): ?User
    {
        return User::where('role', 'dosen_kjfd')
                  ->where('bidang', $bidangMinat)
                  ->first();
    }

    /**
     * Check if user owns the proposal
     */
    public function userOwnsProposal(Proposal $proposal, int $userId): bool
    {
        return $proposal->user_id === $userId;
    }

    /**
     * Check if dosen KJFD is assigned to the proposal
     */
    public function dosenKjfdAssignedToProposal(Proposal $proposal, int $dosenId): bool
    {
        return $proposal->dosen_kjfd_id === $dosenId;
    }

    /**
     * Check if proposal is in revision status
     */
    public function isProposalInRevision(Proposal $proposal): bool
    {
        return $proposal->status === 'revisi';
    }
}
