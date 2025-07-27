<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengajuanSurat;
use App\Models\User;

class PengajuanSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get users
        $warga = User::role('member')->first();
        $jenisSurat = \App\Models\JenisSurat::first();
        
        if (!$warga) {
            $this->command->error('User dengan role member tidak ditemukan');
            return;
        }

        if (!$jenisSurat) {
            $this->command->error('Jenis surat tidak ditemukan');
            return;
        }

        // Pastikan ada data penduduk yang sesuai dengan warga
        $penduduk = \App\Models\Penduduk::where('nik', $warga->nik)->first();
        if (!$penduduk && $warga->nik) {
            // Buat data penduduk jika belum ada
            \App\Models\Penduduk::create([
                'nik' => $warga->nik,
                'nama' => $warga->name,
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Test No. 123',
                'rt' => '001',
                'rw' => '001',
                'kelurahan' => 'Test Kelurahan',
                'kecamatan' => 'Test Kecamatan',
                'agama' => 'Islam',
                'status_perkawinan' => 'Belum Kawin',
                'pekerjaan' => 'Pegawai Swasta',
                'kewarganegaraan' => 'WNI'
            ]);
        }

        $nikToUse = $warga->nik ?? '1234567890123456';

        // Create test data for notifications
        
        // 1. Surat baru (status Menunggu - untuk notifikasi petugas)
        PengajuanSurat::create([
            'user_id' => $warga->id,
            'jenis_surat_id' => $jenisSurat->id,
            'nik' => $nikToUse,
            'keperluan' => 'Surat keterangan usaha untuk keperluan administrasi.',
            'status' => 'Menunggu',
            'tanggal_pengajuan' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PengajuanSurat::create([
            'user_id' => $warga->id,
            'jenis_surat_id' => $jenisSurat->id,
            'nik' => $nikToUse,
            'keperluan' => 'Surat keterangan domisili untuk persyaratan sekolah.',
            'status' => 'Menunggu',
            'tanggal_pengajuan' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Surat yang sudah diproses petugas (status Diproses - untuk notifikasi lurah)
        $petugas = User::role('petugas')->first();
        if ($petugas) {
            PengajuanSurat::create([
                'user_id' => $warga->id,
                'jenis_surat_id' => $jenisSurat->id,
                'nik' => $nikToUse,
                'keperluan' => 'Surat keterangan tidak mampu untuk bantuan sosial.',
                'status' => 'Diproses',
                'tanggal_pengajuan' => now()->subDays(1),
                'tanggal_diproses_petugas' => now()->subHours(2),
                'diproses_oleh_petugas' => $petugas->id,
                'keterangan_petugas' => 'Dokumen sudah diverifikasi petugas',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subHours(2),
            ]);
        }

        $this->command->info('Test data pengajuan surat berhasil dibuat');
        $this->command->info('- 2 surat status Menunggu (untuk notifikasi petugas)');
        $this->command->info('- 1 surat status Diproses (untuk notifikasi lurah)');
    }
}
