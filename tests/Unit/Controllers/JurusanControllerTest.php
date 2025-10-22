<?php

namespace Tests\Unit\Controllers;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JurusanControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_kjfdSelection_returns_kjfd_view()
    {
        $user = User::factory()->create(['role' => 'ketua_jurusan']);
        $this->actingAs($user);

        $response = $this->get('/jurusan/proposals/kjfd');

        $response->assertStatus(200);
        $response->assertViewIs('jurusan.proposals.kjfd');
    }

    public function test_proposalsIndex_returns_proposals_with_filtering()
    {
        $user = User::factory()->create(['role' => 'ketua_jurusan']);
        $this->actingAs($user);

        Proposal::factory()->create([
            'bidang_minat' => 'Computer Science',
            'nim' => '123456789',
        ]);
        Proposal::factory()->create([
            'bidang_minat' => 'Computer Science',
            'nim' => '987654321',
        ]);
        Proposal::factory()->create([
            'bidang_minat' => 'Mathematics',
            'nim' => '123456789',
        ]);

        $response = $this->get('/jurusan/proposals/computer_science');

        $response->assertStatus(200);
        $response->assertViewIs('jurusan.proposals.index');
        $response->assertViewHas('proposals');
        $response->assertViewHas('bidang', 'computer_science');

        $proposals = $response->viewData('proposals');
        $this->assertCount(2, $proposals);
    }

    public function test_proposalsIndex_filters_by_nim()
    {
        $user = User::factory()->create(['role' => 'ketua_jurusan']);
        $this->actingAs($user);

        Proposal::factory()->create([
            'bidang_minat' => 'Computer Science',
            'nim' => '123456789',
        ]);
        Proposal::factory()->create([
            'bidang_minat' => 'Computer Science',
            'nim' => '987654321',
        ]);

        $response = $this->get('/jurusan/proposals/computer_science?nim=123456789');

        $response->assertStatus(200);
        $response->assertViewIs('jurusan.proposals.index');

        $proposals = $response->viewData('proposals');
        $this->assertCount(1, $proposals);
        $this->assertEquals('123456789', $proposals->first()->nim);
    }
}
