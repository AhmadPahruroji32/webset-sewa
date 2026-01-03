@extends('layouts.admin')

@section('title', 'Alat Camping')
@section('page-title', 'Manajemen Alat Camping')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Alat</h5>
        <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Alat
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.equipment.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari alat..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga/Hari</th>
                        <th>Stok</th>
                        <th>Tersedia</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($equipments as $equipment)
                    <tr>
                        <td>
                            @if($equipment->image)
                                <img src="{{ asset('storage/' . $equipment->image) }}" alt="{{ $equipment->name }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded me-2">
                            @endif
                            {{ $equipment->name }}
                        </td>
                        <td>{{ $equipment->category->name }}</td>
                        <td>Rp {{ number_format($equipment->price_per_day, 0, ',', '.') }}</td>
                        <td>{{ $equipment->stock }}</td>
                        <td>
                            <span class="badge {{ $equipment->available_stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $equipment->available_stock }}
                            </span>
                        </td>
                        <td>
                            @if($equipment->condition == 'excellent')
                                <span class="badge bg-success">Sangat Baik</span>
                            @elseif($equipment->condition == 'good')
                                <span class="badge bg-primary">Baik</span>
                            @else
                                <span class="badge bg-warning">Cukup</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.equipment.edit', $equipment->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.equipment.destroy', $equipment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada alat</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $equipments->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
