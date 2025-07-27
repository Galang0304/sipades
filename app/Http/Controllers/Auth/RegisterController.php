<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nik' => ['required', 'string', 'size:16', 'unique:users,nik', 'regex:/^[0-9]{16}$/'],
            'no_kk' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/'],
            'alamat' => ['required', 'string', 'max:500'],
            'rw' => ['required', 'string', 'max:3', 'regex:/^[0-9]{1,3}$/'],
            'rt' => ['required', 'string', 'max:3', 'regex:/^[0-9]{1,3}$/'],
            'no_tlp' => ['required', 'string', 'max:15', 'regex:/^[0-9+\-\s]{10,15}$/'],
            'status_penduduk' => ['required', 'in:pindahan,penduduk_tetap,pendatang'],
            'foto_kk' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        try {
            \Log::info('Starting user registration for: ' . $data['email']);
            
            // Check if NIK already exists in penduduk table
            $existingPenduduk = \App\Models\Penduduk::where('nik', $data['nik'])->first();
            
            if (!$existingPenduduk) {
                // Create data penduduk FIRST before creating user
                \Log::info('Creating new penduduk record for NIK: ' . $data['nik']);
                $penduduk = \App\Models\Penduduk::create([
                    'nik' => $data['nik'],
                    'nama_lengkap' => $data['name'],
                    'tempat_lahir' => $data['tempat_lahir'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
                    'jenis_kelamin' => $data['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan',
                    'alamat' => $data['alamat'] . ' RT/RW: ' . $data['rt'] . '/' . $data['rw'],
                    'agama' => $data['agama'],
                    'status_perkawinan' => $data['status_perkawinan'],
                    'pekerjaan' => $data['pekerjaan'],
                    'status_penduduk' => 'Tetap'
                ]);
                \Log::info('Penduduk created successfully with ID: ' . $penduduk->id);
            } else {
                \Log::info('Using existing penduduk record for NIK: ' . $data['nik']);
            }

            // Handle foto_kk upload if present
            $fotoKkPath = null;
            if (isset($data['foto_kk']) && $data['foto_kk'] instanceof \Illuminate\Http\UploadedFile) {
                $file = $data['foto_kk'];
                $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '', $file->getClientOriginalName());
                $fotoKkPath = $file->storeAs('foto_kk', $fileName, 'public');
                \Log::info('Foto KK uploaded: ' . $fotoKkPath);
            }

            // Create user dengan NIK yang sudah ada di tabel penduduk
            \Log::info('Creating user record');
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'nik' => $data['nik'],
                'no_kk' => $data['no_kk'],
                'alamat' => $data['alamat'],
                'rw' => $data['rw'],
                'rt' => $data['rt'],
                'no_tlp' => $data['no_tlp'],
                'status_penduduk' => $data['status_penduduk'],
                'foto_kk' => $fotoKkPath,
                'email_verified_at' => now(), // Auto verify email for now
                'is_active' => false, // Inactive until approved
                'is_pending' => true, // Pending approval
            ]);
            \Log::info('User created successfully with ID: ' . $user->id);

            // Assign 'user' role to new registrants
            $user->assignRole('user');
            \Log::info('Role assigned to user: ' . $user->id);

            return $user;
        } catch (\Exception $e) {
            \Log::error('Registration Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return a more user-friendly error
            throw new \Exception('Terjadi kesalahan saat mendaftar. Silakan coba lagi atau hubungi administrator.');
        }
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        // Logout user karena harus menunggu approval
        auth()->logout();
        
        return redirect()->route('login')->with('status', 
            'Pendaftaran berhasil! Akun Anda sedang menunggu persetujuan dari admin. ' .
            'Silakan tunggu konfirmasi melalui email atau hubungi admin kelurahan untuk informasi lebih lanjut.'
        );
    }
}
