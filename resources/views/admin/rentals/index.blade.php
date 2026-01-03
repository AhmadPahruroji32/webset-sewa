@extends('layouts.admin')

@section('title', 'Penyewaan')
@section('page-title', 'Manajemen Penyewaan')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <form action="{{ route('admin.rentals.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pengguna</th>
                        <th>Alat</th>
                        <th>Tanggal</th>
                        <th>Durasi</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rentals as $rental)
                    <tr>
                        <td>{{ $rental->rental_code }}</td>
                        <td>{{ $rental->user->name }}</td>
                        <td>{{ $rental->equipment->name }} ({{ $rental->quantity }}x)</td>
                        <td>
                            {{ $rental->start_date->format('d/m/Y') }} -
                            {{ $rental->end_date->format('d/m/Y') }}
                        </td>
                        <td>{{ $rental->duration_days }} hari</td>
                        <td>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
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
                        <td>
                            <a href="{{ route('admin.rentals.show', $rental->id) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada penyewaan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $rentals->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
