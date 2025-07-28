<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Penduduk;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = auth()->user();
        $penduduk = Penduduk::where('nik', $user->nik)->first();
        
        return view('profile.edit', compact('user', 'penduduk'));
    }

    /**
     * Update the profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $penduduk = Penduduk::where('nik', $user->nik)->first();

        $request->validate([
            // Data akun
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            
            // Data pribadi (jika ada data penduduk)
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'status_perkawinan' => 'nullable|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'pekerjaan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:3',
            'rw' => 'nullable|string|max:3',
            'no_tlp' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Update data user (akun)
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Handle foto profil upload
        if ($request->hasFile('foto_profil')) {
            // Delete old file if exists
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            
            // Store new file
            $file = $request->file('foto_profil');
            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '', $file->getClientOriginalName());
            $userData['foto_profil'] = $file->storeAs('foto_profil', $fileName, 'public');
        }

        $user->update($userData);

        // Update data penduduk jika ada
        if ($penduduk) {
            $pendudukData = [
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_perkawinan' => $request->status_perkawinan,
                'agama' => $request->agama,
                'pekerjaan' => $request->pekerjaan,
                'alamat' => $request->alamat,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'no_tlp' => $request->no_tlp,
            ];

            // Handle foto KK upload
            if ($request->hasFile('foto_kk')) {
                // Delete old file if exists
                if ($penduduk->foto_kk && Storage::disk('public')->exists($penduduk->foto_kk)) {
                    Storage::disk('public')->delete($penduduk->foto_kk);
                }
                
                // Store new file
                $file = $request->file('foto_kk');
                $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '', $file->getClientOriginalName());
                $pendudukData['foto_kk'] = $file->storeAs('foto_kk', $fileName, 'public');
            }

            $penduduk->update($pendudukData);
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Profile berhasil diupdate!');
    }
}
