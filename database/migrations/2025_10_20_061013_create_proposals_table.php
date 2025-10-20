<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('proposals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // mahasiswa pengaju
        $table->string('nama_lengkap');
        $table->string('nim');
        $table->string('judul_proposal');
        $table->string('bidang_minat');
        $table->string('file_proposal')->nullable();
        $table->string('status')->default('Menunggu Validasi'); // status awal
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
