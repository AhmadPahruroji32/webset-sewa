@extends('layouts.app')

@section('title', 'Beranda')

@section('styles')
<style>
    .hero-section {
        background: linear-gradient(rgba(45, 80, 22, 0.7), rgba(45, 80, 22, 0.8)), 
                    url('https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=1600&q=80') center/cover no-repeat;
        min-height: 500px;
        display: flex;
        align-items: center;
        position: relative;
    }
    
    .hero-section::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100px;
        background: linear-gradient(to bottom, transparent, #f8f9fa);
    }
    
    .category-section {
        background: linear-gradient(to bottom, #ffffff, #f8f9fa);
    }
    
    .equipment-section {
        background: linear-gradient(rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.95)),
                    url('https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=1600&q=80') center/cover fixed;
    }
    
    .features-section {
        background: linear-gradient(rgba(45, 80, 22, 0.05), rgba(74, 124, 44, 0.05)),
                    url('https://images.unsplash.com/photo-1501594907352-04cda38ebc29?w=1600&q=80') center/cover fixed;
        padding: 80px 0;
    }
    
    .features-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .category-card-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 15px 15px 0 0;
    }
    
    .category-icon-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(255, 255, 255, 0.95);
        border-radius: 50%;
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<div class="hero-section text-white">
    <div class="container position-relative" style="z-index: 1;">
        <div class="row align-items-center">
            <div class="col-md-8 mx-auto text-center">
                <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown">
                    🏕️ Sewa Alat Camping & Naik Gunung
                </h1>
                <p class="lead mb-4 fs-4">
                    Jelajahi keindahan alam dengan perlengkapan camping terbaik. 
                    Solusi terpercaya untuk petualangan Anda ke gunung dan hutan.
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('equipment.index') }}" class="btn btn-light btn-lg px-5">
                        <i class="bi bi-search"></i> Lihat Peralatan
                    </a>
                    @guest
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5">
                        <i class="bi bi-person-plus"></i> Daftar Sekarang
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="category-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Kategori Peralatan</h2>
            <p class="text-muted">Pilih kategori sesuai kebutuhan petualangan Anda</p>
        </div>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
                    @php
                        // Gambar kategori sesuai nama
                        $categoryImages = [
                            'Tenda' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=600&q=80',
                            'Sleeping Bag' => 'https://images.unsplash.com/photo-1601342630314-8427c38bf5e6?w=600&q=80',
                            'Carrier' => 'https://images.unsplash.com/photo-1622260614153-03223fb72052?w=600&q=80',
                            'Peralatan Masak' => 'https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?w=600&q=80',
                            'Perlengkapan' => 'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=600&q=80',
                            'Pakaian' => 'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?w=600&q=80',
                        ];
                        $categoryIcons = [
                            'Tenda' => 'house-door',
                            'Sleeping Bag' => 'moon-stars',
                            'Carrier' => 'backpack',
                            'Peralatan Masak' => 'fire',
                            'Perlengkapan' => 'tools',
                            'Pakaian' => 'bag',
                        ];
                        $categoryImage = $categoryImages[$category->name] ?? 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=600&q=80';
                        $categoryIcon = $categoryIcons[$category->name] ?? 'box-seam';
                    @endphp
                    <div class="position-relative">
                        <img src="{{ $categoryImage }}" alt="{{ $category->name }}" class="category-card-img">
                        <div class="category-icon-overlay">
                            <i class="bi bi-{{ $categoryIcon }} fs-1 text-success"></i>
                        </div>
                    </div>
                    <div class="card-body text-center p-4">
                        <h4 class="card-title mb-2">{{ $category->name }}</h4>
                        <p class="card-text text-muted">{{ $category->description }}</p>
                        <a href="{{ route('equipment.index', ['category' => $category->id]) }}" class="btn btn-outline-success">Lihat Peralatan <i class="bi bi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Featured Equipment -->
<div class="equipment-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Peralatan Terbaru</h2>
            <p class="text-muted">Peralatan berkualitas untuk petualangan yang tak terlupakan</p>
        </div>
        <div class="row">
            @foreach($equipments as $equipment)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @if($equipment->image)
                        <img src="{{ asset('storage/' . $equipment->image) }}" class="card-img-top" alt="{{ $equipment->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <span class="badge bg-success mb-2">{{ $equipment->category->name }}</span>
                        <h5 class="card-title">{{ $equipment->name }}</h5>
                        <div class="rating mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $equipment->average_rating ? '-fill' : '' }}"></i>
                            @endfor
                            <small class="text-muted">({{ $equipment->total_reviews }})</small>
                        </div>
                        <p class="text-muted">{{ Str::limit($equipment->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <strong class="text-success">Rp {{ number_format($equipment->price_per_day, 0, ',', '.') }}/hari</strong>
                            <a href="{{ route('equipment.show', $equipment->id) }}" class="btn btn-sm btn-primary">Detail</a>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <small class="text-muted">
                            <i class="bi bi-box"></i> Stok: {{ $equipment->available_stock }}
                        </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('equipment.index') }}" class="btn btn-primary">Lihat Semua Peralatan</a>
        </div>
    </div>
</div>
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3 text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.68);">
                Mengapa Memilih Kami?
            </h2>
            <p class="text-white fs-5" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.68);">
                Kepercayaan Anda adalah prioritas kami
            </p>
        </div>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="features-card text-center h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-shield-check fs-1 text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Terpercaya</h5>
                    <p class="text-muted">Peralatan berkualitas dan terawat dengan baik untuk keamanan Anda</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="features-card text-center h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-cash-coin fs-1 text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Harga Terjangkau</h5>
                    <p class="text-muted">Harga sewa yang kompetitif dan ekonomis sesuai budget Anda</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="features-card text-center h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-clock-history fs-1 text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Fleksibel</h5>
                    <p class="text-muted">Durasi sewa yang dapat disesuaikan dengan rencana perjalanan Anda</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="features-card text-center h-100">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-headset fs-1 text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Layanan 24/7</h5>
                    <p class="text-muted">Siap melayani kapan saja Anda membutuhkan bantuan</p>
                </div>
            </div
            <i class="bi bi-headset fs-1 text-success mb-3"></i>
            <h5>Layanan 24/7</h5>
            <p class="text-muted">Siap melayani kapan saja Anda membutuhkan</p>
        </div>
    </div>
</div>
@endsection
