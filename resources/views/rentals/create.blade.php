@extends('layouts.app')

@section('title', 'Sewa Alat')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Form Penyewaan</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            @if($equipment->image)
                                <img src="{{ asset('storage/' . $equipment->image) }}" class="img-fluid rounded" alt="{{ $equipment->name }}">
                            @else
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" style="height: 150px;">
                                    <i class="bi bi-image fs-1"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h5>{{ $equipment->name }}</h5>
                            <p class="text-muted mb-1">{{ $equipment->category->name }}</p>
                            <p class="mb-1"><strong>Harga:</strong> Rp {{ number_format($equipment->price_per_day, 0, ',', '.') }}/hari</p>
                            <p class="mb-1"><strong>Stok Tersedia:</strong> {{ $equipment->available_stock }} unit</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('rentals.store') }}" method="POST" id="rentalForm">
                        @csrf
                        <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">
                        
                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 1) }}" min="1" max="{{ $equipment->available_stock }}" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" min="{{ date('Y-m-d') }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h6>Ringkasan Harga</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Harga per hari:</span>
                                    <span>Rp {{ number_format($equipment->price_per_day, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Jumlah:</span>
                                    <span id="summaryQty">1</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Durasi:</span>
                                    <span id="summaryDuration">- hari</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>Total:</strong>
                                    <strong class="text-success" id="summaryTotal">Rp 0</strong>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Buat Pesanan
                            </button>
                            <a href="{{ route('equipment.show', $equipment->id) }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    const pricePerDay = {{ $equipment->price_per_day }};
    
    function calculateTotal() {
        const quantity = parseInt(document.getElementById('quantity').value) || 0;
        const startDate = new Date(document.getElementById('start_date').value);
        const endDate = new Date(document.getElementById('end_date').value);
        
        document.getElementById('summaryQty').textContent = quantity;
        
        if (startDate && endDate && endDate >= startDate) {
            const diffTime = Math.abs(endDate - startDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            const total = pricePerDay * quantity * diffDays;
            
            document.getElementById('summaryDuration').textContent = diffDays + ' hari';
            document.getElementById('summaryTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
        } else {
            document.getElementById('summaryDuration').textContent = '- hari';
            document.getElementById('summaryTotal').textContent = 'Rp 0';
        }
    }
    
    document.getElementById('quantity').addEventListener('input', calculateTotal);
    document.getElementById('start_date').addEventListener('change', calculateTotal);
    document.getElementById('end_date').addEventListener('change', calculateTotal);
    
    // Set end_date minimum based on start_date
    document.getElementById('start_date').addEventListener('change', function() {
        document.getElementById('end_date').min = this.value;
    });
</script>
@endsection
@endsection
