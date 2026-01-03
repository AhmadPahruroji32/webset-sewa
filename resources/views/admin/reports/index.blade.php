@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan Transaksi')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6>Total Penyewaan</h6>
                        <h3>{{ $totalRentals }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6>Selesai</h6>
                        <h3>{{ $completedRentals }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6>Aktif</h6>
                        <h3>{{ $activeRentals }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6>Total Pendapatan</h6>
                        <h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
        
        <h5 class="mb-3">Daftar Transaksi</h5>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>Pengguna</th>
                        <th>Alat</th>
                        <th>Durasi</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rentals as $rental)
                    <tr>
                        <td>{{ $rental->created_at->format('d/m/Y') }}</td>
                        <td>{{ $rental->rental_code }}</td>
                        <td>{{ $rental->user->name }}</td>
                        <td>{{ $rental->equipment->name }} ({{ $rental->quantity }}x)</td>
                        <td>{{ $rental->duration_days }} hari</td>
                        <td>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                        <td>
                            @if($rental->status == 'active')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-active">
                        <th colspan="5" class="text-end">TOTAL</th>
                        <th colspan="2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
