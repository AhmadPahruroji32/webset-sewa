@extends('layouts.admin')

@section('title', 'Detail Penyewaan')
@section('page-title', 'Detail Penyewaan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Informasi Penyewaan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Kode Penyewaan</th>
                        <td>{{ $rental->rental_code }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
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
                    </tr>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <td>{{ $rental->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $rental->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $rental->user->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $rental->user->address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alat</th>
                        <td>{{ $rental->equipment->name }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah</th>
                        <td>{{ $rental->quantity }}</td>
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
                        <td><strong>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</strong></td>
                    </tr>
                    @if($rental->notes)
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $rental->notes }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Aksi</h5>
            </div>
            <div class="card-body">
                @if($rental->status == 'pending')
                    <form action="{{ route('admin.rentals.approve', $rental->id) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Setujui pesanan ini?')">
                            <i class="bi bi-check-circle"></i> Setujui Pesanan
                        </button>
                    </form>
                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="bi bi-x-circle"></i> Tolak Pesanan
                    </button>
                @elseif($rental->status == 'approved')
                    <form action="{{ route('admin.rentals.activate', $rental->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100" onclick="return confirm('Aktifkan penyewaan ini?')">
                            <i class="bi bi-play-circle"></i> Aktifkan Penyewaan
                        </button>
                    </form>
                @elseif($rental->status == 'active')
                    <form action="{{ route('admin.rentals.complete', $rental->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-secondary w-100" onclick="return confirm('Selesaikan penyewaan ini?')">
                            <i class="bi bi-check2-all"></i> Selesaikan Penyewaan
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.rentals.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        @if($rental->review)
        <div class="card mt-3">
            <div class="card-header bg-white">
                <h5 class="mb-0">Ulasan</h5>
            </div>
            <div class="card-body">
                <div class="rating mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $i <= $rental->review->rating ? '-fill' : '' }}"></i>
                    @endfor
                </div>
                <p>{{ $rental->review->comment }}</p>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.rentals.reject', $rental->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea name="notes" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
