<?php

namespace App\Notifications;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProposalActionAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Proposal $proposal,
        public string $targetType, // 'admin' | 'dosen_kjfd'
        public ?User $sender = null
    ) {}

    public function via($notifiable): array
    {
        // Database first; email optional if user has email verified
        $channels = ['database'];
        return $channels;
    }

    public function toDatabase($notifiable): array
    {
        return [
            'proposal_id' => $this->proposal->id,
            'nim' => $this->proposal->nim,
            'nama' => $this->proposal->nama_lengkap,
            'judul' => $this->proposal->judul,
            'status' => $this->proposal->status,
            'bidang_minat' => $this->proposal->bidang_minat,
            'target' => $this->targetType,
            'sender_id' => $this->sender?->id,
            'message' => $this->buildMessage(),
            'url' => $this->getUrlForUser($notifiable),
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Alert Proposal: ' . $this->proposal->judul)
            ->greeting('Halo,')
            ->line($this->buildMessage())
            ->action('Buka Proposal', $this->getUrlForUser($notifiable))
            ->line('Terima kasih.');
    }

    /**
     * Get appropriate URL based on user role
     */
    private function getUrlForUser($notifiable): string
    {
        $role = $notifiable->role ?? 'mahasiswa';
        
        // Generate URL sesuai role yang menerima notifikasi
        return match($role) {
            'admin' => route('admin.proposals.index'),
            'dosen_kjfd' => route('kjfd.proposals.index'),
            'ketua_jurusan' => route('jurusan.proposals.index', $this->mapBidangToCode($this->proposal->bidang_minat)),
            default => route('mahasiswa.status'),
        };
    }

    private function buildMessage(): string
    {
        $statusLabel = $this->humanStatus($this->proposal->status);
        return "Proposal a/n {$this->proposal->nama_lengkap} ({$this->proposal->nim}) status {$statusLabel} pada bidang {$this->proposal->bidang_minat} membutuhkan perhatian.";
    }

    private function humanStatus(string $status): string
    {
        return match($status) {
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'menunggu_verifikasi_dosen_kjfd' => 'Menunggu Verifikasi Dosen KJFD',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'revisi' => 'Perlu Revisi',
            default => ucfirst(str_replace('_',' ', $status)),
        };
    }

    private function mapBidangToCode(string $bidang): string
    {
        return match($bidang) {
            'Business Intelligence' => 'bi',
            'Data Engineering' => 'de',
            'Information Management' => 'im',
            'Information Retrieval' => 'ir',
            default => strtolower(str_replace(' ', '-', $bidang)),
        };
    }
}
