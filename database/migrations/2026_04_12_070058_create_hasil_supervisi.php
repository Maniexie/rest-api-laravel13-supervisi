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
        Schema::create('hasil_supervisi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tindak_lanjut');
            $table->timestamps();

            // RELASI
            $table->foreign('kode_tindak_lanjut')
                ->references('kode_tindak_lanjut')
                ->on('k_tindak_lanjut_hasil_supervisi')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_supervisi');
    }
};
