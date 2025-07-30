@extends('layouts.app')

@section('title', 'Informasi Kelurahan')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-info-circle text-primary"></i> 
                    Informasi Kelurahan
                </h1>
                <p class="text-muted mb-0">Informasi terbaru dari Kelurahan Kuin Selatan</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Informasi</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        @if(count($informasi) > 0)
            <div class="row">
                @foreach($informasi as $item)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($item->gambar)
                            <img src="{{ $item->gambar_url }}" class="card-img-top" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-primary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-info-circle fa-3x text-white"></i>
                            </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge badge-info">{{ $item->kategori ?? 'Umum' }}</span>
                                <small class="text-muted float-right">
                                    {{ $item->created_at->format('d/m/Y') }}
                                </small>
                            </div>
                            
                            <h5 class="card-title">{{ $item->judul }}</h5>
                            
                            <p class="card-text flex-grow-1">
                                {{ Str::limit($item->konten ?? $item->deskripsi ?? '', 120) }}
                            </p>
                            
                            <div class="mt-auto">
                                <a href="{{ route('informasi.public.show', $item->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination jika diperlukan -->
            <div class="d-flex justify-content-center">
                {{-- {{ $informasi->links() }} --}}
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum Ada Informasi</h4>
                    <p class="text-muted">Belum ada informasi terbaru dari kelurahan saat ini.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
}

.card-img-top {
    border-radius: 0.375rem 0.375rem 0 0;
}

.badge {
    font-size: 0.75em;
}
</style>
@endpush
