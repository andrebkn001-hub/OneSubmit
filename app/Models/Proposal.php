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
        return $this->status === 'menunggu verifikasi';
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
        return $this->status === 'menunggu verifikasi dosen kjfd';
    }

    /**
     * Get status badge color for UI.
     */
    public function getStatusBadgeColor(): string
    {
        return match($this->status) {
            'menunggu verifikasi' => 'yellow',
            'menunggu verifikasi dosen kjfd' => 'blue',
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
            'menunggu verifikasi' => 'Menunggu Verifikasi',
            'menunggu verifikasi dosen kjfd' => 'Menunggu Verifikasi Dosen KJFD',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'revisi' => 'Perlu Revisi',
            default => 'Unknown',
        };
    }
}
