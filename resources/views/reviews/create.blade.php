@extends('layouts.app')

@section('title', 'Beri Ulasan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Beri Ulasan</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($rental->equipment->image)
                            <img src="{{ asset('storage/' . $rental->equipment->image) }}" class="img-fluid rounded mb-3" alt="{{ $rental->equipment->name }}" style="max-height: 200px;">
                        @endif
                        <h5>{{ $rental->equipment->name }}</h5>
                        <p class="text-muted">{{ $rental->equipment->category->name }}</p>
                    </div>
                    
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="rental_id" value="{{ $rental->id }}">
                        
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div class="rating-input text-center">
                                <input type="radio" name="rating" value="1" id="star1" class="d-none" required>
                                <label for="star1" class="star-label fs-1" data-value="1">
                                    <i class="bi bi-star"></i>
                                </label>
                                
                                <input type="radio" name="rating" value="2" id="star2" class="d-none">
                                <label for="star2" class="star-label fs-1" data-value="2">
                                    <i class="bi bi-star"></i>
                                </label>
                                
                                <input type="radio" name="rating" value="3" id="star3" class="d-none">
                                <label for="star3" class="star-label fs-1" data-value="3">
                                    <i class="bi bi-star"></i>
                                </label>
                                
                                <input type="radio" name="rating" value="4" id="star4" class="d-none">
                                <label for="star4" class="star-label fs-1" data-value="4">
                                    <i class="bi bi-star"></i>
                                </label>
                                
                                <input type="radio" name="rating" value="5" id="star5" class="d-none">
                                <label for="star5" class="star-label fs-1" data-value="5">
                                    <i class="bi bi-star"></i>
                                </label>
                            </div>
                            @error('rating')
                                <div class="text-danger text-center">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Komentar</label>
                            <textarea name="comment" class="form-control @error('comment') is-invalid @enderror" rows="4" placeholder="Bagikan pengalaman Anda...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Kirim Ulasan
                            </button>
                            <a href="{{ route('rentals.show', $rental->id) }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    .star-label {
        cursor: pointer;
        color: #ddd;
        transition: color 0.2s;
    }
    
    .star-label:hover,
    .star-label.active {
        color: #ffc107;
    }
    
    .star-label i {
        transition: transform 0.2s;
    }
    
    .star-label:hover i {
        transform: scale(1.2);
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labels = document.querySelectorAll('.star-label');
        const inputs = document.querySelectorAll('input[name="rating"]');
        
        labels.forEach(label => {
            label.addEventListener('click', function() {
                const value = parseInt(this.dataset.value);
                
                labels.forEach((l, index) => {
                    if (index < value) {
                        l.classList.add('active');
                        l.querySelector('i').classList.remove('bi-star');
                        l.querySelector('i').classList.add('bi-star-fill');
                    } else {
                        l.classList.remove('active');
                        l.querySelector('i').classList.remove('bi-star-fill');
                        l.querySelector('i').classList.add('bi-star');
                    }
                });
            });
        });
    });
</script>
@endsection
@endsection
