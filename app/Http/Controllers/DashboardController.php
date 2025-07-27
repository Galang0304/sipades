<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use App\Models\InformasiKelurahan;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $user = auth()->user();
            
            // Make sure user has roles
            if (!$user->roles->count()) {
                // Assign default role if user has no roles
                $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'warga']);
                $user->assignRole('warga');
                \Log::info('Assigned default warga role to user: ' . $user->email);
            }
            
            if ($user->isAdmin()) {
                return $this->adminDashboard();
            } elseif ($user->isLurah()) {
                return $this->lurahDashboard();
            } elseif ($user->isPetugas()) {
                return $this->petugasDashboard();
            } else {
                // Default to penduduk dashboard for warga and any other roles
                return $this->pendudukDashboard();
            }
        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat memuat dashboard.');
        }
    }

    private function adminDashboard()
    {
        try {
            $stats = [
                'total_penduduk' => Penduduk::count(),
                'total_users' => User::count(),
                'surat_proses' => PengajuanSurat::where('status', 'proses')->count(),
                'surat_selesai' => PengajuanSurat::where('status', 'disetujui')->count(),
            ];

            $recent_surat = PengajuanSurat::with(['user', 'jenis_surat'])
                ->latest('tanggal_pengajuan')
                ->limit(5)
                ->get();

            return view('dashboard.admin', compact('stats', 'recent_surat'));
        } catch (\Exception $e) {
            \Log::error('Admin Dashboard Error: ' . $e->getMessage());
            return view('dashboard.admin', [
                'stats' => [
                    'total_penduduk' => 0,
                    'total_users' => 0,
                    'surat_proses' => 0,
                    'surat_selesai' => 0,
                ],
                'recent_surat' => collect()
            ]);
        }
    }

    private function lurahDashboard()
    {
        try {
            $stats = [
                'surat_menunggu_lurah' => PengajuanSurat::where('status', 'Diproses')->count(),
                'surat_approved' => PengajuanSurat::where('status', 'Selesai')->count(),
                'surat_rejected' => PengajuanSurat::where('status', 'Ditolak')->count(),
                'total_penduduk' => Penduduk::count(),
            ];

            // Surat yang sudah diproses petugas, menunggu persetujuan lurah
            $surat_menunggu_lurah = PengajuanSurat::with(['user', 'jenis_surat', 'penduduk', 'petugas'])
                ->where('status', 'Diproses')
                ->latest('tanggal_diproses_petugas')
                ->limit(10)
                ->get();

            return view('dashboard.lurah', compact('stats', 'surat_menunggu_lurah'));
        } catch (\Exception $e) {
            \Log::error('Lurah Dashboard Error: ' . $e->getMessage());
            return view('dashboard.lurah', [
                'stats' => [
                    'surat_menunggu_lurah' => 0,
                    'surat_approved' => 0,
                    'surat_rejected' => 0,
                    'total_penduduk' => 0,
                ],
                'surat_menunggu_lurah' => collect()
            ]);
        }
    }

    private function petugasDashboard()
    {
        $stats = [
            'total_penduduk' => Penduduk::count(),
            'total_informasi' => InformasiKelurahan::count(),
            'surat_pending' => PengajuanSurat::where('status', 'Menunggu')->count(),
            'surat_diproses' => PengajuanSurat::where('status', 'Diproses')->count(),
            'surat_selesai' => PengajuanSurat::where('status', 'Selesai')->count(),
            'user_pending' => User::where('is_pending', true)->where('is_active', false)->count(),
        ];

        // Surat yang menunggu persetujuan petugas
        $surat_pending = PengajuanSurat::with(['user', 'jenis_surat', 'penduduk'])
            ->where('status', 'Menunggu')
            ->latest('tanggal_pengajuan')
            ->limit(10)
            ->get();

        return view('dashboard.petugas', compact('stats', 'surat_pending'));
    }

    private function pendudukDashboard()
    {
        try {
            $user_id = auth()->id();
            
            $stats = [
                'my_surat' => PengajuanSurat::where('user_id', $user_id)->count(),
            ];

            $my_surat = PengajuanSurat::with(['jenis_surat'])
                ->where('user_id', $user_id)
                ->latest('tanggal_pengajuan')
                ->limit(5)
                ->get();

            // Set empty collection for informasi for now
            $informasi = collect();

            return view('dashboard.penduduk', compact('stats', 'my_surat', 'informasi'));
        } catch (\Exception $e) {
            \Log::error('Penduduk Dashboard Error: ' . $e->getMessage());
            
            // Return view with safe default data
            return view('dashboard.penduduk', [
                'stats' => ['my_surat' => 0],
                'my_surat' => collect(),
                'informasi' => collect()
            ]);
        }
    }
}
