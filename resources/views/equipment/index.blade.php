@extends('layouts.app')

@section('title', 'Alat Camping')

@section('styles')
<style>
    .equipment-header {
        background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 44, 0.8)),
                    url('https://images.unsplash.com/photo-1487730116645-74489c95b41b?w=1600&q=80') center/cover;
        padding: 60px 0;
        color: white;
        margin-bottom: 30px;
    }
</style>
@endsection

@section('content')
<div class="equipment-header">
    <div class="container">
        <h2 class="display-5 fw-bold mb-3">🏕️ Daftar Alat Camping</h2>
        <p class="lead">Temukan peralatan camping terbaik untuk petualangan Anda</p>
    </div>
</div>

<div class="container py-4">
    
    <div class="row mb-4">
        <div class="col-md-8">
            <form action="{{ route('equipment.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari alat..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <form action="{{ route('equipment.index') }}" method="GET">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($equipments as $equipment)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @php
                    // Gambar default berdasarkan kategori jika tidak ada gambar
                    $categoryDefaultImages = [
                        'Tenda' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=600&q=80',
                        'Sleeping Bag' => 'https://images.unsplash.com/photo-1601342630314-8427c38bf5e6?w=600&q=80',
                        'Carrier' => 'https://images.unsplash.com/photo-1622260614153-03223fb72052?w=600&q=80',
                        'Peralatan Masak' => 'https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?w=600&q=80',
                        'Perlengkapan' => 'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=600&q=80',
                        'Pakaian' => 'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?w=600&q=80',
                    ];
                    $defaultImage = $categoryDefaultImages[$equipment->category->name] ?? 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=600&q=80';
                @endphp
                @if($equipment->image)
                    <img src="{{ asset('storage/' . $equipment->image) }}" class="card-img-top" alt="{{ $equipment->name }}" style="height: 250px; object-fit: cover;">
                @else
                    <img src="{{ $defaultImage }}" class="card-img-top" alt="{{ $equipment->name }}" style="height: 250px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <span class="badge bg-success mb-2">{{ $equipment->category->name }}</span>
                    @if($equipment->condition == 'excellent')
                        <span class="badge bg-info mb-2">Sangat Baik</span>
                    @elseif($equipment->condition == 'good')
                        <span class="badge bg-primary mb-2">Baik</span>
                    @else
                        <span class="badge bg-warning mb-2">Cukup</span>
                    @endif
                    <h5 class="card-title">{{ $equipment->name }}</h5>
                    <div class="rating mb-2">
                        @php
                            $avgRating = $equipment->average_rating;
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $avgRating ? '-fill' : '' }}"></i>
                        @endfor
                        <small class="text-muted">({{ $equipment->total_reviews }} ulasan)</small>
                    </div>
                    <p class="text-muted">{{ Str::limit($equipment->description, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <strong class="text-success fs-5">Rp {{ number_format($equipment->price_per_day, 0, ',', '.') }}</strong>
                            <small class="text-muted">/hari</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="bi bi-box"></i> Stok tersedia: 
                            <strong class="{{ $equipment->available_stock > 0 ? 'text-success' : 'text-danger' }}">
                                {{ $equipment->available_stock }}
                            </strong>
                        </small>
                    </div>
                    
                    <div class="d-grid gap-2">
                        @auth
                            @if(Auth::user()->isUser())
                                @if($equipment->available_stock > 0)
                                    <a href="{{ route('rentals.create', $equipment->id) }}" class="btn btn-success">
                                        <i class="bi bi-cart-plus"></i> Sewa Sekarang
                                    </a>
                                    <a href="{{ route('equipment.show', $equipment->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i> Lihat Detail
                                    </a>
                                @else
                                    <button class="btn btn-secondary" disabled>
                                        Stok Habis
                                    </button>
                                    <a href="{{ route('equipment.show', $equipment->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i> Lihat Detail
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('equipment.show', $equipment->id) }}" class="btn btn-primary">
                                    <i class="bi bi-eye"></i> Lihat Detail
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-success">
                                <i class="bi bi-lock"></i> Login untuk Menyewa
                            </a>
                            <a href="{{ route('equipment.show', $equipment->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                Tidak ada alat yang ditemukan.
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $equipments->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
