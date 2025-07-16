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
        Schema::create('bimbingan_pkl', function (Blueprint $table) {
            $table->id('id_bimbinganPkl');

            // Inputan mahasiswa
            $table->unsignedBigInteger('usulan_id');
            $table->string('laporan');
            $table->string('kegiatan')->nullable()->default('');
            $table->date('tgl_awal');
            $table->date('tgl_akhir');

            // Inputan pembimbing
            $table->enum('verif', ['0', '1', '2'])->default('0')->comment('0: Belum Diverifikasi, 1: Disetujui, 2: Ditolak');
            $table->string('catatan')->nullable();

            // Foreign key
            $table->foreign('usulan_id')->references('id_usulan')->on('usulan_pkl')->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bimbingan_pkl');
    }
};
