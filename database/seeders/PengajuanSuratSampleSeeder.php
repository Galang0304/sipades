<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengajuanSurat;
use App\Models\JenisSurat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PengajuanSuratSampleSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        PengajuanSurat::truncate();
        
        // Get jenis surat and users
        $jenisSurat = JenisSurat::all();
        $users = User::all();

        if ($jenisSurat->isEmpty() || $users->isEmpty()) {
            $this->command->info('Creating basic data first...');
            
            // Create basic jenis surat if not exists
            if ($jenisSurat->isEmpty()) {
                $this->createJenisSurat();
                $jenisSurat = JenisSurat::all();
            }
            
            // Create basic users if not exists
            if ($users->isEmpty()) {
                $this->command->info('No users found. Please run UserSeeder first.');
                return;
            }
        }

        // Create sample pengajuan surat
        $statuses = ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'];
        $sampleData = [];

        // Generate data for 2025
        for ($month = 1; $month <= 12; $month++) {
            $monthlyCount = rand(8, 30); // Random number of applications per month
            
            for ($i = 0; $i < $monthlyCount; $i++) {
                $user = $users->random();
                $jenis = $jenisSurat->random();
                $status = $statuses[array_rand($statuses)];
                
                // Random date within the month
                $date = Carbon::create(2025, $month, rand(1, 28), rand(8, 17), rand(0, 59));
                
                $sampleData[] = [
                    'user_id' => $user->id,
                    'jenis_surat_id' => $jenis->id,
                    'nik' => $user->nik ?? '1234567890123456',
                    'keperluan' => $this->getRandomKeperluan(),
                    'data_tambahan' => json_encode([
                        'keterangan' => 'Data tambahan untuk keperluan administrasi'
                    ]),
                    'status' => $status,
                    'keterangan_status' => $this->getStatusKeterangan($status),
                    'tanggal_pengajuan' => $date,
                    'tanggal_diproses' => $status !== 'Menunggu' ? $date->copy()->addHours(rand(1, 48)) : null,
                    'diproses_oleh' => $status !== 'Menunggu' ? $user->id : null,
                    'created_at' => $date,
                    'updated_at' => $date
                ];
            }
        }

        // Insert data in chunks to avoid memory issues
        $chunks = array_chunk($sampleData, 100);
        foreach ($chunks as $chunk) {
            PengajuanSurat::insert($chunk);
        }
        
        $this->command->info('Created ' . count($sampleData) . ' sample pengajuan surat records');
    }

    private function createJenisSurat()
    {
        $jenisSurat = [
            [
                'nama_surat' => 'Surat Keterangan Domisili (SKD)',
                'kode_surat' => '145.1',
                'template' => 'Template surat sesuai kebutuhan',
                'keterangan' => 'Keterangan tempat tinggal/domisili',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_surat' => 'Surat Keterangan Tidak Mampu (SKTM)',
                'kode_surat' => '312.1',
                'template' => 'Template surat sesuai kebutuhan',
                'keterangan' => 'Keterangan ekonomi tidak mampu',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_surat' => 'Surat Domisili',
                'kode_surat' => '470',
                'template' => 'Template surat sesuai kebutuhan',
                'keterangan' => 'Keterangan domisili umum',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_surat' => 'Surat Keterangan Belum Menikah (SKBM)',
                'kode_surat' => '470.1',
                'template' => 'Template surat sesuai kebutuhan',
                'keterangan' => 'Keterangan status belum menikah',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_surat' => 'Surat Pindah',
                'kode_surat' => '474',
                'template' => 'Template surat sesuai kebutuhan',
                'keterangan' => 'Administrasi pindah domisili',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_surat' => 'Surat Kematian',
                'kode_surat' => '474.3',
                'template' => 'Template surat sesuai kebutuhan',
                'keterangan' => 'Administrasi kematian',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_surat' => 'Surat Izin Usaha',
                'kode_surat' => '503',
                'template' => 'Template surat sesuai kebutuhan',
                'keterangan' => 'Perizinan usaha',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_surat' => 'Surat Keterangan Umum',
                'kode_surat' => 'UMUM',
                'template' => 'Template surat sesuai kebutuhan',
                'keterangan' => 'Keterangan umum sesuai kebutuhan',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        JenisSurat::insert($jenisSurat);
        $this->command->info('Created basic jenis surat data');
    }

    private function getRandomKeperluan()
    {
        $keperluan = [
            'Melamar pekerjaan',
            'Pendaftaran sekolah',
            'Mengurus KTP',
            'Mengurus SIM',
            'Mengurus BPJS',
            'Mengurus bank',
            'Keperluan administrasi',
            'Mengurus beasiswa',
            'Keperluan nikah',
            'Keperluan usaha',
            'Mengurus paspor',
            'Keperluan rumah sakit',
            'Mengurus asuransi',
            'Keperluan hukum',
            'Mengurus tanah'
        ];

        return $keperluan[array_rand($keperluan)];
    }

    private function getStatusKeterangan($status)
    {
        switch ($status) {
            case 'Menunggu':
                return 'Pengajuan sedang menunggu diproses';
            case 'Diproses':
                return 'Sedang diproses oleh petugas';
            case 'Selesai':
                return 'Surat telah selesai dan dapat diambil';
            case 'Ditolak':
                return 'Pengajuan ditolak karena data tidak lengkap';
            default:
                return 'Status tidak diketahui';
        }
    }
}
