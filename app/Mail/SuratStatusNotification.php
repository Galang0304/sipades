<?php

namespace App\Mail;

use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuratStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $surat;
    public $status;
    public $recipient;
    public $keterangan;

    /**
     * Create a new message instance.
     *
     * @param PengajuanSurat $surat
     * @param string $status (approved_petugas, approved_lurah, rejected)
     * @param User $recipient
     * @param string $keterangan
     */
    public function __construct(PengajuanSurat $surat, $status, $recipient, $keterangan = null)
    {
        $this->surat = $surat;
        $this->status = $status;
        $this->recipient = $recipient;
        $this->keterangan = $keterangan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->getSubject();
        
        return $this->subject($subject)
                    ->view('emails.surat_notification')
                    ->with([
                        'surat' => $this->surat,
                        'status' => $this->status,
                        'recipient' => $this->recipient,
                        'keterangan' => $this->keterangan,
                        'title' => $subject
                    ]);
    }

    private function getSubject()
    {
        switch ($this->status) {
            case 'approved_petugas':
                return '[SIPADES] Pengajuan Surat Anda Telah Diproses Petugas';
            case 'approved_lurah':
                return '[SIPADES] Pengajuan Surat Anda Telah Disetujui Lurah';
            case 'rejected':
                return '[SIPADES] Pengajuan Surat Anda Ditolak';
            case 'new_for_lurah':
                return '[SIPADES] Ada Pengajuan Surat Baru Untuk Persetujuan';
            default:
                return '[SIPADES] Update Status Pengajuan Surat';
        }
    }
}
