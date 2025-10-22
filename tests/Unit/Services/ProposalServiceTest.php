<?php

namespace Tests\Unit\Services;

use App\Models\Proposal;
use App\Models\User;
use App\Services\ProposalService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProposalServiceTest extends TestCase
{
    use RefreshDatabase;

    private ProposalService $proposalService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->proposalService = new ProposalService();
        Storage::fake('public');
    }

    public function test_validate_proposal_data_success()
    {
        $request = new Request([
            'nim' => '123456789',
            'judul' => 'Test Proposal',
            'bidang_minat' => 'Computer Science',
            'file_proposal' => UploadedFile::fake()->create('test.pdf', 1000),
        ]);

        $validated = $this->proposalService->validateProposalData($request);

        $this->assertEquals('123456789', $validated['nim']);
        $this->assertEquals('Test Proposal', $validated['judul']);
        $this->assertEquals('Computer Science', $validated['bidang_minat']);
    }

    public function test_validate_proposal_data_fails_with_invalid_data()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $request = new Request([
            'nim' => '', // empty
            'judul' => '', // empty
            'bidang_minat' => 'Computer Science',
            'file_proposal' => UploadedFile::fake()->create('test.pdf', 1000),
        ]);

        $this->proposalService->validateProposalData($request);
    }

    public function test_upload_proposal_file()
    {
        $file = UploadedFile::fake()->create('test.pdf', 1000);
        $request = new Request();
        $request->files->set('file_proposal', $file);

        $filePath = $this->proposalService->uploadProposalFile($request);

        Storage::disk('public')->assertExists($filePath);
        $this->assertStringStartsWith('proposals/', $filePath);
    }

    public function test_create_proposal_success()
    {
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'nama_lengkap' => 'John Doe',
            'nim' => '123456789',
            'judul' => 'Test Proposal',
            'bidang_minat' => 'Computer Science',
            'file_path' => 'proposals/test.pdf',
            'status' => 'menunggu verifikasi',
        ];

        $proposal = $this->proposalService->createProposal($data);

        $this->assertInstanceOf(Proposal::class, $proposal);
        $this->assertEquals('Test Proposal', $proposal->judul);
        $this->assertEquals('menunggu verifikasi', $proposal->status);
    }

    public function test_update_proposal_success()
    {
        $proposal = Proposal::factory()->create(['judul' => 'Old Title']);

        $updatedProposal = $this->proposalService->updateProposal($proposal, [
            'judul' => 'New Title',
            'status' => 'disetujui',
        ]);

        $this->assertEquals('New Title', $updatedProposal->judul);
        $this->assertEquals('disetujui', $updatedProposal->status);
    }

    public function test_find_available_dosen_kjfd()
    {
        $dosenKjfd = User::factory()->create([
            'role' => 'dosen_kjfd',
            'bidang' => 'Computer Science',
        ]);

        $foundDosen = $this->proposalService->findAvailableDosenKjfd('Computer Science');

        $this->assertNotNull($foundDosen);
        $this->assertEquals($dosenKjfd->id, $foundDosen->id);
    }

    public function test_find_available_dosen_kjfd_returns_null_when_no_match()
    {
        $dosenKjfd = User::factory()->create([
            'role' => 'dosen_kjfd',
            'bidang' => 'Mathematics',
        ]);

        $foundDosen = $this->proposalService->findAvailableDosenKjfd('Computer Science');

        $this->assertNull($foundDosen);
    }

    public function test_user_owns_proposal()
    {
        $user = User::factory()->create();
        $proposal = Proposal::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($this->proposalService->userOwnsProposal($proposal, $user->id));
        $this->assertFalse($this->proposalService->userOwnsProposal($proposal, $user->id + 1));
    }

    public function test_dosen_kjfd_assigned_to_proposal()
    {
        $dosenKjfd = User::factory()->create();
        $proposal = Proposal::factory()->create(['dosen_kjfd_id' => $dosenKjfd->id]);

        $this->assertTrue($this->proposalService->dosenKjfdAssignedToProposal($proposal, $dosenKjfd->id));
        $this->assertFalse($this->proposalService->dosenKjfdAssignedToProposal($proposal, $dosenKjfd->id + 1));
    }

    public function test_is_proposal_in_revision()
    {
        $proposal = Proposal::factory()->create(['status' => 'revisi']);

        $this->assertTrue($this->proposalService->isProposalInRevision($proposal));

        $proposal->update(['status' => 'menunggu verifikasi']);
        $this->assertFalse($this->proposalService->isProposalInRevision($proposal));
    }
}
