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
        Schema::create('dosen', function (Blueprint $table) {
            $table->unsignedBigInteger('id_dosen')->primary();
            $table->string('nidn')->unique();
            $table->string('nama');
            $table->string('nip')->unique();
            $table->string('gender');
            $table->text('tempt_lahir');
            $table->date('tgl_lahir');
            $table->string('password');
            $table->string('pendidikan');
            $table->unsignedBigInteger('jurusan_id');
            $table->unsignedBigInteger('prodi_id');
            $table->unsignedBigInteger('golongan_id');
            $table->text('alamat');
            $table->string('email');
            $table->string('no_hp');
            $table->string('image')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('jurusan_id')->references('id_jurusan')->on('jurusan')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('prodi_id')->references('id_prodi')->on('prodi')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('golongan_id')->references('id_golongan')->on('golongan')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
