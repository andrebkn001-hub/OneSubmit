<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proposal>
 */
class ProposalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'nama_lengkap' => $this->faker->name(),
            'nim' => $this->faker->numerify('##########'),
            'judul' => $this->faker->sentence(6),
            'bidang_minat' => $this->faker->randomElement(['Information Management', 'Business Intelligence', 'Data Engineering', 'Information Retrieval']),
            'file_path' => 'proposals/' . $this->faker->uuid() . '.pdf',
            'status' => $this->faker->randomElement(['menunggu verifikasi', 'menunggu verifikasi dosen kjfd', 'disetujui', 'ditolak', 'revisi']),
            'dosen_kjfd_id' => null,
            'revision_message' => null,
            'rejection_message' => null,
        ];
    }
}
