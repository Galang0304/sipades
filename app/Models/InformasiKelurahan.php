<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiKelurahan extends Model
{
    use HasFactory;

    protected $table = 'informasi_kelurahan';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'dibuat_oleh',
        'is_published',
        'tanggal_publish'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'tanggal_publish' => 'datetime'
    ];

    // Relationships
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('tanggal_publish', 'desc');
    }

    // Accessors
    public function getGambarUrlAttribute()
    {
        return $this->gambar ? asset('storage/informasi/' . $this->gambar) : null;
    }

    public function getFormattedTanggalPublishAttribute()
    {
        return $this->tanggal_publish->format('d/m/Y H:i');
    }

    public function getExcerptAttribute()
    {
        return substr(strip_tags($this->deskripsi), 0, 150) . '...';
    }
}
