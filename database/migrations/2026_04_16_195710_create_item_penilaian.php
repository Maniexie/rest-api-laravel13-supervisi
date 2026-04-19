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
        Schema::create('item_penilaian', function (Blueprint $table) {
            $table->id("id_item_penilaian");
            $table->string("kode_kategori_penilaian");
            $table->text("pernyataan");
            $table->integer("versi");
            $table->float("nilai_aiken");
            $table->enum("status", ["valid", "tidak_valid"])->default("tidak_valid");
            $table->foreign("kode_kategori_penilaian")->references("kode_kategori_penilaian")->on("k_penilaian")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_penilaian');
    }
};
