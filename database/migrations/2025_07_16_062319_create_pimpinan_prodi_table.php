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
        Schema::create('pimpinan_prodi', function (Blueprint $table) {
            $table->id('id_pimpinan_prodi');
            $table->unsignedBigInteger('jabatan_id');
            $table->unsignedBigInteger('prodi_id');
            $table->unsignedBigInteger('dosen_id');
            $table->string('periode');
            $table->enum('status', ['0','1'])->default(1);

            $table->foreign('prodi_id')->references('id_prodi')->on('prodi');
            $table->foreign('jabatan_id')->references('id_jabatan')->on('jabatan');
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pimpinan_prodi');
    }
};
