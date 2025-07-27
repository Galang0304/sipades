<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengajuanSurat;
use App\Models\User;
use App\Models\JenisSurat;
use Carbon\Carbon;

class TestPengajuanSuratSeeder extends Seeder
{
    public function run()
    {
        // Get warga user
        $warga = User::role('warga')->first();
        
        if (!$warga) {
            $this->command->info('No warga user found');
            return;
        }

        // Get jenis surat
        $jenisSurat = JenisSurat::all();
        
        if ($jenisSurat->isEmpty()) {
            $this->command->info('No jenis surat found');
            return;
        }

        // Create test pengajuan surat
        $testData = [
            [
                'user_id' => $warga->id,
                'jenis_surat_id' => $jenisSurat->first()->id,
                'nik' => $warga->nik,
                'keperluan' => 'Untuk keperluan melamar kerja',
                'status' => 'Menunggu',
                'tanggal_pengajuan' => Carbon::now()->subDays(2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $warga->id,
                'jenis_surat_id' => $jenisSurat->skip(1)->first()->id ?? $jenisSurat->first()->id,
                'nik' => $warga->nik,
                'keperluan' => 'Untuk keperluan mengurus KTP',
                'status' => 'Menunggu',
                'tanggal_pengajuan' => Carbon::now()->subDays(1),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $warga->id,
                'jenis_surat_id' => $jenisSurat->skip(2)->first()->id ?? $jenisSurat->first()->id,
                'nik' => $warga->nik,
                'keperluan' => 'Untuk keperluan pendaftaran sekolah',
                'status' => 'Menunggu',
                'tanggal_pengajuan' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($testData as $data) {
            PengajuanSurat::create($data);
        }

        $this->command->info('Test pengajuan surat data created successfully!');
    }
}
