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
        Schema::create('jadwal_supervisi', function (Blueprint $table) {
        $table->id("id_jadwal_supervisi");
        $table->integer("id_kepala_sekolah");
        $table->string("nama_periode");
        $table->date("tanggal_mulai");
        $table->date("tanggal_selesai");
        $table->string("deskripsi");
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_supervisi');
    }
};
