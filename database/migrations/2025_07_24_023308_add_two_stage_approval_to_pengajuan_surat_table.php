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
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            // Ubah status untuk mendukung 2 tahap approval
            $table->dropColumn('status');
        });

        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'])->default('Menunggu');
            
            // Kolom untuk approval tahap 1 (Petugas)
            $table->timestamp('tanggal_diproses_petugas')->nullable()->after('tanggal_diproses');
            $table->foreignId('diproses_oleh_petugas')->nullable()->constrained('users')->onDelete('set null')->after('diproses_oleh');
            $table->text('keterangan_petugas')->nullable()->after('diproses_oleh_petugas');
            
            // Kolom untuk approval tahap 2 (Lurah)
            $table->timestamp('tanggal_diproses_lurah')->nullable()->after('keterangan_petugas');
            $table->foreignId('diproses_oleh_lurah')->nullable()->constrained('users')->onDelete('set null')->after('tanggal_diproses_lurah');
            $table->text('keterangan_lurah')->nullable()->after('diproses_oleh_lurah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan_surat', function (Blueprint $table) {
            $table->dropForeign(['diproses_oleh_petugas']);
            $table->dropForeign(['diproses_oleh_lurah']);
            $table->dropColumn([
                'tanggal_diproses_petugas',
                'diproses_oleh_petugas',
                'keterangan_petugas',
                'tanggal_diproses_lurah',
                'diproses_oleh_lurah',
                'keterangan_lurah'
            ]);
            $table->dropColumn('status');
        });

        Schema::table('pengajuan_surat', function (Blueprint $table) {
            $table->enum('status', ['Proses', 'Selesai', 'Ditolak'])->default('Proses');
        });
    }
};
