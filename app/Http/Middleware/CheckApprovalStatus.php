<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApprovalStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        // Skip check for non-authenticated users
        if (!$user) {
            return $next($request);
        }
        
        // Skip check for admin and lurah (they don't need approval)
        if ($user->hasRole(['admin', 'lurah'])) {
            return $next($request);
        }
        
        // Check if user is approved for warga/petugas
        if ($user->hasRole(['warga', 'petugas']) && !$user->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda belum disetujui oleh admin. Silakan hubungi administrator.');
        }
        
        return $next($request);
    }
}
