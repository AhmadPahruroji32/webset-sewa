@extends('layouts.app')

@section('title', 'Detail Penyewaan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Penyewaan</h4>
                    @if($rental->status == 'pending')
                        <span class="badge bg-warning">Menunggu Persetujuan</span>
                    @elseif($rental->status == 'approved')
                        <span class="badge bg-info">Disetujui</span>
                    @elseif($rental->status == 'active')
                        <span class="badge bg-success">Aktif</span>
                    @elseif($rental->status == 'completed')
                        <span class="badge bg-secondary">Selesai</span>
                    @else
                        <span class="badge bg-danger">Dibatalkan</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            @if($rental->equipment->image)
                                <img src="{{ asset('storage/' . $rental->equipment->image) }}" class="img-fluid rounded" alt="{{ $rental->equipment->name }}">
                            @else
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" style="height: 150px;">
                                    <i class="bi bi-image fs-1"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h5>{{ $rental->equipment->name }}</h5>
                            <p class="text-muted">{{ $rental->equipment->category->name }}</p>
                        </div>
                    </div>
                    
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Kode Penyewaan</th>
                            <td>{{ $rental->rental_code }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td>{{ $rental->quantity }} unit</td>
                        </tr>
                        <tr>
                            <th>Harga per Hari</th>
                            <td>Rp {{ number_format($rental->equipment->price_per_day, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Mulai</th>
                            <td>{{ $rental->start_date->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Selesai</th>
                            <td>{{ $rental->end_date->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Durasi</th>
                            <td>{{ $rental->duration_days }} hari</td>
                        </tr>
                        <tr>
                            <th>Total Harga</th>
                            <td><h4 class="text-success">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</h4></td>
                        </tr>
                        @if($rental->notes)
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $rental->notes }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Tanggal Pesanan</th>
                            <td>{{ $rental->created_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>
                    
                    @if($rental->review)
                    <div class="card bg-light mt-4">
                        <div class="card-body">
                            <h6>Ulasan Anda</h6>
                            <div class="rating mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $rental->review->rating ? '-fill' : '' }} fs-5"></i>
                                @endfor
                            </div>
                            <p class="mb-0">{{ $rental->review->comment }}</p>
                        </div>
                    </div>
                    @endif
                    
                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('rentals.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        @if($rental->status == 'completed' && !$rental->review)
                            <a href="{{ route('reviews.create', $rental->id) }}" class="btn btn-warning">
                                <i class="bi bi-star"></i> Beri Ulasan
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
