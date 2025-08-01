<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformasiKelurahan;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanInformasiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|petugas|lurah']);
    }

    public function index(Request $request)
    {
        $query = InformasiKelurahan::with('pembuat');

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $informasi = $query->orderBy('created_at', 'desc')->paginate(20);

        // Statistik
        $stats = [
            'total_informasi' => InformasiKelurahan::count(),
            'published' => InformasiKelurahan::where('is_published', true)->count(),
            'draft' => InformasiKelurahan::where('is_published', false)->count(),
            'bulan_ini' => InformasiKelurahan::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count(),
        ];

        return view('laporan.informasi.index', compact('informasi', 'stats'));
    }

    public function cetak(Request $request)
    {
        $query = InformasiKelurahan::with('pembuat');

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $informasi = $query->orderBy('created_at', 'desc')->get();

        // Debug: log data
        \Log::info('Data informasi untuk cetak: ' . $informasi->count());

        $pdf = PDF::loadView('laporan.informasi.cetak', compact('informasi'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'Arial'
            ]);

        return $pdf->stream('laporan-informasi-' . date('Y-m-d') . '.pdf');
    }
}
