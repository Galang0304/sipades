<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanSurat;
use App\Models\JenisSurat;
use Carbon\Carbon;

class LaporanSuratController extends Controller
{
    public function __construct()
    {
        // Hanya admin dan petugas yang bisa akses laporan
        $this->middleware(['role:admin|petugas']);
    }
    
    public function index(Request $request)
    {
        $jenisSurat = JenisSurat::all();
        
        $query = PengajuanSurat::with(['user', 'penduduk', 'jenis_surat']);
        
        // Filter berdasarkan jenis surat
        if ($request->filled('jenis_surat_id')) {
            $query->where('jenis_surat_id', $request->jenis_surat_id);
        }
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        // Filter berdasarkan bulan dan tahun
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }
        
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }
        
        $surat = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.laporan.surat.index', compact('surat', 'jenisSurat'));
    }
    
    public function cetak(Request $request)
    {
        $jenisSurat = JenisSurat::all();
        
        $query = PengajuanSurat::with(['user', 'penduduk', 'jenis_surat']);
        
        // Apply same filters as index
        if ($request->filled('jenis_surat_id')) {
            $query->where('jenis_surat_id', $request->jenis_surat_id);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }
        
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }
        
        $surat = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.laporan.surat.cetak', compact('surat', 'jenisSurat'));
    }
}
