<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surats')->onDelete('cascade');
            $table->string('nik', 16);
            $table->text('keperluan');
            $table->json('data_tambahan')->nullable(); // untuk data spesifik per jenis surat
            $table->enum('status', ['Proses', 'Selesai', 'Ditolak'])->default('Proses');
            $table->text('keterangan_status')->nullable();
            $table->timestamp('tanggal_pengajuan');
            $table->timestamp('tanggal_diproses')->nullable();
            $table->foreignId('diproses_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->foreign('nik')->references('nik')->on('penduduk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};
