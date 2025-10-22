<?php

namespace Tests\Unit\Models;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_many_proposals()
    {
        $user = User::factory()->create();
        $proposal1 = Proposal::factory()->create(['user_id' => $user->id]);
        $proposal2 = Proposal::factory()->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->proposals);
        $this->assertEquals($proposal1->id, $user->proposals->first()->id);
        $this->assertEquals($proposal2->id, $user->proposals->last()->id);
    }

    public function test_user_has_many_assigned_proposals()
    {
        $dosenKjfd = User::factory()->create(['role' => 'dosen_kjfd']);
        $proposal1 = Proposal::factory()->create(['dosen_kjfd_id' => $dosenKjfd->id]);
        $proposal2 = Proposal::factory()->create(['dosen_kjfd_id' => $dosenKjfd->id]);

        $this->assertCount(2, $dosenKjfd->assignedProposals);
        $this->assertEquals($proposal1->id, $dosenKjfd->assignedProposals->first()->id);
        $this->assertEquals($proposal2->id, $dosenKjfd->assignedProposals->last()->id);
    }

    public function test_is_admin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'mahasiswa']);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($user->isAdmin());
    }

    public function test_is_dosen_kjfd()
    {
        $dosenKjfd = User::factory()->create(['role' => 'dosen_kjfd']);
        $user = User::factory()->create(['role' => 'mahasiswa']);

        $this->assertTrue($dosenKjfd->isDosenKjfd());
        $this->assertFalse($user->isDosenKjfd());
    }

    public function test_is_mahasiswa()
    {
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $user = User::factory()->create(['role' => 'admin']);

        $this->assertTrue($mahasiswa->isMahasiswa());
        $this->assertFalse($user->isMahasiswa());
    }

    public function test_is_jurusan()
    {
        $jurusan = User::factory()->create(['role' => 'jurusan']);
        $user = User::factory()->create(['role' => 'admin']);

        $this->assertTrue($jurusan->isJurusan());
        $this->assertFalse($user->isJurusan());
    }

    public function test_get_role_label()
    {
        $roles = [
            'admin' => 'Administrator',
            'dosen_kjfd' => 'Dosen KJFD',
            'mahasiswa' => 'Mahasiswa',
            'jurusan' => 'Jurusan',
            'unknown' => 'Unknown',
        ];

        foreach ($roles as $role => $expectedLabel) {
            $user = User::factory()->create(['role' => $role]);
            $this->assertEquals($expectedLabel, $user->getRoleLabel());
        }
    }

    public function test_get_bidang_label()
    {
        $userWithBidang = User::factory()->create(['bidang' => 'Computer Science']);
        $userWithoutBidang = User::factory()->create(['bidang' => null]);

        $this->assertEquals('Computer Science', $userWithBidang->getBidangLabel());
        $this->assertNull($userWithoutBidang->getBidangLabel());
    }

    public function test_fillable_attributes()
    {
        $fillable = [
            'name',
            'email',
            'password',
            'role',
            'bidang',
        ];

        $this->assertEquals($fillable, (new User)->getFillable());
    }

    public function test_hidden_attributes()
    {
        $hidden = [
            'password',
            'remember_token',
        ];

        $this->assertEquals($hidden, (new User)->getHidden());
    }

    public function test_casts()
    {
        $user = new User();
        $casts = $user->getCasts();

        $this->assertArrayHasKey('email_verified_at', $casts);
        $this->assertArrayHasKey('password', $casts);
        $this->assertEquals('datetime', $casts['email_verified_at']);
        $this->assertEquals('hashed', $casts['password']);
    }
}
