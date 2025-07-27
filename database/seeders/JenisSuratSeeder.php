<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        
        $data = [
            [
                'nama_surat' => 'Surat Keterangan Domisili (SKD)',
                'kode_surat' => '145.1',
                'template' => 'Template surat sesuai kebutuhan',
                'keterangan' => 'Keterangan tempat tinggal/domisili',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_surat' => 'Surat Keterangan Tidak Mampu (SKTM)',
                'kode_surat' => '312.1',
                'template' => 'Dengan ini menerangkan bahwa {nama} benar merupakan warga yang tidak mampu di {alamat}. Surat ini digunakan untuk keperluan {keperluan}.',
                'keterangan' => 'Keterangan ekonomi tidak mampu',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_surat' => 'Surat Domisili',
                'kode_surat' => '470',
                'template' => 'Template surat sesuai kebutuhan',
                'keterangan' => 'Keterangan domisili umum',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_surat' => 'Surat Keterangan Belum Menikah (SKBM)',
                'kode_surat' => '470.1',
                'template' => 'Template surat sesuai kebutuhan',
                'keterangan' => 'Keterangan status belum menikah',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_surat' => 'Surat Pindah',
                'kode_surat' => '474',
                'template' => 'Template surat sesuai kebutuhan',
                'keterangan' => 'Administrasi pindah domisili',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_surat' => 'Surat Kematian',
                'kode_surat' => '474.3',
                'template' => 'Template surat sesuai kebutuhan',
                'keterangan' => 'Administrasi kematian',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_surat' => 'Surat Izin Usaha',
                'kode_surat' => '503',
                'template' => 'Template surat sesuai kebutuhan',
                'keterangan' => 'Perizinan usaha',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_surat' => 'Surat Keterangan Umum',
                'kode_surat' => 'UMUM',
                'template' => 'Template surat sesuai kebutuhan',
                'keterangan' => 'Keterangan umum sesuai kebutuhan',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        
        DB::table('jenis_surats')->insert($data);
    }
}