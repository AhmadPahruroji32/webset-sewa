@extends('layouts.app')

@section('title', 'Penyewaan Saya')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Penyewaan Saya</h2>
    
    @forelse($rentals as $rental)
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    @php
                        // Gambar default berdasarkan kategori jika tidak ada gambar
                        $categoryDefaultImages = [
                            'Tenda' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=300&q=80',
                            'Sleeping Bag' => 'https://images.unsplash.com/photo-1601342630314-8427c38bf5e6?w=300&q=80',
                            'Carrier' => 'https://images.unsplash.com/photo-1622260614153-03223fb72052?w=300&q=80',
                            'Peralatan Masak' => 'https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?w=300&q=80',
                            'Perlengkapan' => 'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=300&q=80',
                            'Pakaian' => 'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?w=300&q=80',
                        ];
                        $defaultImage = $categoryDefaultImages[$rental->equipment->category->name] ?? 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=300&q=80';
                    @endphp
                    @if($rental->equipment->image)
                        <img src="{{ asset('storage/' . $rental->equipment->image) }}" class="img-fluid rounded" alt="{{ $rental->equipment->name }}" style="height: 120px; width: 100%; object-fit: cover;">
                    @else
                        <img src="{{ $defaultImage }}" class="img-fluid rounded" alt="{{ $rental->equipment->name }}" style="height: 120px; width: 100%; object-fit: cover;">
                    @endif
                </div>
                <div class="col-md-7">
                    <h5>{{ $rental->equipment->name }}</h5>
                    <p class="mb-1"><strong>Kode:</strong> {{ $rental->rental_code }}</p>
                    <p class="mb-1"><strong>Jumlah:</strong> {{ $rental->quantity }} unit</p>
                    <p class="mb-1"><strong>Tanggal:</strong> {{ $rental->start_date->format('d M Y') }} - {{ $rental->end_date->format('d M Y') }} ({{ $rental->duration_days }} hari)</p>
                    <p class="mb-1"><strong>Total:</strong> <span class="text-success fw-bold">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span></p>
                    @if($rental->notes)
                        <p class="mb-1 text-muted"><strong>Catatan:</strong> {{ $rental->notes }}</p>
                    @endif
                </div>
                <div class="col-md-3 text-end">
                    @if($rental->status == 'pending')
                        <span class="badge bg-warning mb-2">Menunggu Persetujuan</span>
                    @elseif($rental->status == 'approved')
                        <span class="badge bg-info mb-2">Disetujui</span>
                    @elseif($rental->status == 'active')
                        <span class="badge bg-success mb-2">Aktif</span>
                    @elseif($rental->status == 'completed')
                        <span class="badge bg-secondary mb-2">Selesai</span>
                    @else
                        <span class="badge bg-danger mb-2">Dibatalkan</span>
                    @endif
                    <div class="mt-3">
                        <a href="{{ route('rentals.show', $rental->id) }}" class="btn btn-sm btn-primary mb-1 w-100">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        @if($rental->status == 'pending')
                            <form action="{{ route('rentals.cancel', $rental->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100">
                                    <i class="bi bi-x-circle"></i> Batalkan
                                </button>
                            </form>
                        @endif
                        @if($rental->status == 'completed' && !$rental->review)
                            <a href="{{ route('reviews.create', $rental->id) }}" class="btn btn-sm btn-warning w-100 mt-1">
                                <i class="bi bi-star"></i> Beri Ulasan
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="alert alert-info text-center">
        <i class="bi bi-info-circle fs-3"></i>
        <p class="mt-2 mb-0">Belum ada penyewaan.</p>
        <a href="{{ route('equipment.index') }}" class="btn btn-primary mt-2">Lihat Peralatan</a>
    </div>
    @endforelse
    
    <div class="d-flex justify-content-center mt-4">
        {{ $rentals->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
