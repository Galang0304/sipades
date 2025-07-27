<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSurat;
use Yajra\DataTables\Facades\DataTables;

class ValidasiSuratController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:validate-surat');
    }

    public function index()
    {
        return view('validasi.index');
    }

    public function data()
    {
        $surat = PengajuanSurat::with(['user', 'jenis_surat', 'penduduk'])
            ->where('status', 'Diproses')
            ->whereNotNull('tanggal_diproses_petugas')
            ->whereNull('tanggal_diproses_lurah');

        return DataTables::of($surat)
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<a href="' . route('validasi.show', $row->id) . '" class="btn btn-info btn-sm">Detail</a>';
                $btn .= '<button class="btn btn-success btn-sm approve-btn" data-id="' . $row->id . '">Setujui</button>';
                $btn .= '<button class="btn btn-danger btn-sm reject-btn" data-id="' . $row->id . '">Tolak</button>';
                $btn .= '</div>';
                return $btn;
            })
            ->editColumn('tanggal_pengajuan', function ($row) {
                return $row->formatted_tanggal_pengajuan;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show(PengajuanSurat $surat)
    {
        $surat->load(['user', 'jenis_surat', 'penduduk']);
        
        return view('validasi.show', compact('surat'));
    }

    public function approve(Request $request, PengajuanSurat $surat)
    {
        $request->validate([
            'keterangan' => 'nullable|string'
        ]);

        $keterangan = $request->keterangan ?: 'Surat telah disetujui';
        
        $surat->approve(auth()->id(), $keterangan);

        return response()->json([
            'success' => true, 
            'message' => 'Surat berhasil disetujui.'
        ]);
    }

    public function reject(Request $request, PengajuanSurat $surat)
    {
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
