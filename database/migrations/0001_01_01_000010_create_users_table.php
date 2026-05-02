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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('kode_jabatan')->nullable();
            $table->string('kode_golongan')->nullable();
            $table->string('kode_status_pegawai')->nullable();
            $table->string('nip')->nullable();
            $table->string('email')->unique();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password', 64);
            $table->string('nomor_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
            $table->boolean('isValidator')->default(false)->nullable();
            $table->enum('role', ['kepala_sekolah', 'guru','operator'])->nullable();
            $table->rememberToken();
            $table->timestamps();

            // RELASI
            $table->foreign('kode_jabatan')
                ->references('kode_jabatan')
                ->on('k_jabatan')
                ->nullOnDelete();

            $table->foreign('kode_golongan')
                ->references('kode_golongan')
                ->on('k_golongan')
                ->onDelete('cascade');

            $table->foreign('kode_status_pegawai')
                ->references('kode_status_pegawai')
                ->on('k_status_pegawai')
                ->onDelete('cascade');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
