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
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom yang duplikat, biarkan hanya data akun
            $table->dropColumn([
                'no_kk', 
                'alamat', 
                'rt', 
                'rw', 
                'no_tlp', 
                'status_penduduk'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Rollback: tambah kembali kolom yang dihapus
            $table->string('no_kk')->nullable()->after('nik');
            $table->string('alamat')->nullable()->after('no_kk');
            $table->string('rw')->nullable()->after('alamat');
            $table->string('rt')->nullable()->after('rw');
            $table->string('no_tlp')->nullable()->after('rt');
            $table->enum('status_penduduk', ['pindahan', 'penduduk_tetap', 'pendatang'])->default('penduduk_tetap')->after('no_tlp');
        });
    }
};
