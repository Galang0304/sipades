<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use Yajra\DataTables\Facades\DataTables;

class PendudukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Temporarily disable role middleware for testing
        // $this->middleware('role:admin|petugas');
    }

    public function index()
    {
        return view('penduduk.index');
    }

    public function data()
    {
        $penduduk = Penduduk::query();

        return DataTables::of($penduduk)
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<a href="' . route('penduduk.show', $row->id) . '" class="btn btn-info btn-sm">Detail</a>';
                $btn .= '<a href="' . route('penduduk.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                $btn .= '<button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">Hapus</button>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('umur', function ($row) {
                return $row->umur . ' tahun';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('penduduk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16|unique:penduduk',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_kawin' => 'nullable|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
        ]);

        Penduduk::create($request->all());

        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function show(Penduduk $penduduk)
    {
        return view('penduduk.show', compact('penduduk'));
    }

    public function edit(Penduduk $penduduk)
    {
        return view('penduduk.edit', compact('penduduk'));
    }

    public function update(Request $request, Penduduk $penduduk)
    {
        $request->validate([
            // Data akun (users table)
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . optional($penduduk->user)->id,
            'password' => 'nullable|string|min:8|confirmed',
            
            // Data penduduk (semua data pribadi dan alamat)
            'nik' => 'required|string|size:16|unique:penduduk,nik,' . $penduduk->id,
            'no_kk' => 'required|string|size:16',
            'no_tlp' => 'required|string',
            'status_penduduk' => 'required|in:Tetap,Sementara',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'nama_lengkap' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'status_perkawinan' => 'nullable|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'pekerjaan' => 'nullable|string|max:255',
            'foto_kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Update users table (hanya data akun)
        $user = $penduduk->user;
        if ($user) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'nik' => $request->nik,
            ];
            
            // Only update password if provided
            if ($request->filled('password')) {
                $userData['password'] = bcrypt($request->password);
            }
            
            $user->update($userData);
        }

        // Handle foto KK upload
        $foto_kk = $penduduk->foto_kk;
        if ($request->hasFile('foto_kk')) {
            // Delete old file if exists
            if ($foto_kk && \Storage::disk('public')->exists($foto_kk)) {
                \Storage::disk('public')->delete($foto_kk);
            }
            
            // Store new file
            $file = $request->file('foto_kk');
            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '', $file->getClientOriginalName());
            $foto_kk = $file->storeAs('foto_kk', $fileName, 'public');
        }

        // Update penduduk table (semua data lengkap)
        $pendudukData = [
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'nama_lengkap' => $request->nama_lengkap ?? $request->name,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'no_tlp' => $request->no_tlp,
            'foto_kk' => $foto_kk,
            'agama' => $request->agama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status_perkawinan' => $request->status_perkawinan,
            'pekerjaan' => $request->pekerjaan,
            'status_penduduk' => $request->status_penduduk,
        ];

        $penduduk->update($pendudukData);

        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil diupdate.');
    }

    public function destroy(Penduduk $penduduk)
    {
        try {
            // First delete associated user if exists
            if ($penduduk->user) {
                $penduduk->user->delete();
            }
            
            // Then delete the penduduk record
            $penduduk->delete();
            
            return response()->json(['success' => true, 'message' => 'Data penduduk dan akun terkait berhasil dihapus.']);
        } catch (\Exception $e) {
            \Log::error('Error deleting penduduk: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data. Data mungkin masih digunakan.']);
        }
    }

    public function print()
    {
        $penduduk = Penduduk::orderBy('nama_lengkap', 'asc')->get();
        
        return view('penduduk.cetak', compact('penduduk'));
    }
}
