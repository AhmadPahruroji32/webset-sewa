<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($rentalId)
    {
        $rental = Rental::with('equipment')
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->whereDoesntHave('review')
            ->findOrFail($rentalId);

        return view('reviews.create', compact('rental'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $rental = Rental::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->whereDoesntHave('review')
            ->findOrFail($validated['rental_id']);

        Review::create([
            'rental_id' => $validated['rental_id'],
            'user_id' => Auth::id(),
            'equipment_id' => $rental->equipment_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('rentals.show', $rental->id)
            ->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
