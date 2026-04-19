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
        Schema::create('k_tindak_lanjut_hasil_supervisi', function (Blueprint $table) {
            $table->string('kode_tindak_lanjut')->primary();
            $table->string('nama_tindak_lanjut');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('k_tindak_lanjut_hasil_supervisi');
    }
};
