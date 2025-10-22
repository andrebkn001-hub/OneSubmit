<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\MahasiswaController;
use App\Models\Proposal;
use App\Models\User;
use App\Services\ProposalService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class MahasiswaControllerTest extends TestCase
{
    use RefreshDatabase;

    private MahasiswaController $controller;
    private ProposalService $proposalService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->startSession();
        $this->proposalService = $this->mock(ProposalService::class);
        $this->controller = new MahasiswaController($this->proposalService);
    }

    public function test_dashboard_returns_view()
    {
        $response = $this->controller->dashboard();
        $this->assertEquals('mahasiswa.dashboard', $response->getName());
    }

    public function test_store_proposal_creates_proposal_successfully()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('proposal.pdf', 1000);
        $request = new Request([
            'nama_lengkap' => 'John Doe',
            'nim' => '123456789',
            'judul' => 'Test Proposal',
            'bidang_minat' => 'Computer Science',
            'file_proposal' => $file,
        ]);

        $this->proposalService->shouldReceive('uploadProposalFile')->once()->andReturn('path/to/file.pdf');
        $this->proposalService->shouldReceive('createProposal')->once();

        $response = $this->controller->storeProposal($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('mahasiswa.status'), $response->getTargetUrl());
    }

    public function test_store_proposal_handles_validation_error()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $this->actingAs($user);

        $request = new Request([
            'nama_lengkap' => '', // invalid
            'nim' => '123456789',
            'judul' => 'Test Proposal',
            'bidang_minat' => 'Computer Science',
            'file_proposal' => UploadedFile::fake()->create('proposal.pdf', 1000),
        ]);

        $response = $this->controller->storeProposal($request);

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
}
