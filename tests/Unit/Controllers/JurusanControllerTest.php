<?php

namespace Tests\Unit\Controllers;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JurusanControllerTest extends TestCase
{
    use RefreshDatabase;

    // Persiapan data dummy User Jurusan
    protected $jurusan;

    protected function setUp(): void
    {
        parent::setUp();
        // Buat user dengan role 'ketua_jurusan' untuk autentikasi
        $this->jurusan = User::factory()->create(['role' => 'ketua_jurusan']);
    }

    /**
     * Test: kjfdSelection returns kjfd view.
     */
    public function test_kjfdSelection_returns_kjfd_view()
    {
        $response = $this->actingAs($this->jurusan)->get('/jurusan/proposals/kjfd');

        $response->assertStatus(200);
        $response->assertViewIs('jurusan.proposals.kjfd');
    }

    /**
     * Test: proposals index returns proposals with filtering (menggunakan kode bidang 'im').
     */
    public function test_proposalsIndex_returns_proposals_with_filtering()
    {
        $bidang_kode = 'im';
        $bidang_nama = 'Information Management'; // Sesuai dengan $bidangMap['im'] di Controller

        // 2 Proposal yang seharusnya ditampilkan
        Proposal::factory()->count(2)->create([
            'bidang_minat' => $bidang_nama,
        ]);
        // 1 Proposal yang seharusnya tidak ditampilkan (bidang berbeda)
        Proposal::factory()->create([
            'bidang_minat' => 'Data Engineering',
        ]);

        $response = $this->actingAs($this->jurusan)->get("/jurusan/proposals/{$bidang_kode}");

        $response->assertStatus(200);
        $response->assertViewIs('jurusan.proposals.index');
        $response->assertViewHas('proposals');
        $response->assertViewHas('bidang', $bidang_kode);

        $proposals = $response->viewData('proposals');
        // Memastikan hanya 2 proposal yang difilter yang muncul
        $this->assertCount(2, $proposals); 
    }

    /**
     * Test: proposals index filters by nim.
     */
    public function test_proposalsIndex_filters_by_nim()
    {
        $bidang_kode = 'im';
        $bidang_nama = 'Information Management';

        // Proposal yang dicari
        Proposal::factory()->create([
            'bidang_minat' => $bidang_nama,
            'nim' => '123456789',
        ]);
        // Proposal dengan NIM berbeda di bidang yang sama
        Proposal::factory()->create([
            'bidang_minat' => $bidang_nama,
            'nim' => '987654321',
        ]);
        // Proposal dengan bidang berbeda
        Proposal::factory()->create([
            'bidang_minat' => 'Data Engineering',
            'nim' => '123456789',
        ]);


        $response = $this->actingAs($this->jurusan)
                         ->get("/jurusan/proposals/{$bidang_kode}?nim=123456789");

        $response->assertStatus(200);
        $response->assertViewIs('jurusan.proposals.index');

        $proposals = $response->viewData('proposals');
        // Memastikan hanya 1 proposal dengan NIM tersebut yang muncul
        $this->assertCount(1, $proposals);
        $this->assertEquals('123456789', $proposals->first()->nim);
        $this->assertEquals($bidang_nama, $proposals->first()->bidang_minat);
    }
}