<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPendudukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:admin|petugas']);
    }

    public function index(Request $request)
    {
        $query = Penduduk::query();

        // Filter berdasarkan jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter berdasarkan status perkawinan
        if ($request->filled('status_perkawinan')) {
            $query->where('status_perkawinan', $request->status_perkawinan);
        }

        // Filter berdasarkan RT
        if ($request->filled('rt')) {
            $query->where('rt', $request->rt);
        }

        // Filter berdasarkan RW
        if ($request->filled('rw')) {
            $query->where('rw', $request->rw);
        }

        // Filter berdasarkan agama
        if ($request->filled('agama')) {
            $query->where('agama', $request->agama);
        }

        // Filter berdasarkan umur
        if ($request->filled('umur_min')) {
            $umurMin = $request->umur_min;
            $query->whereRaw('YEAR(CURDATE()) - YEAR(tanggal_lahir) >= ?', [$umurMin]);
        }

        if ($request->filled('umur_max')) {
            $umurMax = $request->umur_max;
            $query->whereRaw('YEAR(CURDATE()) - YEAR(tanggal_lahir) <= ?', [$umurMax]);
        }

        $penduduk = $query->orderBy('nama_lengkap', 'asc')->get();

        // Statistik
        $total_penduduk = $penduduk->count();
        $total_laki = $penduduk->where('jenis_kelamin', 'Laki-laki')->count();
        $total_perempuan = $penduduk->where('jenis_kelamin', 'Perempuan')->count();

        // Statistik berdasarkan agama
        $statistik_agama = $penduduk->groupBy('agama')->map->count();

        // Statistik berdasarkan RT/RW
        $statistik_rt = $penduduk->groupBy('rt')->map->count();
        $statistik_rw = $penduduk->groupBy('rw')->map->count();

        // Data untuk filter dropdown
        $rt_list = Penduduk::distinct()->pluck('rt')->filter()->sort()->values();
        $rw_list = Penduduk::distinct()->pluck('rw')->filter()->sort()->values();
        $agama_list = Penduduk::distinct()->pluck('agama')->filter()->sort()->values();

        return view('laporan.penduduk', compact(
            'penduduk', 
            'total_penduduk', 
            'total_laki', 
            'total_perempuan',
            'statistik_agama',
            'statistik_rt',
            'statistik_rw',
            'rt_list',
            'rw_list',
            'agama_list'
        ));
    }

    public function cetak(Request $request)
    {
        $query = Penduduk::query();

        // Filter berdasarkan jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter berdasarkan status perkawinan
        if ($request->filled('status_perkawinan')) {
            $query->where('status_perkawinan', $request->status_perkawinan);
        }

        // Filter berdasarkan RT
        if ($request->filled('rt')) {
            $query->where('rt', $request->rt);
        }

        // Filter berdasarkan RW
        if ($request->filled('rw')) {
            $query->where('rw', $request->rw);
        }

        // Filter berdasarkan agama
        if ($request->filled('agama')) {
            $query->where('agama', $request->agama);
        }

        // Filter berdasarkan umur
        if ($request->filled('umur_min')) {
            $umurMin = $request->umur_min;
            $query->whereRaw('YEAR(CURDATE()) - YEAR(tanggal_lahir) >= ?', [$umurMin]);
        }

        if ($request->filled('umur_max')) {
            $umurMax = $request->umur_max;
            $query->whereRaw('YEAR(CURDATE()) - YEAR(tanggal_lahir) <= ?', [$umurMax]);
        }

        $penduduk = $query->orderBy('nama_lengkap', 'asc')->get();

        // Statistik
        $total_penduduk = $penduduk->count();
        $total_laki = $penduduk->where('jenis_kelamin', 'Laki-laki')->count();
        $total_perempuan = $penduduk->where('jenis_kelamin', 'Perempuan')->count();

        return view('laporan.cetak_penduduk', compact(
            'penduduk', 
            'total_penduduk', 
            'total_laki', 
            'total_perempuan'
        ));
    }
}
