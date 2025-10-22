<?php

namespace Tests\Unit\Models;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProposalTest extends TestCase
{
    use RefreshDatabase;

    public function test_proposal_belongs_to_user()
    {
        $user = User::factory()->create();
        $proposal = Proposal::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $proposal->user);
        $this->assertEquals($user->id, $proposal->user->id);
    }

    public function test_proposal_belongs_to_dosen_kjfd()
    {
        $dosenKjfd = User::factory()->create(['role' => 'dosen_kjfd']);
        $proposal = Proposal::factory()->create(['dosen_kjfd_id' => $dosenKjfd->id]);

        $this->assertInstanceOf(User::class, $proposal->dosenKjfd);
        $this->assertEquals($dosenKjfd->id, $proposal->dosenKjfd->id);
    }

    public function test_is_pending_verification()
    {
        $proposal = Proposal::factory()->create(['status' => 'menunggu verifikasi']);
        $this->assertTrue($proposal->isPendingVerification());

        $proposal->update(['status' => 'disetujui']);
        $this->assertFalse($proposal->isPendingVerification());
    }

    public function test_is_approved()
    {
        $proposal = Proposal::factory()->create(['status' => 'disetujui']);
        $this->assertTrue($proposal->isApproved());

        $proposal->update(['status' => 'ditolak']);
        $this->assertFalse($proposal->isApproved());
    }

    public function test_is_rejected()
    {
        $proposal = Proposal::factory()->create(['status' => 'ditolak']);
        $this->assertTrue($proposal->isRejected());

        $proposal->update(['status' => 'disetujui']);
        $this->assertFalse($proposal->isRejected());
    }

    public function test_needs_revision()
    {
        $proposal = Proposal::factory()->create(['status' => 'revisi']);
        $this->assertTrue($proposal->needsRevision());

        $proposal->update(['status' => 'disetujui']);
        $this->assertFalse($proposal->needsRevision());
    }

    public function test_is_waiting_for_kjfd_verification()
    {
        $proposal = Proposal::factory()->create(['status' => 'menunggu verifikasi dosen kjfd']);
        $this->assertTrue($proposal->isWaitingForKjfdVerification());

        $proposal->update(['status' => 'disetujui']);
        $this->assertFalse($proposal->isWaitingForKjfdVerification());
    }

    public function test_get_status_badge_color()
    {
        $statuses = [
            'menunggu verifikasi' => 'yellow',
            'menunggu verifikasi dosen kjfd' => 'blue',
            'disetujui' => 'green',
            'ditolak' => 'red',
            'revisi' => 'orange',
            'unknown' => 'gray',
        ];

        foreach ($statuses as $status => $expectedColor) {
            $proposal = Proposal::factory()->create(['status' => $status]);
            $this->assertEquals($expectedColor, $proposal->getStatusBadgeColor());
        }
    }

    public function test_get_status_label()
    {
        $statuses = [
            'menunggu verifikasi' => 'Menunggu Verifikasi',
            'menunggu verifikasi dosen kjfd' => 'Menunggu Verifikasi Dosen KJFD',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'revisi' => 'Perlu Revisi',
            'unknown' => 'Unknown',
        ];

        foreach ($statuses as $status => $expectedLabel) {
            $proposal = Proposal::factory()->create(['status' => $status]);
            $this->assertEquals($expectedLabel, $proposal->getStatusLabel());
        }
    }

    public function test_fillable_attributes()
    {
        $fillable = [
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

        $this->assertEquals($fillable, (new Proposal)->getFillable());
    }

    public function test_casts()
    {
        $proposal = new Proposal();
        $casts = $proposal->getCasts();

        $this->assertArrayHasKey('created_at', $casts);
        $this->assertArrayHasKey('updated_at', $casts);
        $this->assertEquals('datetime', $casts['created_at']);
        $this->assertEquals('datetime', $casts['updated_at']);
    }
}
