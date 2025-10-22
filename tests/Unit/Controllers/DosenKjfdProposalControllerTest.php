<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\DosenKjfdProposalController;
use App\Models\Proposal;
use App\Models\User;
use App\Services\ProposalService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class DosenKjfdProposalControllerTest extends TestCase
{
    use RefreshDatabase;

    private DosenKjfdProposalController $controller;
    private ProposalService $proposalService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->proposalService = new ProposalService();
        $this->controller = new DosenKjfdProposalController($this->proposalService);
    }

    public function test_index_returns_view_with_assigned_proposals()
    {
        $dosenKjfd = User::factory()->create(['role' => 'dosen_kjfd']);
        $this->actingAs($dosenKjfd);

        $proposals = Proposal::factory()->count(3)->create([
            'dosen_kjfd_id' => $dosenKjfd->id,
            'status' => 'menunggu verifikasi dosen kjfd'
        ]);

        $request = new Request();
        $response = $this->controller->index($request);

        $this->assertEquals('dosen_kjfd.proposals.index', $response->getName());
        $this->assertCount(3, $response->getData()['proposals']);
    }

    public function test_index_filters_by_nim()
    {
        $dosenKjfd = User::factory()->create(['role' => 'dosen_kjfd']);
        $this->actingAs($dosenKjfd);

        $proposal1 = Proposal::factory()->create([
            'dosen_kjfd_id' => $dosenKjfd->id,
            'status' => 'menunggu verifikasi dosen kjfd',
            'nim' => '123456789'
        ]);
        $proposal2 = Proposal::factory()->create([
            'dosen_kjfd_id' => $dosenKjfd->id,
            'status' => 'menunggu verifikasi dosen kjfd',
            'nim' => '987654321'
        ]);

        $request = new Request(['nim' => '123']);
        $response = $this->controller->index($request);

        $this->assertCount(1, $response->getData()['proposals']);
        $this->assertEquals($proposal1->id, $response->getData()['proposals']->first()->id);
    }

    public function test_approve_updates_proposal_status()
    {
        $dosenKjfd = User::factory()->create(['role' => 'dosen_kjfd']);
        $this->actingAs($dosenKjfd);

        $proposal = Proposal::factory()->create([
            'dosen_kjfd_id' => $dosenKjfd->id,
            'status' => 'menunggu verifikasi dosen kjfd'
        ]);

        $response = $this->controller->approve($proposal->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('Proposal berhasil disetujui', $response->getSession()->get('success'));

        $proposal->refresh();
        $this->assertEquals('disetujui', $proposal->status);
    }

    public function test_approve_denies_access_for_unassigned_proposal()
    {
        $dosenKjfd1 = User::factory()->create(['role' => 'dosen_kjfd']);
        $dosenKjfd2 = User::factory()->create(['role' => 'dosen_kjfd']);
        $this->actingAs($dosenKjfd2);

        $proposal = Proposal::factory()->create([
            'dosen_kjfd_id' => $dosenKjfd1->id, // assigned to different dosen
            'status' => 'menunggu verifikasi dosen kjfd'
        ]);

        $response = $this->controller->approve($proposal->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('Anda tidak memiliki izin', $response->getSession()->get('error'));
    }

    public function test_revise_updates_proposal_with_revision_message()
    {
        $dosenKjfd = User::factory()->create(['role' => 'dosen_kjfd']);
        $this->actingAs($dosenKjfd);

        $proposal = Proposal::factory()->create([
            'dosen_kjfd_id' => $dosenKjfd->id,
            'status' => 'menunggu verifikasi dosen kjfd'
        ]);

        $request = new Request([
            'revision_message' => 'Proposal perlu diperbaiki bagian metodologi.'
        ]);

        $response = $this->controller->revise($request, $proposal->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('Proposal berhasil direvisi', $response->getSession()->get('success'));

        $proposal->refresh();
        $this->assertEquals('revisi', $proposal->status);
        $this->assertEquals('Proposal perlu diperbaiki bagian metodologi.', $proposal->revision_message);
    }

    public function test_revise_denies_access_for_unassigned_proposal()
    {
        $dosenKjfd1 = User::factory()->create(['role' => 'dosen_kjfd']);
        $dosenKjfd2 = User::factory()->create(['role' => 'dosen_kjfd']);
        $this->actingAs($dosenKjfd2);

        $proposal = Proposal::factory()->create([
            'dosen_kjfd_id' => $dosenKjfd1->id,
            'status' => 'menunggu verifikasi dosen kjfd'
        ]);

        $request = new Request([
            'revision_message' => 'Proposal perlu diperbaiki.'
        ]);

        $response = $this->controller->revise($request, $proposal->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('Anda tidak memiliki izin', $response->getSession()->get('error'));
    }

    public function test_reject_updates_proposal_with_rejection_message()
    {
        $dosenKjfd = User::factory()->create(['role' => 'dosen_kjfd']);
        $this->actingAs($dosenKjfd);

        $proposal = Proposal::factory()->create([
            'dosen_kjfd_id' => $dosenKjfd->id,
            'status' => 'menunggu verifikasi dosen kjfd'
        ]);

        $request = new Request([
            'rejection_message' => 'Proposal tidak memenuhi standar akademik.'
        ]);

        $response = $this->controller->reject($request, $proposal->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('Proposal berhasil ditolak', $response->getSession()->get('error'));

        $proposal->refresh();
        $this->assertEquals('ditolak', $proposal->status);
        $this->assertEquals('Proposal tidak memenuhi standar akademik.', $proposal->rejection_message);
    }

    public function test_reject_validation_fails_with_short_message()
    {
        $dosenKjfd = User::factory()->create(['role' => 'dosen_kjfd']);
        $this->actingAs($dosenKjfd);

        $proposal = Proposal::factory()->create([
            'dosen_kjfd_id' => $dosenKjfd->id,
            'status' => 'menunggu verifikasi dosen kjfd'
        ]);

        $request = new Request([
            'rejection_message' => 'Too short'
        ]);

        $response = $this->controller->reject($request, $proposal->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('Terjadi kesalahan', $response->getSession()->get('error') ?? '');
    }
}
