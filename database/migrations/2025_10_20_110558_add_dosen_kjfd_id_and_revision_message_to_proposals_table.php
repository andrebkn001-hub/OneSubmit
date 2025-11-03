<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->foreignId('dosen_kjfd_id')->nullable()->constrained('users');
            $table->text('revision_message')->nullable();
            $table->text('rejection_message')->nullable();
            $table->string('status')->default('menunggu_verifikasi')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropForeign(['dosen_kjfd_id']);
            $table->dropColumn('dosen_kjfd_id');
            $table->dropColumn('revision_message');
            $table->dropColumn('rejection_message');
            $table->string('status')->default('menunggu_verifikasi')->change();
        });
    }
};
