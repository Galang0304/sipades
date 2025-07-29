@extends('layouts.app')

@section('title', $informasi->judul)

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-info-circle text-primary"></i> 
                    Detail Informasi
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('informasi.public') }}">Informasi</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <!-- Header Informasi -->
                        <div class="mb-3">
                            <span class="badge badge-info">{{ $informasi->kategori ?? 'Umum' }}</span>
                            <small class="text-muted float-right">
                                <i class="fas fa-calendar"></i> {{ $informasi->created_at->format('d F Y, H:i') }}
                            </small>
                        </div>
                        
                        <!-- Judul -->
                        <h2 class="mb-3">{{ $informasi->judul }}</h2>
                        
                        <!-- Gambar (jika ada) -->
                        @if($informasi->gambar)
                            <div class="text-center mb-4">
                                <img src="{{ $informasi->gambar_url }}" class="img-fluid rounded" alt="{{ $informasi->judul }}" style="max-height: 400px;">
                            </div>
                        @endif
                        
                        <!-- Konten -->
                        <div class="content-text">
                            {!! nl2br(e($informasi->konten ?? $informasi->deskripsi ?? '')) !!}
                        </div>
                        
                        <!-- Footer Info -->
                        <hr class="my-4">
                        <div class="row text-muted">
                            <div class="col-sm-6">
                                <small>
                                    <i class="fas fa-user"></i> 
                                    Dipublikasi oleh: 
                                    {{ $informasi->createdBy->name ?? $informasi->pembuat->name ?? 'Admin Kelurahan' }}
                                </small>
                            </div>
                            <div class="col-sm-6 text-right">
                                <small>
                                    <i class="fas fa-clock"></i> 
                                    {{ $informasi->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tombol Kembali -->
                <div class="mt-3">
                    <a href="{{ route('informasi.public') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Informasi
                    </a>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info"></i> Informasi Lainnya
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            $informasiLain = \App\Models\InformasiKelurahan::where('is_published', true)
                                                                        ->where('id', '!=', $informasi->id)
                                                                        ->orderBy('created_at', 'desc')
                                                                        ->limit(5)
                                                                        ->get();
                        @endphp
                        
                        @if(count($informasiLain) > 0)
                            @foreach($informasiLain as $item)
                                <div class="media mb-3">
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-1">
                                            <a href="{{ route('informasi.show', $item->id) }}" class="text-dark">
                                                {{ Str::limit($item->judul, 50) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar"></i> {{ $item->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr>
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted text-center">Tidak ada informasi lainnya</p>
                        @endif
                    </div>
                </div>
                
                <!-- Kontak Kelurahan -->
                <div class="card mt-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-phone"></i> Kontak Kelurahan
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Alamat:</strong></p>
                        <p class="small">JL. SIMPANG KUIN SELATAN RT.22 NO.01</p>
                        
                        <p class="mb-2"><strong>Kode Pos:</strong></p>
                        <p class="small">70128</p>
                        
                        <p class="mb-2"><strong>Email:</strong></p>
                        <p class="small">kelurahankuinsel@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.content-text {
    font-size: 16px;
    line-height: 1.6;
    text-align: justify;
}

.media {
    border-left: 3px solid #007bff;
    padding-left: 10px;
}

.media:hover {
    background-color: #f8f9fa;
    border-radius: 5px;
    padding: 10px;
    margin-left: -10px;
}
</style>
@endpush
