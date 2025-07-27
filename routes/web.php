<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\ValidasiSuratController;

use App\Http\Controllers\Auth\PasswordResetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Test routes untuk email
require __DIR__ . '/test_email.php';

// Debug route
Route::get('/debug-dashboard', function () {
    $user = auth()->user();
    if (!$user) {
        return 'User not authenticated';
    }
    
    return [
        'user' => $user->toArray(),
        'roles' => $user->roles->pluck('name'),
        'has_roles' => $user->roles->count(),
        'is_admin' => $user->isAdmin(),
        'is_lurah' => $user->isLurah(),
        'is_petugas' => $user->isPetugas(),
        'is_member' => $user->isMember()
    ];
})->middleware('auth');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Authentication Routes
Auth::routes();

// Test password reset without throttling (for development)
Route::get('test-password-reset', function() {
    return view('test-password-reset');
})->name('test.password.reset');

Route::post('test-password-email', function(\Illuminate\Http\Request $request) {
    $request->validate([
        'email' => 'required|email|exists:users,email'
    ]);
    
    return back()->with('status', 'Link reset password berhasil dikirim! (Test Mode)');
})->name('test.password.email');

// Custom Password Reset Routes (commented out - using default Auth::routes())
// Route::get('password/reset', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
// Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
// Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
// Route::post('password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::post('/profile/upload-kk', function(\Illuminate\Http\Request $request) {
        $request->validate([
            'foto_kk' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);
        
        $user = auth()->user();
        
        // Delete old file if exists
        if ($user->foto_kk) {
            \Storage::disk('public')->delete($user->foto_kk);
        }
        
        // Store new file
        $file = $request->file('foto_kk');
        $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '', $file->getClientOriginalName());
        $path = $file->storeAs('foto_kk', $fileName, 'public');
        
        // Update user record
        $user->update(['foto_kk' => $path]);
        
        return redirect()->back()->with('success', 'Foto Kartu Keluarga berhasil diupload!');
    })->name('profile.upload-kk');
    
    // Test simple dashboard
    Route::get('/test-dashboard', function() {
        return view('dashboard.penduduk', [
            'stats' => ['my_surat' => 0],
            'my_surat' => collect(),
            'informasi' => collect()
        ]);
    });

    // Admin and Petugas routes for user approval
    Route::middleware(['role:admin|petugas'])->group(function () {
        // User Approval Routes (accessible by admin and petugas)
        Route::get('user-approval', [\App\Http\Controllers\Admin\UserApprovalController::class, 'index'])->name('user-approval.index');
        Route::post('user-approval/{user}/approve', [\App\Http\Controllers\Admin\UserApprovalController::class, 'approve'])->name('user-approval.approve');
        Route::post('user-approval/{user}/reject', [\App\Http\Controllers\Admin\UserApprovalController::class, 'reject'])->name('user-approval.reject');
        Route::get('user-approval/{user}', [\App\Http\Controllers\Admin\UserApprovalController::class, 'show'])->name('user-approval.show');
    });

    // Admin only routes  
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // User Approval Routes with admin prefix
        Route::get('user-approval', [\App\Http\Controllers\Admin\UserApprovalController::class, 'index'])->name('user-approval.index');
        Route::post('user-approval/{user}/approve', [\App\Http\Controllers\Admin\UserApprovalController::class, 'approve'])->name('user-approval.approve');
        Route::post('user-approval/{user}/reject', [\App\Http\Controllers\Admin\UserApprovalController::class, 'reject'])->name('user-approval.reject');
        Route::get('user-approval/{user}', [\App\Http\Controllers\Admin\UserApprovalController::class, 'show'])->name('user-approval.show');

        // Role Management Routes
        Route::get('roles', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index');
        Route::get('roles/create', [\App\Http\Controllers\Admin\RoleController::class, 'create'])->name('roles.create');
        Route::post('roles', [\App\Http\Controllers\Admin\RoleController::class, 'store'])->name('roles.store');
        Route::post('roles/{user}/assign', [\App\Http\Controllers\Admin\RoleController::class, 'assignRole'])->name('roles.assign');
        Route::delete('roles/{user}', [\App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('roles.destroy');
    });

    // Protected routes with approval check
    Route::middleware(['check.approval'])->group(function () {
        // User Management (for admin and petugas)
        Route::middleware(['role:admin|petugas'])->group(function () {
            Route::resource('users', \App\Http\Controllers\UserController::class);
            Route::get('users-data', [\App\Http\Controllers\UserController::class, 'data'])->name('users.data');
        });

        // Penduduk Management (temporarily allow all authenticated users)
        Route::resource('penduduk', PendudukController::class);
        Route::get('penduduk-data', [PendudukController::class, 'data'])->name('penduduk.data');

        // Surat Management
        Route::resource('surat', PengajuanSuratController::class);
        Route::get('surat-data', [PengajuanSuratController::class, 'data'])->name('surat.data');
        Route::get('surat/{surat}/print', [PengajuanSuratController::class, 'print'])->name('surat.print');
        
        // Two-stage approval routes
        Route::post('surat/{surat}/approve-petugas', [PengajuanSuratController::class, 'approvePetugas'])->name('surat.approve.petugas');
        Route::post('surat/{surat}/approve-lurah', [PengajuanSuratController::class, 'approveLurah'])->name('surat.approve.lurah');
        Route::post('surat/{surat}/reject', [PengajuanSuratController::class, 'reject'])->name('surat.reject');

        // Validasi Surat (temporarily allow all authenticated users)
        Route::get('validasi', [ValidasiSuratController::class, 'index'])->name('validasi.index');
        Route::get('validasi-data', [ValidasiSuratController::class, 'data'])->name('validasi.data');
        Route::get('validasi/{surat}', [ValidasiSuratController::class, 'show'])->name('validasi.show');
        Route::post('validasi/{surat}/approve', [ValidasiSuratController::class, 'approve'])->name('validasi.approve');
        Route::post('validasi/{surat}/reject', [ValidasiSuratController::class, 'reject'])->name('validasi.reject');
    });
});
