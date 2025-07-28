<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuratStatusNotification;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_surats';

    protected $fillable = [
        'user_id',
        'jenis_surat_id',
        'nik',
        'keperluan',
        'data_tambahan',
        'status',
        'keterangan_status',
        'tanggal_pengajuan',
        'tanggal_diproses',
        'diproses_oleh',
        'tanggal_diproses_petugas',
        'diproses_oleh_petugas',
        'keterangan_petugas',
        'tanggal_diproses_lurah',
        'diproses_oleh_lurah',
        'keterangan_lurah'
    ];

    protected $casts = [
        'data_tambahan' => 'array',
        'tanggal_pengajuan' => 'datetime',
        'tanggal_diproses' => 'datetime',
        'tanggal_diproses_petugas' => 'datetime',
        'tanggal_diproses_lurah' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenis_surat()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'nik', 'nik');
    }

    public function diproses_user()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'diproses_oleh_petugas');
    }

    public function lurah()
    {
        return $this->belongsTo(User::class, 'diproses_oleh_lurah');
    }

    // Scopes
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'Menunggu');
    }

    public function scopeDiproses($query)
    {
        return $query->where('status', 'Diproses');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'Selesai');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'Ditolak');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Menunggu' => 'badge-info',
            'Diproses' => 'badge-warning',
            'Selesai' => 'badge-success',
            'Ditolak' => 'badge-danger'
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }

    public function getFormattedTanggalPengajuanAttribute()
    {
        return $this->tanggal_pengajuan->format('d/m/Y H:i');
    }

    // Methods
    public function approvePetugas($user_id, $keterangan = 'Diproses oleh petugas')
    {
        $this->update([
            'status' => 'Diproses',
            'keterangan_petugas' => $keterangan,
            'tanggal_diproses_petugas' => Carbon::now(),
            'diproses_oleh_petugas' => $user_id
        ]);

        // Send email to applicant
        try {
            Mail::to($this->user->email)->send(new SuratStatusNotification(
                $this, 
                'approved_petugas', 
                $this->user, 
                $keterangan
            ));
        } catch (\Exception $e) {
            \Log::error('Failed to send petugas approval email: ' . $e->getMessage());
        }

        // Send email to all lurah users
        try {
            $lurahUsers = \App\Models\User::whereHas('roles', function($query) {
                $query->where('name', 'lurah');
            })->get();

            foreach ($lurahUsers as $lurah) {
                Mail::to($lurah->email)->send(new SuratStatusNotification(
                    $this, 
                    'new_for_lurah', 
                    $lurah, 
                    'Pengajuan surat telah diproses petugas dan menunggu persetujuan Anda.'
                ));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send lurah notification email: ' . $e->getMessage());
        }
    }

    public function approveLurah($user_id, $keterangan = 'Surat telah disetujui')
    {
        $this->update([
            'status' => 'Selesai',
            'keterangan_lurah' => $keterangan,
            'tanggal_diproses_lurah' => Carbon::now(),
            'diproses_oleh_lurah' => $user_id,
            'tanggal_diproses' => Carbon::now(),
            'diproses_oleh' => $user_id
        ]);

        // Send email to applicant
        try {
            Mail::to($this->user->email)->send(new SuratStatusNotification(
                $this, 
                'approved_lurah', 
                $this->user, 
                $keterangan
            ));
        } catch (\Exception $e) {
            \Log::error('Failed to send lurah approval email: ' . $e->getMessage());
        }
    }

    public function reject($user_id, $keterangan)
    {
        $this->update([
            'status' => 'Ditolak',
            'keterangan_status' => $keterangan,
            'tanggal_diproses' => Carbon::now(),
            'diproses_oleh' => $user_id
        ]);

        // Send email to applicant
        try {
            Mail::to($this->user->email)->send(new SuratStatusNotification(
                $this, 
                'rejected', 
                $this->user, 
                $keterangan
            ));
        } catch (\Exception $e) {
            \Log::error('Failed to send rejection email: ' . $e->getMessage());
        }
    }

    public function approve($user_id, $keterangan = 'Surat telah disetujui')
    {
        // Jika sedang dalam status Diproses (untuk approval lurah)
        if ($this->status === 'Diproses') {
            $this->approveLurah($user_id, $keterangan);
        }
        // Jika sedang dalam status Menunggu (untuk approval petugas)
        elseif ($this->status === 'Menunggu') {
            $this->approvePetugas($user_id, $keterangan);
        }
    }

    // Helper methods
    public function canBeProcessedByPetugas()
    {
        return $this->status === 'Menunggu';
    }

    public function canBeProcessedByLurah()
    {
        return $this->status === 'Diproses';
    }

    public function isWaitingForPetugas()
    {
        return $this->status === 'Menunggu';
    }

    public function isWaitingForLurah()
    {
        return $this->status === 'Diproses';
    }
}
