@extends('layouts.admin')

@section('title', 'Detail User')
@section('page-title', 'Detail User')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Informasi User</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Nama:</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Role:</th>
                        <td>
                            @if($user->role == 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @else
                                <span class="badge bg-primary">User</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Telepon:</th>
                        <td>{{ $user->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat:</th>
                        <td>{{ $user->address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Terdaftar:</th>
                        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Total Rental:</th>
                        <td><strong>{{ $user->rentals_count }}</strong></td>
                    </tr>
                </table>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Riwayat Penyewaan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Alat</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->rentals as $rental)
                            <tr>
                                <td>{{ $rental->rental_code }}</td>
                                <td>{{ $rental->equipment->name }}</td>
                                <td>{{ $rental->start_date->format('d M') }} - {{ $rental->end_date->format('d M Y') }}</td>
                                <td>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                                <td>
                                    @if($rental->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($rental->status == 'approved')
                                        <span class="badge bg-info">Approved</span>
                                    @elseif($rental->status == 'active')
                                        <span class="badge bg-primary">Active</span>
                                    @elseif($rental->status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada riwayat penyewaan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        @if($user->reviews->count() > 0)
        <div class="card mt-3">
            <div class="card-header bg-white">
                <h5 class="mb-0">Ulasan yang Diberikan</h5>
            </div>
            <div class="card-body">
                @foreach($user->reviews as $review)
                <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>{{ $review->rental->equipment->name }}</strong>
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-warning"></i>
                                @endfor
                            </div>
                        </div>
                        <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                    </div>
                    <p class="mb-0 mt-2">{{ $review->comment }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
