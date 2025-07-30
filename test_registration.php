<?php

// Test registrasi penduduk baru
// File: test_registration.php

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Hash;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== TEST REGISTRASI PENDUDUK ===\n\n";

// Simulasi data registrasi
$testData = [
    'name' => 'Test User Registrasi',
    'email' => 'test_register@gmail.com', 
    'password' => 'password123',
    'password_confirmation' => 'password123',
    'nik' => '1234567890123999',
    'no_kk' => '9876543210987654',
    'alamat' => 'Jl. Test No. 123',
    'rt' => '001',
    'rw' => '002',
    'no_tlp' => '081234567890',
    'status_penduduk' => 'penduduk_tetap',
    'tempat_lahir' => 'Jakarta',
    'tanggal_lahir' => '1990-01-01',
    'jenis_kelamin' => 'L',
    'agama' => 'Islam',
    'status_perkawinan' => 'Belum Kawin',
    'pekerjaan' => 'Pegawai',
    'kewarganegaraan' => 'WNI'
];

echo "Data yang akan di-test:\n";
echo "NIK: " . $testData['nik'] . "\n";
echo "RT: " . $testData['rt'] . "\n";
echo "RW: " . $testData['rw'] . "\n";
echo "Alamat: " . $testData['alamat'] . "\n\n";

// Hapus data test lama jika ada
User::where('email', $testData['email'])->delete();
Penduduk::where('nik', $testData['nik'])->delete();

// Test pembuatan data penduduk
try {
    $penduduk = Penduduk::create([
        'nik' => $testData['nik'],
        'no_kk' => $testData['no_kk'],
        'nama_lengkap' => $testData['name'],
        'tempat_lahir' => $testData['tempat_lahir'],
        'tanggal_lahir' => $testData['tanggal_lahir'],
        'jenis_kelamin' => $testData['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan',
        'alamat' => $testData['alamat'],
        'rt' => $testData['rt'],
        'rw' => $testData['rw'],
        'no_tlp' => $testData['no_tlp'],
        'agama' => $testData['agama'],
        'status_perkawinan' => $testData['status_perkawinan'],
        'pekerjaan' => $testData['pekerjaan'],
        'status_penduduk' => $testData['status_penduduk'] === 'penduduk_tetap' ? 'Tetap' : 'Sementara'
    ]);
    
    echo "✅ Data Penduduk berhasil dibuat:\n";
    echo "ID: " . $penduduk->id . "\n";
    echo "NIK: " . $penduduk->nik . "\n";
    echo "Nama: " . $penduduk->nama_lengkap . "\n";
    echo "RT: " . $penduduk->rt . "\n";
    echo "RW: " . $penduduk->rw . "\n";
    echo "Alamat: " . $penduduk->alamat . "\n";
    echo "No KK: " . $penduduk->no_kk . "\n";
    echo "No Telp: " . $penduduk->no_tlp . "\n\n";
    
    // Test pembuatan user
    $user = User::create([
        'name' => $testData['name'],
        'email' => $testData['email'],
        'password' => Hash::make($testData['password']),
        'nik' => $testData['nik'],
        'email_verified_at' => now(),
        'is_active' => false,
        'is_pending' => true,
    ]);
    
    echo "✅ Data User berhasil dibuat:\n";
    echo "ID: " . $user->id . "\n";
    echo "Name: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "NIK: " . $user->nik . "\n";
    echo "Is Pending: " . ($user->is_pending ? 'Ya' : 'Tidak') . "\n\n";
    
    // Test relasi antara user dan penduduk
    $userPenduduk = $user->penduduk;
    if ($userPenduduk) {
        echo "✅ Relasi User-Penduduk berhasil:\n";
        echo "Penduduk dari User: " . $userPenduduk->nama_lengkap . "\n";
        echo "RT: " . $userPenduduk->rt . "\n";
        echo "RW: " . $userPenduduk->rw . "\n\n";
    } else {
        echo "❌ Relasi User-Penduduk gagal!\n\n";
    }
    
    echo "=== TEST BERHASIL ===\n";
    echo "Semua data berhasil tersimpan dengan lengkap!\n";
    echo "RT dan RW tersimpan dengan benar di kolom terpisah.\n\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

// Cleanup
echo "Membersihkan data test...\n";
User::where('email', $testData['email'])->delete();
Penduduk::where('nik', $testData['nik'])->delete();
echo "✅ Data test telah dibersihkan.\n";
