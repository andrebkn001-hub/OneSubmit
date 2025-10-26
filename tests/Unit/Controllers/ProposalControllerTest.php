<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\ProposalController;
use App\Models\Proposal;
use App\Models\User;
use App\Services\ProposalService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProposalControllerTest extends TestCase
{
    use RefreshDatabase;

    private ProposalController $controller;
    private ProposalService $proposalService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->startSession();
        $this->proposalService = $this->mock(ProposalService::class);
        $this->controller = new ProposalController($this->proposalService);
    }

    public function test_create_returns_view()
    {
        $response = $this->controller->create();
        $this->assertEquals('proposals.create', $response->getName());
    }

    public function test_store_creates_proposal_successfully()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('proposal.pdf', 1000);
        $request = new Request([
            'nim' => '123456789',
            'judul' => 'Test Proposal',
            'bidang_minat' => 'Computer Science',
            'file_proposal' => $file,
        ]);

        $this->proposalService->shouldReceive('validateProposalData')->once();
        $this->proposalService->shouldReceive('uploadProposalFile')->once()->andReturn('path/to/file.pdf');
        $this->proposalService->shouldReceive('createProposal')->once();

        $response = $this->controller->store($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('mahasiswa.dashboard'), $response->getTargetUrl());
    }

    public function test_store_handles_validation_error()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $request = new Request([
            'nim' => '', // invalid
            'judul' => 'Test Proposal',
            'bidang_minat' => 'Computer Science',
            'file_proposal' => UploadedFile::fake()->create('proposal.pdf', 1000),
        ]);

        $response = $this->controller->store($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('Terjadi kesalahan', $response->getSession()->get('error') ?? '');
    }

    public function test_status_returns_view_with_user_proposals()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $proposals = Proposal::factory()->count(3)->create(['user_id' => $user->id]);

        $request = new Request();
        $response = $this->controller->status($request);

        $this->assertEquals('mahasiswa.status', $response->getName());
        $this->assertCount(3, $response->getData()['proposals']);
    }

    public function test_status_filters_by_nim()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $proposal1 = Proposal::factory()->create(['user_id' => $user->id, 'nim' => '123456789']);
        $proposal2 = Proposal::factory()->create(['user_id' => $user->id, 'nim' => '987654321']);

        $request = new Request(['nim' => '123']);
        $response = $this->controller->status($request);

        $this->assertCount(1, $response->getData()['proposals']);
        $this->assertEquals($proposal1->id, $response->getData()['proposals']->first()->id);
    }

    public function test_update_successfully_updates_proposal_in_revision()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $this->actingAs($user);

        $proposal = Proposal::factory()->create([
            'user_id' => $user->id,
            'status' => 'revisi',
            'judul' => 'Old Title'
        ]);

        $file = UploadedFile::fake()->create('updated_proposal.pdf', 1000);
        $request = new Request([
            'judul' => 'Updated Title',
            'bidang_minat' => 'Updated Field',
            'file_proposal' => $file,
        ]);

        $this->proposalService->shouldReceive('validateProposalData')->once();
        $this->proposalService->shouldReceive('uploadProposalFile')->once()->andReturn('path/to/file.pdf');
        $this->proposalService->shouldReceive('userOwnsProposal')->once()->andReturn(true);
        $this->proposalService->shouldReceive('isProposalInRevision')->once()->andReturn(true);
        $this->proposalService->shouldReceive('updateProposal')->once();

        $response = $this->controller->update($request, $proposal->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('mahasiswa.status'), $response->getTargetUrl());
    }

    public function test_update_denies_access_for_non_owner()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $this->actingAs($user2);

        $proposal = Proposal::factory()->create([
            'user_id' => $user1->id,
            'status' => 'revisi'
        ]);

        $file = UploadedFile::fake()->create('updated_proposal.pdf', 1000);
        $request = new Request([
            'judul' => 'Updated Title',
            'bidang_minat' => 'Updated Field',
            'file_proposal' => $file,
        ]);

        $response = $this->controller->update($request, $proposal->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('Terjadi kesalahan saat mengupdate proposal. Silakan coba lagi.', $response->getSession()->get('error') ?? '');
    }

    public function test_update_denies_access_for_non_revision_status()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $proposal = Proposal::factory()->create([
            'user_id' => $user->id,
            'status' => 'menunggu verifikasi' // not in revision
        ]);

        $file = UploadedFile::fake()->create('updated_proposal.pdf', 1000);
        $request = new Request([
            'judul' => 'Updated Title',
            'bidang_minat' => 'Updated Field',
            'file_proposal' => $file,
        ]);

        $response = $this->controller->update($request, $proposal->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('Terjadi kesalahan saat mengupdate proposal. Silakan coba lagi.', $response->getSession()->get('error') ?? '');
    }
}
