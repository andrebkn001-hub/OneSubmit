<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kjfd_quotas', function (Blueprint $table) {
            $table->id();
            $table->string('bidang')->unique();
            $table->integer('quota')->default(50);
            $table->timestamps();
        });

        // Insert default quotas for known bidang
        DB::table('kjfd_quotas')->insert([
            ['bidang' => 'Business Intelligence', 'quota' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['bidang' => 'Data Engineering', 'quota' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['bidang' => 'Information Management', 'quota' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['bidang' => 'Information Retrieval', 'quota' => 50, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kjfd_quotas');
    }
};
