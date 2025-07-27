<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/test-email-page', function () {
    return view('test-email');
});

Route::get('/test-email-config', function () {
    try {
        echo "<h3>EMAIL CONFIGURATION TEST</h3>";
        echo "<p>FROM EMAIL: " . config('mail.from.address') . "</p>";
        echo "<p>FROM NAME: " . config('mail.from.name') . "</p>";
        echo "<p>SMTP USERNAME: " . config('mail.mailers.smtp.username') . "</p>";
        echo "<p>SMTP HOST: " . config('mail.mailers.smtp.host') . "</p>";
        echo "<p>SMTP PORT: " . config('mail.mailers.smtp.port') . "</p>";
        
        echo "<hr>";
        echo "<h3>SENDING TEST EMAIL...</h3>";
        
        Mail::raw('Test email dari SIPADES - Konfigurasi sudah benar!', function ($message) {
            $message->to('andiariegalang0@gmail.com')
                    ->subject('Test Email SIPADES - Konfigurasi Baru');
        });
        
        echo "<p style='color: green;'>✓ EMAIL BERHASIL DIKIRIM!</p>";
        echo "<p>Cek inbox: andiariegalang0@gmail.com</p>";
        echo "<p>Jika tidak ada di inbox, cek folder spam/junk</p>";
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ ERROR: " . $e->getMessage() . "</p>";
        
        if (strpos($e->getMessage(), 'authentication') !== false || 
            strpos($e->getMessage(), 'username') !== false) {
            echo "<p><strong>Kemungkinan masalah:</strong></p>";
            echo "<ul>";
            echo "<li>App Password Gmail tidak valid</li>";
            echo "<li>2-Factor Authentication belum aktif di akun Gmail</li>";
            echo "<li>Email bukan Gmail atau pengaturan berbeda</li>";
            echo "</ul>";
        }
    }
    
    return '';
});

// Test password reset tanpa throttling
Route::post('/test-reset-password', function (\Illuminate\Http\Request $request) {
    try {
        $email = $request->email;
        
        // Cek user exists
        $user = \App\Models\User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['error' => 'Email tidak ditemukan'], 404);
        }
        
        echo "<h3>TESTING PASSWORD RESET UNTUK: {$email}</h3>";
        
        // Send password reset link
        $response = \Illuminate\Support\Facades\Password::sendResetLink(
            ['email' => $email]
        );
        
        if ($response == \Illuminate\Support\Facades\Password::RESET_LINK_SENT) {
            echo "<p style='color: green;'>✓ EMAIL RESET PASSWORD BERHASIL DIKIRIM!</p>";
            echo "<p>Cek inbox: {$email}</p>";
        } else {
            echo "<p style='color: red;'>❌ Gagal kirim email reset password</p>";
            echo "<p>Response: {$response}</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ ERROR: " . $e->getMessage() . "</p>";
    }
    
    return '';
});
