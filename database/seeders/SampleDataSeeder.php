<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penduduk;
use App\Models\InformasiKelurahan;
use App\Models\PengajuanSurat;
use App\Models\JenisSurat;
use App\Models\User;
use Carbon\Carbon;

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

        // Create sample pengajuan surat for statistics
        $this->createSamplePengajuanSurat();
    }

    private function createSamplePengajuanSurat()
    {
        // Get jenis surat and users
        $jenisSurat = JenisSurat::all();
        $users = User::whereHas('roles', function($query) {
            $query->where('name', 'user');
        })->take(5)->get();

        if ($jenisSurat->isEmpty() || $users->isEmpty()) {
            $this->command->info('Skipping pengajuan surat creation - no jenis surat or users found');
            return;
        }

        // Create sample data for the last 12 months
        $statuses = ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'];
        $sampleData = [];

        // Generate data for each month in 2025
        for ($month = 1; $month <= 12; $month++) {
            $monthlyCount = rand(5, 25); // Random number of applications per month
            
            for ($i = 0; $i < $monthlyCount; $i++) {
                $user = $users->random();
                $jenis = $jenisSurat->random();
                $status = $statuses[array_rand($statuses)];
                
                // Random date within the month
                $date = Carbon::create(2025, $month, rand(1, 28), rand(8, 17), rand(0, 59));
                
                $sampleData[] = [
                    'user_id' => $user->id,
                    'jenis_surat_id' => $jenis->id,
                    'nik' => $user->nik,
                    'keperluan' => $this->getRandomKeperluan(),
                    'data_tambahan' => json_encode([
                        'keterangan' => 'Data tambahan untuk keperluan ' . $this->getRandomKeperluan()
                    ]),
                    'status' => $status,
                    'keterangan_status' => $this->getStatusKeterangan($status),
                    'tanggal_pengajuan' => $date,
                    'tanggal_diproses' => $status !== 'Menunggu' ? $date->copy()->addHours(rand(1, 48)) : null,
                    'diproses_oleh' => $status !== 'Menunggu' ? $this->getRandomPetugas() : null,
                    'created_at' => $date,
                    'updated_at' => $date
                ];
            }
        }

        // Insert all data at once for better performance
        PengajuanSurat::insert($sampleData);
        
        $this->command->info('Created ' . count($sampleData) . ' sample pengajuan surat records');
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

    private function getRandomPetugas()
    {
        // Get random petugas or admin user
        $petugas = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['admin', 'petugas', 'lurah']);
        })->inRandomOrder()->first();

        return $petugas ? $petugas->id : 1; // fallback to user ID 1
    }
}
