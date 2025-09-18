<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSurat;
use App\Models\JenisSurat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatistikSuratController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|petugas|lurah');
    }

    /**
     * Display statistics dashboard
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $tahun = $request->get('tahun', date('Y'));
        $bulan = $request->get('bulan', 'all');
        $jenis_surat = $request->get('jenis_surat', 'all');

        // Get statistics data
        $statistikJenisSurat = $this->getStatistikJenisSurat($tahun, $bulan, $jenis_surat);
        $statistikStatus = $this->getStatistikStatus($tahun, $bulan, $jenis_surat);
        $statistikBulanan = $this->getStatistikBulanan($tahun, $jenis_surat);
        $statistikHarian = $this->getStatistikHarian($tahun, $bulan, $jenis_surat);

        // Get filter options
        $jenisSuratList = JenisSurat::active()->get();
        $tahunList = $this->getTahunList();

        return view('laporan.statistik-surat', compact(
            'statistikJenisSurat',
            'statistikStatus', 
            'statistikBulanan',
            'statistikHarian',
            'jenisSuratList',
            'tahunList',
            'tahun',
            'bulan',
            'jenis_surat'
        ));
    }

    /**
     * Get statistics by jenis surat
     */
    private function getStatistikJenisSurat($tahun, $bulan, $jenis_surat)
    {
        $query = PengajuanSurat::select('jenis_surat_id', DB::raw('count(*) as total'))
            ->with('jenisSurat')
            ->whereYear('tanggal_pengajuan', $tahun);

        if ($bulan !== 'all') {
            $query->whereMonth('tanggal_pengajuan', $bulan);
        }

        if ($jenis_surat !== 'all') {
            $query->where('jenis_surat_id', $jenis_surat);
        }

        $data = $query->groupBy('jenis_surat_id')
            ->orderBy('total', 'desc')
            ->get();

        return $data->map(function ($item) {
            return [
                'nama_surat' => $item->jenisSurat->nama_surat ?? 'Unknown',
                'kode_surat' => $item->jenisSurat->kode_surat ?? 'N/A',
                'total' => $item->total
            ];
        });
    }

    /**
     * Get statistics by status
     */
    private function getStatistikStatus($tahun, $bulan, $jenis_surat)
    {
        $query = PengajuanSurat::select('status', DB::raw('count(*) as total'))
            ->whereYear('tanggal_pengajuan', $tahun);

        if ($bulan !== 'all') {
            $query->whereMonth('tanggal_pengajuan', $bulan);
        }

        if ($jenis_surat !== 'all') {
            $query->where('jenis_surat_id', $jenis_surat);
        }

        return $query->groupBy('status')->get();
    }

    /**
     * Get monthly statistics
     */
    private function getStatistikBulanan($tahun, $jenis_surat)
    {
        $query = PengajuanSurat::select(
            DB::raw('MONTH(tanggal_pengajuan) as bulan'),
            DB::raw('count(*) as total')
        )->whereYear('tanggal_pengajuan', $tahun);

        if ($jenis_surat !== 'all') {
            $query->where('jenis_surat_id', $jenis_surat);
        }

        $data = $query->groupBy(DB::raw('MONTH(tanggal_pengajuan)'))
            ->orderBy('bulan')
            ->get();

        // Fill missing months with 0
        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $found = $data->firstWhere('bulan', $i);
            $result[] = [
                'bulan' => $i,
                'nama_bulan' => $this->getNamaBulan($i),
                'total' => $found ? $found->total : 0
            ];
        }

        return collect($result);
    }

    /**
     * Get daily statistics for current month
     */
    private function getStatistikHarian($tahun, $bulan, $jenis_surat)
    {
        if ($bulan === 'all') {
            $bulan = date('n'); // Current month
        }

        $query = PengajuanSurat::select(
            DB::raw('DAY(tanggal_pengajuan) as hari'),
            DB::raw('count(*) as total')
        )->whereYear('tanggal_pengajuan', $tahun)
         ->whereMonth('tanggal_pengajuan', $bulan);

        if ($jenis_surat !== 'all') {
            $query->where('jenis_surat_id', $jenis_surat);
        }

        return $query->groupBy(DB::raw('DAY(tanggal_pengajuan)'))
            ->orderBy('hari')
            ->get();
    }

    /**
     * Get available years
     */
    private function getTahunList()
    {
        $years = PengajuanSurat::select(DB::raw('YEAR(tanggal_pengajuan) as tahun'))
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        if (empty($years)) {
            $years = [date('Y')];
        }

        return $years;
    }

    /**
     * Get month name in Indonesian
     */
    private function getNamaBulan($bulan)
    {
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return $namaBulan[$bulan] ?? 'Unknown';
    }

    /**
     * API endpoint for chart data
     */
    public function chartData(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $bulan = $request->get('bulan', 'all');
        $jenis_surat = $request->get('jenis_surat', 'all');

        $data = [
            'jenis_surat' => $this->getStatistikJenisSurat($tahun, $bulan, $jenis_surat),
            'status' => $this->getStatistikStatus($tahun, $bulan, $jenis_surat),
            'bulanan' => $this->getStatistikBulanan($tahun, $jenis_surat),
        ];

        return response()->json($data);
    }
}
