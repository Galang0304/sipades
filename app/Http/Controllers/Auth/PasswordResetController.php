<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak ditemukan dalam sistem.'
        ]);

        // Generate token
        $token = Str::random(60);
        
        // Delete any existing password reset tokens for this email
        DB::table('password_resets')->where('email', $request->email)->delete();
        
        // Create new password reset token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now()
        ]);

        // Get user
        $user = User::where('email', $request->email)->first();

        // Send email
        try {
            $this->sendResetEmail($user, $token);
            
            return back()->with('status', 'Link reset password telah dikirim ke email Anda!');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email. Silakan coba lagi.']);
        }
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8'
        ], [
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.'
        ]);

        // Verify token
        $resetRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['token' => 'Token reset password tidak valid.']);
        }

        // Check if token is expired (24 hours)
        $tokenAge = Carbon::parse($resetRecord->created_at)->diffInHours(Carbon::now());
        if ($tokenAge > 24) {
            return back()->withErrors(['token' => 'Token reset password telah kadaluarsa.']);
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the reset token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }

    private function sendResetEmail($user, $token)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ], false));

        $emailData = [
            'name' => $user->name,
            'resetUrl' => $resetUrl,
            'expireTime' => '24 jam'
        ];

        Mail::send('emails.password-reset', $emailData, function($message) use ($user) {
            $message->to($user->email, $user->name);
            $message->subject('Reset Password - SIPADES');
        });
    }
}
