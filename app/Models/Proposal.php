<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nim',
        'judul',
        'bidang_minat',
        'file_path',
        'status',
        'dosen_kjfd_id',
        'revision_message',
        'rejection_message',
        'acc_letter_path',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the proposal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the dosen KJFD assigned to this proposal.
     */
    public function dosenKjfd(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_kjfd_id');
    }

    /**
     * Check if proposal is pending verification.
     */
    public function isPendingVerification(): bool
    {
        return $this->status === 'menunggu_verifikasi';
    }

    /**
     * Check if proposal is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'disetujui';
    }

    /**
     * Check if proposal is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'ditolak';
    }

    /**
     * Check if proposal needs revision.
     */
    public function needsRevision(): bool
    {
        return $this->status === 'revisi';
    }

    /**
     * Check if proposal is waiting for KJFD verification.
     */
    public function isWaitingForKjfdVerification(): bool
    {
        return $this->status === 'menunggu_verifikasi_dosen_kjfd';
    }

    /**
     * Get status badge color for UI.
     */
    public function getStatusBadgeColor(): string
    {
        return match($this->status) {
            'menunggu_verifikasi' => 'yellow',
            'menunggu_verifikasi_dosen_kjfd' => 'blue',
            'disetujui' => 'green',
            'ditolak' => 'red',
            'revisi' => 'orange',
            default => 'gray',
        };
    }

    /**
     * Get human readable status.
     */
    public function getStatusLabel(): string
    {
        return match($this->status) {
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'menunggu_verifikasi_dosen_kjfd' => 'Menunggu Verifikasi Dosen KJFD',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'revisi' => 'Perlu Revisi',
            default => 'Unknown',
        };
    }

    /**
     * Scope: Proposals that need Ketua Jurusan monitoring/action.
     * Status: menunggu_verifikasi, menunggu_verifikasi_dosen_kjfd, or revisi
     * Ketua Jurusan berperan sebagai pengawas yang bisa mengirim notifikasi peringatan
     */
    public function scopeNeedsKetuaAction($query)
    {
        return $query->whereIn('status', ['menunggu_verifikasi', 'menunggu_verifikasi_dosen_kjfd', 'revisi']);
    }

    /**
     * Scope: Proposals waiting for verification.
     */
    public function scopeWaitingVerification($query)
    {
        return $query->where('status', 'menunggu_verifikasi');
    }

    /**
     * Scope: Proposals that are aging (older than N days).
     *
     * @param int $days
     */
    public function scopeAging($query, int $days = 3)
    {
        return $query->where('created_at', '<=', now()->subDays($days));
    }

    /**
     * Get days since submission.
     *
     * @return int
     */
    public function getDaysSinceSubmission(): int
    {
        return $this->created_at->diffInDays(now());
    }

    /**
     * Check if proposal is aging (more than 3 days).
     *
     * @return bool
     */
    public function isAging(): bool
    {
        return $this->getDaysSinceSubmission() > 3;
    }
}
