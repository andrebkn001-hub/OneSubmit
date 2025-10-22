<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\AdminProposalController;
use App\Models\Proposal;
use App\Models\User;
use App\Services\ProposalService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class AdminProposalControllerTest extends TestCase
{
    use RefreshDatabase;

    private AdminProposalController $controller;
    private ProposalService $proposalService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->proposalService = new ProposalService();
        $this->controller = new AdminProposalController($this->proposalService);
    }

    public function test_index_returns_view_with_proposals()
    {
        $proposals = Proposal::factory()->count(3)->create();

        $request = new Request();
        $response = $this->controller->index($request);

        $this->assertEquals('admin.proposals.index', $response->getName());
        $this->assertEquals($proposals->pluck('id')->sort(), $response->getData()['proposals']->pluck('id')->sort());
    }

    public function test_index_filters_by_nim()
    {
        $proposal1 = Proposal::factory()->create(['nim' => '123456789']);
        $proposal2 = Proposal::factory()->create(['nim' => '987654321']);

        $request = new Request(['nim' => '123']);
        $response = $this->controller->index($request);

        $this->assertCount(1, $response->getData()['proposals']);
        $this->assertEquals($proposal1->id, $response->getData()['proposals']->first()->id);
    }

    public function test_approve_assigns_dosen_kjfd_and_updates_status()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $dosenKjfd = User::factory()->create([
            'role' => 'dosen_kjfd',
            'bidang' => 'Computer Science'
        ]);

        $proposal = Proposal::factory()->create([
            'bidang_minat' => 'Computer Science',
            'status' => 'menunggu verifikasi'
        ]);

        $response = $this->controller->approve($proposal->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('Proposal berhasil diteruskan ke Dosen KJFD', $response->getSession()->get('success'));

        $proposal->refresh();
        $this->assertEquals('menunggu verifikasi dosen kjfd', $proposal->status);
        $this->assertEquals($dosenKjfd->id, $proposal->dosen_kjfd_id);
    }

    public function test_approve_returns_error_when_no_dosen_kjfd_available()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $proposal = Proposal::factory()->create([
            'bidang_minat' => 'Non-existent Field',
            'status' => 'menunggu verifikasi'
        ]);

        $response = $this->controller->approve($proposal->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('Tidak ada dosen KJFD yang tersedia', $response->getSession()->get('error') ?? '');
    }

    public function test_reject_updates_proposal_with_rejection_message()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $proposal = Proposal::factory()->create(['status' => 'menunggu verifikasi']);

        $request = new Request([
            'rejection_message' => 'Proposal tidak memenuhi syarat minimum.'
        ]);

        $response = $this->controller->reject($request, $proposal->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('Proposal ditolak dengan alasan', $response->getSession()->get('error') ?? '');

        $proposal->refresh();
        $this->assertEquals('ditolak', $proposal->status);
        $this->assertEquals('Proposal tidak memenuhi syarat minimum.', $proposal->rejection_message);
    }

    public function test_reject_validation_fails_with_short_message()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $proposal = Proposal::factory()->create(['status' => 'menunggu verifikasi']);

        $request = new Request([
            'rejection_message' => 'Too short'
        ]);

        $response = $this->controller->reject($request, $proposal->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('Terjadi kesalahan saat menolak proposal', $response->getSession()->get('error'));
    }
}
