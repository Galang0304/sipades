<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSurat;
use App\Models\JenisSurat;
use App\Models\Penduduk;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class PengajuanSuratController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('surat.index');
    }

    public function data()
    {
        $user = auth()->user();
        
        if ($user->isMember()) {
            $surat = PengajuanSurat::with(['jenis_surat', 'penduduk'])
                ->where('user_id', $user->id);
        } else {
            $surat = PengajuanSurat::with(['user', 'jenis_surat', 'penduduk']);
        }

        return DataTables::of($surat)
            ->addColumn('action', function ($row) {
                $user = auth()->user();
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<a href="' . route('surat.show', $row->id) . '" class="btn btn-info btn-sm">Detail</a>';
                
                // Print button for completed letters
                if ($row->status == 'Selesai') {
                    $btn .= '<a href="' . route('surat.print', $row->id) . '" class="btn btn-success btn-sm" target="_blank">Cetak</a>';
                }
                
                // Approval buttons based on role and status
                if ($user->isPetugas() && $row->status == 'Menunggu') {
                    $btn .= '<button class="btn btn-warning btn-sm approve-petugas-btn" data-id="' . $row->id . '">Proses</button>';
                    $btn .= '<button class="btn btn-danger btn-sm reject-btn" data-id="' . $row->id . '">Tolak</button>';
                }
                
                if ($user->isLurah() && $row->status == 'Diproses') {
                    $btn .= '<button class="btn btn-success btn-sm approve-lurah-btn" data-id="' . $row->id . '">Setujui</button>';
                    $btn .= '<button class="btn btn-danger btn-sm reject-btn" data-id="' . $row->id . '">Tolak</button>';
                }
                
                // Edit and delete for admin on pending letters
                if ($user->isAdmin() && $row->status == 'Menunggu') {
                    $btn .= '<a href="' . route('surat.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                    $btn .= '<button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">Hapus</button>';
                }
                
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('status_badge', function ($row) {
                return '<span class="badge ' . $row->status_badge . '">' . $row->status . '</span>';
            })
            ->editColumn('tanggal_pengajuan', function ($row) {
                return $row->formatted_tanggal_pengajuan;
            })
            ->rawColumns(['action', 'status_badge'])
            ->make(true);
    }

    public function create()
    {
        $jenis_surat = JenisSurat::active()->get();
        $penduduk = null;
        
        if (auth()->user()->isMember()) {
            $penduduk = auth()->user()->penduduk;
        }
        
        return view('surat.create', compact('jenis_surat', 'penduduk'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        $rules = [
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'keperluan' => 'required|string'
        ];
        
        // If user is warga (member), automatically use their NIK
        if ($user->isMember()) {
            $nik = $user->nik;
            if (!$nik) {
                return back()->with('error', 'Data penduduk Anda belum lengkap. Silakan hubungi petugas desa.');
            }
        } else {
            // For admin/petugas, require NIK input
            $rules['nik'] = 'required|exists:penduduk,nik';
            $nik = $request->nik;
        }
        
        $request->validate($rules);

        $data = [
            'user_id' => auth()->id(),
            'jenis_surat_id' => $request->jenis_surat_id,
            'nik' => $nik, // Use the determined NIK
            'keperluan' => $request->keperluan,
            'tanggal_pengajuan' => Carbon::now(),
            'data_tambahan' => $this->processAdditionalData($request)
        ];

        PengajuanSurat::create($data);

        return redirect()->route('surat.index')
            ->with('success', 'Pengajuan surat berhasil disubmit.');
    }

    public function show(PengajuanSurat $surat)
    {
        $this->authorize('view', $surat);
        
        $surat->load(['user', 'jenis_surat', 'penduduk', 'diproses_user']);
        
        return view('surat.show', compact('surat'));
    }

    public function edit(PengajuanSurat $surat)
    {
        $this->authorize('update', $surat);
        
        $jenis_surat = JenisSurat::active()->get();
        $penduduk = Penduduk::all();
        
        return view('surat.edit', compact('surat', 'jenis_surat', 'penduduk'));
    }

    public function update(Request $request, PengajuanSurat $surat)
    {
        $this->authorize('update', $surat);
        
        $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'nik' => 'required|exists:penduduk,nik',
            'keperluan' => 'required|string'
        ]);

        $data = [
            'jenis_surat_id' => $request->jenis_surat_id,
            'nik' => $request->nik,
            'keperluan' => $request->keperluan,
            'data_tambahan' => $this->processAdditionalData($request)
        ];

        $surat->update($data);

        return redirect()->route('surat.index')
            ->with('success', 'Data surat berhasil diupdate.');
    }

    public function destroy(PengajuanSurat $surat)
    {
        $this->authorize('delete', $surat);
        
        try {
            $surat->delete();
            return response()->json(['success' => true, 'message' => 'Data surat berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data surat.']);
        }
    }

    public function print(PengajuanSurat $surat)
    {
        $this->authorize('view', $surat);
        
        if ($surat->status != 'Selesai') {
            return redirect()->back()->with('error', 'Surat belum disetujui, tidak dapat dicetak.');
        }
        
        $surat->load(['user', 'jenis_surat', 'penduduk', 'lurah']);
        
        return view('surat.print-kuinsel', compact('surat'));
    }

    private function processAdditionalData(Request $request)
    {
        $additionalData = [];
        
        // Process additional data based on surat type
        $jenisSurat = JenisSurat::find($request->jenis_surat_id);
        
        switch ($jenisSurat->kode_surat) {
            case '474': // Surat Pindah
                $additionalData = [
                    'alamat_baru' => $request->alamat_baru,
                    'jumlah_keluarga' => $request->jumlah_keluarga
                ];
                break;
            case '474.3': // Surat Kematian
                $additionalData = [
                    'hari_meninggal' => $request->hari_meninggal,
                    'tanggal_meninggal' => $request->tanggal_meninggal,
                    'sebab_kematian' => $request->sebab_kematian,
                    'alamat_meninggal' => $request->alamat_meninggal
                ];
                break;
            case '503': // Surat Izin Usaha
                $additionalData = [
                    'nama_usaha' => $request->nama_usaha,
                    'jenis_usaha' => $request->jenis_usaha,
                    'alamat_usaha' => $request->alamat_usaha,
                    'keterangan_usaha' => $request->keterangan_usaha
                ];
                break;
        }
        
        return $additionalData;
    }

    // Methods for two-stage approval
    public function approvePetugas(Request $request, PengajuanSurat $surat)
    {
        // Only petugas can approve at first stage
        if (!auth()->user()->isPetugas()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!$surat->canBeProcessedByPetugas()) {
            return response()->json(['error' => 'Surat tidak dapat diproses'], 400);
        }

        $request->validate([
            'keterangan' => 'nullable|string'
        ]);

        $surat->approvePetugas(
            auth()->id(),
            $request->keterangan ?? 'Diproses oleh petugas'
        );

        return response()->json([
            'success' => true,
            'message' => 'Surat berhasil diproses oleh petugas. Menunggu persetujuan lurah.'
        ]);
    }

    public function approveLurah(Request $request, PengajuanSurat $surat)
    {
        // Only lurah can approve at second stage
        if (!auth()->user()->isLurah()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!$surat->canBeProcessedByLurah()) {
            return response()->json(['error' => 'Surat belum diproses petugas atau sudah selesai'], 400);
        }

        $request->validate([
            'keterangan' => 'nullable|string'
        ]);

        $surat->approveLurah(
            auth()->id(),
            $request->keterangan ?? 'Surat telah disetujui oleh lurah'
        );

        return response()->json([
            'success' => true,
            'message' => 'Surat berhasil disetujui dan telah selesai.'
        ]);
    }

    public function reject(Request $request, PengajuanSurat $surat)
    {
        // Both petugas and lurah can reject
        if (!auth()->user()->isPetugas() && !auth()->user()->isLurah()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'keterangan' => 'required|string'
        ]);

        $surat->reject(auth()->id(), $request->keterangan);

        return response()->json([
            'success' => true,
            'message' => 'Surat berhasil ditolak.'
        ]);
    }
}
