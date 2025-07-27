<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanSurat;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Share notification counts with all views
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $notifications = [];
                
                // For Petugas - count surat yang status 'Menunggu' (belum diproses petugas)
                if ($user->hasRole('petugas')) {
                    $notifications['surat_pending_petugas'] = PengajuanSurat::where('status', 'Menunggu')
                        ->count();
                }
                
                // For Lurah - count surat yang status 'Diproses' (sudah diproses petugas, menunggu lurah)
                if ($user->hasRole('lurah')) {
                    $notifications['surat_pending_lurah'] = PengajuanSurat::where('status', 'Diproses')
                        ->whereNotNull('tanggal_diproses_petugas')
                        ->whereNull('tanggal_diproses_lurah')
                        ->count();
                }
                
                $view->with('notifications', $notifications);
            }
        });
    }
}
