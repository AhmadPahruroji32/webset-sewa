@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Alat</h6>
                        <h2 class="mb-0">{{ $totalEquipment }}</h2>
                    </div>
                    <div class="text-primary fs-1">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Kategori</h6>
                        <h2 class="mb-0">{{ $totalCategories }}</h2>
                    </div>
                    <div class="text-success fs-1">
                        <i class="bi bi-list-ul"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Pengguna</h6>
                        <h2 class="mb-0">{{ $totalUsers }}</h2>
                    </div>
                    <div class="text-info fs-1">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Penyewaan</h6>
                        <h2 class="mb-0">{{ $totalRentals }}</h2>
                    </div>
                    <div class="text-warning fs-1">
                        <i class="bi bi-bag-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Menunggu Persetujuan</h6>
                <h3 class="text-warning">{{ $pendingRentals }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Penyewaan Aktif</h6>
                <h3 class="text-success">{{ $activeRentals }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Pendapatan Bulan Ini</h6>
                <h3 class="text-primary">Rp {{ number_format($thisMonthRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Penyewaan Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Pengguna</th>
                                <th>Alat</th>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentRentals as $rental)
                            <tr>
                                <td>{{ $rental->rental_code }}</td>
                                <td>{{ $rental->user->name }}</td>
                                <td>{{ $rental->equipment->name }}</td>
                                <td>
                                    @if($rental->status == 'pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($rental->status == 'approved')
                                        <span class="badge bg-info">Disetujui</span>
                                    @elseif($rental->status == 'active')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($rental->status == 'completed')
                                        <span class="badge bg-secondary">Selesai</span>
                                    @else
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada penyewaan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-warning">
            <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Stok Menipis</h5>
                <span class="badge bg-white text-warning">{{ $lowStockEquipment->count() }}</span>
            </div>
            <div class="card-body p-0">
                @forelse($lowStockEquipment as $equipment)
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom hover-bg-light">
                    <div class="flex-grow-1">
                        <a href="{{ route('admin.equipment.edit', $equipment->id) }}" class="text-decoration-none text-dark">
                            <strong>{{ $equipment->name }}</strong>
                        </a>
                        <br>
                        <small class="text-muted">
                            <i class="bi bi-tag"></i> {{ $equipment->category->name }}
                        </small>
                        <br>
                        <small class="text-muted">
                            <i class="bi bi-box"></i> Total: {{ $equipment->stock }} | 
                            <i class="bi bi-check-circle"></i> Tersedia: {{ $equipment->available_stock }}
                        </small>
                    </div>
                    <div class="ms-2">
                        @if($equipment->available_stock == 0)
                            <span class="badge bg-danger fs-6">Habis</span>
                        @elseif($equipment->available_stock == 1)
                            <span class="badge bg-danger fs-6">{{ $equipment->available_stock }}</span>
                        @else
                            <span class="badge bg-warning fs-6">{{ $equipment->available_stock }}</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="p-4 text-center">
                    <i class="bi bi-check-circle text-success fs-1"></i>
                    <p class="text-muted mt-2 mb-0">Semua stok aman</p>
                </div>
                @endforelse
            </div>
            @if($lowStockEquipment->count() > 0)
            <div class="card-footer bg-light text-center">
                <a href="{{ route('admin.equipment.index') }}" class="text-decoration-none">
                    Kelola Stok <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
