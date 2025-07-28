<?php

use Illuminate\Support\Facades\Mail;

// Test basic email functionality
try {
    Mail::raw('Test email dari SIPADES - ' . date('Y-m-d H:i:s'), function ($message) {
        $message->to('kelurahankuinsel@gmail.com')
               ->subject('Test Email SIPADES - ' . date('Y-m-d H:i:s'));
    });
    
    echo "✅ Email berhasil dikirim!\n";
    echo "Silakan cek email kelurahankuinsel@gmail.com\n";
    
} catch (Exception $e) {
    echo "❌ Error mengirim email: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
