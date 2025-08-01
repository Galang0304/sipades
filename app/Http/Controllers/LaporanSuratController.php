<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanSuratController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:admin|petugas|lurah']);
    }

    public function index(Request $request)
    {
        $query = PengajuanSurat::with(['user', 'jenisSurat']);

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status == 'pending') {
                $query->whereIn('status', ['pending', 'Menunggu', 'menunggu']);
            } elseif ($status == 'approved') {
                $query->whereIn('status', ['approved', 'Selesai', 'selesai', 'disetujui']);
            } elseif ($status == 'rejected') {
                $query->whereIn('status', ['rejected', 'Ditolak', 'ditolak']);
            } else {
                $query->where('status', $status);
            }
        }

        // Filter berdasarkan jenis surat
        if ($request->filled('jenis_surat_id')) {
            $query->where('jenis_surat_id', $request->jenis_surat_id);
        }

        $pengajuan = $query->orderBy('created_at', 'desc')->get();

        // Statistik dengan berbagai kemungkinan status
        $total_pengajuan = $pengajuan->count();
        $pengajuan_pending = $pengajuan->whereIn('status', ['pending', 'Menunggu', 'menunggu', 'Diproses', 'diproses'])->count();
        $pengajuan_disetujui = $pengajuan->whereIn('status', ['approved', 'Selesai', 'selesai', 'disetujui'])->count();
        $pengajuan_ditolak = $pengajuan->whereIn('status', ['rejected', 'Ditolak', 'ditolak'])->count();

        // Jenis Surat untuk filter
        $jenisSurat = \App\Models\JenisSurat::all();

        return view('laporan.surat', compact(
            'pengajuan', 
            'total_pengajuan', 
            'pengajuan_pending', 
            'pengajuan_disetujui', 
            'pengajuan_ditolak',
            'jenisSurat'
        ));
    }

    public function cetak(Request $request)
    {
        $query = PengajuanSurat::with(['user', 'jenisSurat']);

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status == 'pending') {
                $query->whereIn('status', ['pending', 'Menunggu', 'menunggu']);
            } elseif ($status == 'approved') {
                $query->whereIn('status', ['approved', 'Selesai', 'selesai', 'disetujui']);
            } elseif ($status == 'rejected') {
                $query->whereIn('status', ['rejected', 'Ditolak', 'ditolak']);
            } else {
                $query->where('status', $status);
            }
        }

        // Filter berdasarkan jenis surat
        if ($request->filled('jenis_surat_id')) {
            $query->where('jenis_surat_id', $request->jenis_surat_id);
        }

        $pengajuan = $query->orderBy('created_at', 'desc')->get();

        // Statistik dengan berbagai kemungkinan status
        $total_pengajuan = $pengajuan->count();
        $pengajuan_pending = $pengajuan->whereIn('status', ['pending', 'Menunggu', 'menunggu', 'Diproses', 'diproses'])->count();
        $pengajuan_disetujui = $pengajuan->whereIn('status', ['approved', 'Selesai', 'selesai', 'disetujui'])->count();
        $pengajuan_ditolak = $pengajuan->whereIn('status', ['rejected', 'Ditolak', 'ditolak'])->count();

        return view('laporan.cetak_surat', compact(
            'pengajuan', 
            'total_pengajuan', 
            'pengajuan_pending', 
            'pengajuan_disetujui', 
            'pengajuan_ditolak'
        ));
    }
}
