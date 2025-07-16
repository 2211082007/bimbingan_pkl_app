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
        Schema::create('usulan_pkl', function (Blueprint $table) {
            $table->id('id_usulan');
            $table->unsignedBigInteger('pembimbing_id')->nullable();
            $table->unsignedBigInteger('mhs_id');
            $table->string('nama_perusahaan');
            $table->text('deskripsi');
            $table->enum('konfirmasi', ['0', '1'])->default('0');
            $table->string('upload_file')->nullable();
            $table->timestamps();

            // Foreign key constraints with cascade options
            $table->foreign('mhs_id')
                ->references('id_mhs')
                ->on('mahasiswa')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('pembimbing_id')->references('id_dosen')->on('dosen')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Disable foreign key checks only within this method to safely drop the table
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('usulan_pkl');
        Schema::enableForeignKeyConstraints();
    }
};
