<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penduduk;
use App\Models\InformasiKelurahan;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Update existing penduduk with RT/RW
        $penduduk = Penduduk::take(10)->get();
        
        foreach($penduduk as $index => $p) {
            $rt = str_pad(($index % 3) + 1, 3, '0', STR_PAD_LEFT);
            $rw = str_pad(($index % 2) + 1, 3, '0', STR_PAD_LEFT);
            
            $p->update([
                'rt' => $rt,
                'rw' => $rw
            ]);
        }

        // Create sample informasi
        InformasiKelurahan::create([
            'judul' => 'Selamat Datang di KUINSEL',
            'deskripsi' => 'Sistem Informasi Kelurahan KUINSEL adalah platform digital yang memudahkan pelayanan administrasi desa.',
            'is_published' => true,
            'dibuat_oleh' => 1,
            'tanggal_publish' => now()
        ]);

        InformasiKelurahan::create([
            'judul' => 'Jadwal Pelayanan Surat Menyurat',
            'deskripsi' => 'Pelayanan surat menyurat dibuka setiap hari Senin-Jumat pukul 08.00-15.00 WIB.',
            'is_published' => true,
            'dibuat_oleh' => 1,
            'tanggal_publish' => now()
        ]);

        InformasiKelurahan::create([
            'judul' => 'Profil Kelurahan',
            'deskripsi' => 'Kelurahan KUINSEL terletak di wilayah yang strategis dengan penduduk yang ramah dan gotong royong.',
            'is_published' => true,
            'dibuat_oleh' => 1,
            'tanggal_publish' => now()
        ]);
    }
}
