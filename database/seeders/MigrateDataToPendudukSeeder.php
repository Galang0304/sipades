<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Penduduk;

class MigrateDataToPendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil semua user yang memiliki NIK
        $users = User::whereNotNull('nik')->get();
        
        foreach ($users as $user) {
            // Cari penduduk berdasarkan NIK
            $penduduk = Penduduk::where('nik', $user->nik)->first();
            
            if ($penduduk) {
                // Update data penduduk dengan data dari user
                $penduduk->update([
                    'no_kk' => $user->no_kk ?? $penduduk->no_kk,
                    'rt' => $user->rt ?? $penduduk->rt,
                    'rw' => $user->rw ?? $penduduk->rw,
                    'no_tlp' => $user->no_tlp ?? $penduduk->no_tlp,
                    'alamat' => $user->alamat ?? $penduduk->alamat,
                    'foto_kk' => $user->foto_kk ?? $penduduk->foto_kk,
                ]);
                
                echo "Updated penduduk: {$penduduk->nama_lengkap} ({$penduduk->nik})\n";
            }
        }
        
        echo "Migration completed!\n";
    }
}
