<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::whereIn('name', ['lurah', 'petugas'])->get();
        $users = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['lurah', 'petugas']);
        })->get();

        return view('admin.roles.index', [
            'title' => 'Manajemen Role Petugas & Lurah',
            'roles' => $roles,
            'users' => $users
        ]);
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:lurah,petugas'
        ]);

        // Remove existing lurah/petugas role if any
        $user->removeRole('lurah');
        $user->removeRole('petugas');

        // Assign new role
        $user->assignRole($request->role);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil diubah!');
    }

    public function create()
    {
        return view('admin.roles.create', [
            'title' => 'Tambah User Baru'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:lurah,petugas'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_active' => true,
            'is_pending' => false
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.roles.index')
            ->with('success', 'User baru berhasil ditambahkan!');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Tidak dapat menghapus akun admin!');
        }

        $user->roles()->detach();
        $user->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'User berhasil dihapus!');
    }
}
