<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Load Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Sync RT and RW data from users to penduduk table
$updated = DB::table('penduduk as p')
    ->join('users as u', 'p.nik', '=', 'u.nik')
    ->whereNull('p.rt')
    ->orWhereNull('p.rw')
    ->update([
        'p.rt' => DB::raw('u.rt'),
        'p.rw' => DB::raw('u.rw')
    ]);

echo "Updated {$updated} records\n";

// Show sample data to verify
$samples = DB::table('penduduk as p')
    ->join('users as u', 'p.nik', '=', 'u.nik')
    ->select('p.nama_lengkap', 'p.rt as p_rt', 'p.rw as p_rw', 'u.rt as u_rt', 'u.rw as u_rw')
    ->limit(5)
    ->get();

echo "Sample data:\n";
foreach ($samples as $sample) {
    echo "Name: {$sample->nama_lengkap}, Penduduk RT/RW: {$sample->p_rt}/{$sample->p_rw}, User RT/RW: {$sample->u_rt}/{$sample->u_rw}\n";
}

echo "Sync completed!\n";
