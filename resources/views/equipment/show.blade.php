@extends('layouts.app')

@section('title', $equipment->name)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            @php
                // Gambar default berdasarkan kategori jika tidak ada gambar
                $categoryDefaultImages = [
                    'Tenda' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=800&q=80',
                    'Sleeping Bag' => 'https://images.unsplash.com/photo-1601342630314-8427c38bf5e6?w=800&q=80',
                    'Carrier' => 'https://images.unsplash.com/photo-1622260614153-03223fb72052?w=800&q=80',
                    'Peralatan Masak' => 'https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?w=800&q=80',
                    'Perlengkapan' => 'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=800&q=80',
                    'Pakaian' => 'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?w=800&q=80',
                ];
                $defaultImage = $categoryDefaultImages[$equipment->category->name] ?? 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=800&q=80';
            @endphp
            @if($equipment->image)
                <img src="{{ asset('storage/' . $equipment->image) }}" class="img-fluid rounded shadow" alt="{{ $equipment->name }}" style="width: 100%; object-fit: cover;">
            @else
                <img src="{{ $defaultImage }}" class="img-fluid rounded shadow" alt="{{ $equipment->name }}" style="width: 100%; object-fit: cover;">
            @endif
        </div>
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('equipment.index') }}">Alat</a></li>
                    <li class="breadcrumb-item active">{{ $equipment->name }}</li>
                </ol>
            </nav>
            
            <span class="badge bg-success mb-2">{{ $equipment->category->name }}</span>
            @if($equipment->condition == 'excellent')
                <span class="badge bg-info mb-2">Sangat Baik</span>
            @elseif($equipment->condition == 'good')
                <span class="badge bg-primary mb-2">Baik</span>
            @else
                <span class="badge bg-warning mb-2">Cukup</span>
            @endif
            
            <h2 class="mb-3">{{ $equipment->name }}</h2>
            
            <div class="rating mb-3">
                @php
                    $avgRating = $equipment->average_rating;
                @endphp
                @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star{{ $i <= $avgRating ? '-fill' : '' }} fs-5"></i>
                @endfor
                <span class="ms-2">({{ number_format($avgRating, 1) }} dari {{ $equipment->total_reviews }} ulasan)</span>
            </div>
            
            <div class="mb-4">
                <h3 class="text-success">Rp {{ number_format($equipment->price_per_day, 0, ',', '.') }} <small class="text-muted fs-6">/hari</small></h3>
            </div>
            
            <div class="mb-3">
                <strong>Stok Tersedia:</strong>
                <span class="badge {{ $equipment->available_stock > 0 ? 'bg-success' : 'bg-danger' }}">
                    {{ $equipment->available_stock }} unit
                </span>
            </div>
            
            <div class="mb-4">
                <h5>Deskripsi</h5>
                <p>{{ $equipment->description }}</p>
            </div>
            
            @auth
                @if(Auth::user()->isUser())
                    @if($equipment->available_stock > 0)
                        <a href="{{ route('rentals.create', $equipment->id) }}" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-cart-plus"></i> Sewa Sekarang
                        </a>
                    @else
                        <button class="btn btn-secondary btn-lg w-100" disabled>
                            Stok Tidak Tersedia
                        </button>
                    @endif
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">
                    Login untuk Menyewa
                </a>
            @endauth
        </div>
    </div>
    
    <!-- Reviews Section -->
    <div class="mt-5">
        <h3 class="mb-4">Ulasan Pelanggan</h3>
        @forelse($equipment->reviews as $review)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>{{ $review->user->name }}</strong>
                        <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                </div>
                <p class="mt-2 mb-0">{{ $review->comment }}</p>
            </div>
        </div>
        @empty
        <p class="text-muted">Belum ada ulasan untuk alat ini.</p>
        @endforelse
    </div>
    
    <!-- Related Equipment -->
    @if($relatedEquipment->count() > 0)
    <div class="mt-5">
        <h3 class="mb-4">Alat Serupa</h3>
        <div class="row">
            @foreach($relatedEquipment as $related)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @if($related->image)
                        <img src="{{ asset('storage/' . $related->image) }}" class="card-img-top" alt="{{ $related->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="card-title">{{ $related->name }}</h6>
                        <p class="text-success mb-2">Rp {{ number_format($related->price_per_day, 0, ',', '.') }}/hari</p>
                        <a href="{{ route('equipment.show', $related->id) }}" class="btn btn-sm btn-outline-primary w-100">Lihat</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
