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
        Schema::create('jawaban_validator', function (Blueprint $table) {
            $table->id("id_jawaban_validator")->primary();
            $table->integer("id_item_penilaian");
            $table->integer("id_validator");
            $table->string("jawaban");
            $table->integer("versi");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_validator');
    }
};
