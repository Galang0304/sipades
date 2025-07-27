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
        Schema::table('penduduk', function (Blueprint $table) {
            // Tambahkan field yang diperlukan
            $table->string('no_kk', 16)->nullable()->after('nik');
            $table->string('no_tlp')->nullable()->after('rw');
            $table->string('foto_kk')->nullable()->after('no_tlp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropColumn(['no_kk', 'no_tlp', 'foto_kk']);
        });
    }
};
