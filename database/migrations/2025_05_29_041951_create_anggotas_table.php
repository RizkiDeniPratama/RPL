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
        Schema::create('anggota', function (Blueprint $table) {
            $table->string('NoAnggotaM')->primary();
            $table->string('NIS')->nullable();
            $table->string('NamaAnggota')->nullable();
            $table->date('TTL')->nullable();
            $table->string('Jenis_Kelamin')->nullable();
            $table->string('Alamat')->nullable();
            $table->string('Kelas')->nullable();
            $table->string('NoTelp')->nullable();
            $table->string('NamaOrtu')->nullable();
            $table->string('NoTelpOrtu')->nullable();
            $table->timestamps();
        });

        Schema::create('anggota_non_siswa', function (Blueprint $table) {
            $table->string('NoAnggotaN')->primary();
            $table->string('NIP');
            $table->string('NamaAnggota');
            $table->string('Jabatan');
            $table->date('TTL');
            $table->string('Alamat');
            $table->string('KodePos');
            $table->string('NoTelpHp');
            $table->date('TglDaftar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
        Schema::dropIfExists('anggota_non_siswa');
    }
};
