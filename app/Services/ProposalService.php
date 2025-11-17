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
            'judul' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Normalisasi spasi dan hitung kata (Indonesian words count OK with str_word_count)
                    $normalized = trim(preg_replace('/\s+/u', ' ', $value));
                    // str_word_count tanpa parameter kedua akan menghitung berdasarkan huruf a-z; untuk dukungan UTF-8 sederhana kita fallback ke explode by space
                    $words = preg_split('/\s+/u', $normalized, -1, PREG_SPLIT_NO_EMPTY);
                    $count = count($words);
                    if ($count < 7 || $count > 15) {
                        $fail('Judul proposal harus terdiri dari 7 hingga 15 kata. Saat ini: '.$count.' kata.');
                    }
                }
            ],
            'bidang_minat' => 'required|string|max:100',
            // file size rules are in kilobytes. min:200 => 200 KB, max:5120 => 5 MB
            'file_proposal' => $isUpdate ? 'required|file|mimes:pdf,doc,docx|min:200|max:5120' : 'required|file|mimes:pdf,doc,docx|min:200|max:5120',
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

    /**
     * Get status badge color for UI
     */
    public function getStatusBadgeColor(string $status): string
    {
        return match($status) {
            'menunggu_verifikasi' => 'yellow',
            'menunggu_verifikasi_dosen_kjfd' => 'blue',
            'disetujui' => 'green',
            'ditolak' => 'red',
            'revisi' => 'orange',
            default => 'gray',
        };
    }

    /**
     * Get human readable status label
     */
    public function getStatusLabel(string $status): string
    {
        return match($status) {
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'menunggu_verifikasi_dosen_kjfd' => 'Menunggu Verifikasi Dosen KJFD',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'revisi' => 'Perlu Revisi',
            default => 'Unknown',
        };
    }
}
