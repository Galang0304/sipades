<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|petugas');
    }

    public function index()
    {
        return view('users.index');
    }

    public function data()
    {
        try {
            $users = User::select(['id', 'name', 'email', 'nik', 'is_active', 'is_pending', 'created_at'])
                        ->with('roles')
                        ->where('id', '!=', auth()->id());

            return DataTables::of($users)
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group" role="group">';
                    $btn .= '<a href="' . route('users.show', $row->id) . '" class="btn btn-info btn-sm">Detail</a>';
                    $btn .= '<a href="' . route('users.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                    $btn .= '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">Hapus</button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->addColumn('role', function ($row) {
                    return $row->roles->pluck('name')->implode(', ') ?: 'No Role';
                })
                ->addColumn('status', function ($row) {
                    if ($row->is_pending) {
                        return '<span class="badge badge-warning">Pending</span>';
                    } elseif ($row->is_active) {
                        return '<span class="badge badge-success">Aktif</span>';
                    } else {
                        return '<span class="badge badge-danger">Tidak Aktif</span>';
                    }
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        } catch (\Exception $e) {
            \Log::error('DataTable Error: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nik' => 'required|string|size:16|unique:users,nik',
            'no_kk' => 'required|string|size:16',
            'alamat' => 'required|string|max:500',
            'rw' => 'required|string|max:3',
            'rt' => 'required|string|max:3',
            'no_tlp' => 'required|string|max:15',
            'status_penduduk' => 'required|in:pindahan,penduduk_tetap,pendatang',
            'foto_kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['is_active'] = true;
        $data['is_pending'] = false;

        // Handle foto_kk upload
        if ($request->hasFile('foto_kk')) {
            $data['foto_kk'] = $request->file('foto_kk')->store('foto_kk', 'public');
        }

        $user = User::create($data);
        $user->assignRole('user');

        return redirect()->route('users.index')
            ->with('success', 'Data user berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'nik' => 'required|string|size:16|unique:users,nik,' . $user->id,
            'no_kk' => 'required|string|size:16',
            'alamat' => 'required|string|max:500',
            'rw' => 'required|string|max:3',
            'rt' => 'required|string|max:3',
            'no_tlp' => 'required|string|max:15',
            'status_penduduk' => 'required|in:pindahan,penduduk_tetap,pendatang',
            'password' => 'nullable|string|min:8|confirmed',
            'foto_kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->except(['password', 'password_confirmation']);

        // Handle password update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle foto_kk upload
        if ($request->hasFile('foto_kk')) {
            // Delete old file if exists
            if ($user->foto_kk && Storage::disk('public')->exists($user->foto_kk)) {
                Storage::disk('public')->delete($user->foto_kk);
            }
            $data['foto_kk'] = $request->file('foto_kk')->store('foto_kk', 'public');
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Data user berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        try {
            // Delete foto_kk file if exists
            if ($user->foto_kk && Storage::disk('public')->exists($user->foto_kk)) {
                Storage::disk('public')->delete($user->foto_kk);
            }
            
            $user->delete();
            
            return response()->json(['success' => true, 'message' => 'Data user berhasil dihapus.']);
        } catch (\Exception $e) {
            \Log::error('Error deleting user: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data.']);
        }
    }
}
