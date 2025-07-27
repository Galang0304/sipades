<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/sync-rt-rw', function () {
    try {
        // Update penduduk table dengan data RT/RW dari users table
        $pendudukList = \App\Models\Penduduk::all();
        
        $updated = 0;
        foreach ($pendudukList as $penduduk) {
            $user = \App\Models\User::where('nik', $penduduk->nik)->first();
            if ($user && $user->rt && $user->rw) {
                $penduduk->update([
                    'rt' => $user->rt,
                    'rw' => $user->rw
                ]);
                $updated++;
            }
        }
        
        return "Updated {$updated} penduduk records with RT/RW data";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
