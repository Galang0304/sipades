<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'email:test';
    protected $description = 'Test email dari kelurahankuinsel@gmail.com ke andiariegalang0@gmail.com';

    public function handle()
    {
        $this->info('Testing email configuration...');
        $this->info('From: kelurahankuinsel@gmail.com');
        $this->info('To: andiariegalang0@gmail.com');
        
        try {
            Mail::raw('Test email dari SIPADES - Email berfungsi dengan baik! Waktu: ' . now()->format('Y-m-d H:i:s'), function ($message) {
                $message->to('andiariegalang0@gmail.com')
                        ->from('kelurahankuinsel@gmail.com', 'Kelurahan Kuinsel')
                        ->subject('Test Email SIPADES - ' . now()->format('Y-m-d H:i:s'));
            });
            
            $this->info('✅ Email berhasil dikirim!');
            $this->info('Silakan cek inbox andiariegalang0@gmail.com');
            
        } catch (\Exception $e) {
            $this->error('❌ Gagal mengirim email:');
            $this->error($e->getMessage());
            
            // Tampilkan detail konfigurasi
            $this->info("\nKonfigurasi Email saat ini:");
            $this->info('MAIL_MAILER: ' . config('mail.default'));
            $this->info('MAIL_HOST: ' . config('mail.mailers.smtp.host'));
            $this->info('MAIL_PORT: ' . config('mail.mailers.smtp.port'));
            $this->info('MAIL_USERNAME: ' . config('mail.mailers.smtp.username'));
            $this->info('MAIL_ENCRYPTION: ' . config('mail.mailers.smtp.encryption'));
        }
    }
}
