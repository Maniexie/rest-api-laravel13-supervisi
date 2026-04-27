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
        Schema::create('jawaban_supervisi', function (Blueprint $table) {
             $table->id('id_jawaban_supervisi');
            //  $table->integer("id_jadwal_supervisi");
             $table->integer("id_item_penilaian");
             $table->integer("id_kepala_sekolah");
             $table->integer("id_guru");
             $table->string("jawaban");
             $table->date('tanggal_pengisian');
            $table->timestamps();

            // RELASI
            $table->foreignId('id_jadwal_supervisi')
                ->references('id_jadwal_supervisi')
                ->on('jadwal_supervisi')
                ->onDelete('cascade');





        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_supervisi');
    }
};
