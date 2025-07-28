<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Mail;

// Load Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Testing email configuration...\n";
    echo "From: " . config('mail.from.address') . "\n";
    echo "SMTP Host: " . config('mail.mailers.smtp.host') . "\n";
    echo "SMTP Port: " . config('mail.mailers.smtp.port') . "\n";
    echo "Username: " . config('mail.mailers.smtp.username') . "\n";
    echo "\n";

    // Send test email
    Mail::raw('Test email dari SIPADES Laravel App. Jika Anda menerima email ini, konfigurasi SMTP berhasil!', function ($message) {
        $message->to('kelurahankuinsel@gmail.com')
                ->subject('Test Email SIPADES - ' . date('Y-m-d H:i:s'));
    });

    echo "✅ Email berhasil dikirim!\n";
    echo "Silakan cek email Anda (termasuk folder spam).\n";

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Detail: " . $e->getTraceAsString() . "\n";
}
