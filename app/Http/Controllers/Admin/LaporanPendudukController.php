<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use Carbon\Carbon;

class LaporanPendudukController extends Controller
{
    public function __construct()
    {
        // Hanya admin dan petugas yang bisa akses laporan
        $this->middleware(['role:admin|petugas']);
    }
    
    public function index(Request $request)
    {
        $query = Penduduk::query();
        
        // Filter berdasarkan jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        
        // Filter berdasarkan agama
        if ($request->filled('agama')) {
            $query->where('agama', $request->agama);
        }
        
        // Filter berdasarkan status perkawinan
        if ($request->filled('status_perkawinan')) {
            $query->where('status_perkawinan', $request->status_perkawinan);
        }
        
        // Filter berdasarkan status penduduk
        if ($request->filled('status_penduduk')) {
            $query->where('status_penduduk', $request->status_penduduk);
        }
        
        // Filter berdasarkan umur
        if ($request->filled('umur_min')) {
            $tanggalMax = Carbon::now()->subYears($request->umur_min)->format('Y-m-d');
            $query->whereDate('tanggal_lahir', '<=', $tanggalMax);
        }
        
        if ($request->filled('umur_max')) {
            $tanggalMin = Carbon::now()->subYears($request->umur_max + 1)->format('Y-m-d');
            $query->whereDate('tanggal_lahir', '>', $tanggalMin);
        }
        
        // Filter berdasarkan tanggal registrasi
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        // Search berdasarkan nama atau NIK
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }
        
        $penduduk = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.laporan.penduduk.index', compact('penduduk'));
    }
    
    public function cetak(Request $request)
    {
        $query = Penduduk::query();
        
        // Apply same filters as index
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        
        if ($request->filled('agama')) {
            $query->where('agama', $request->agama);
        }
        
        if ($request->filled('status_perkawinan')) {
            $query->where('status_perkawinan', $request->status_perkawinan);
        }
        
        if ($request->filled('status_penduduk')) {
            $query->where('status_penduduk', $request->status_penduduk);
        }
        
        if ($request->filled('umur_min')) {
            $tanggalMax = Carbon::now()->subYears($request->umur_min)->format('Y-m-d');
            $query->whereDate('tanggal_lahir', '<=', $tanggalMax);
        }
        
        if ($request->filled('umur_max')) {
            $tanggalMin = Carbon::now()->subYears($request->umur_max + 1)->format('Y-m-d');
            $query->whereDate('tanggal_lahir', '>', $tanggalMin);
        }
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }
        
        $penduduk = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.laporan.penduduk.cetak', compact('penduduk'));
    }
}
