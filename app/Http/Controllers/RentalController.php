<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['equipment', 'review'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('rentals.index', compact('rentals'));
    }

    public function create($equipmentId)
    {
        $equipment = Equipment::findOrFail($equipmentId);

        if ($equipment->available_stock <= 0) {
            return redirect()->back()->with('error', 'Stok alat tidak tersedia.');
        }

        return view('rentals.create', compact('equipment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date|after_or_equal:' . date('Y-m-d'),
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string',
        ]);

        $equipment = Equipment::findOrFail($validated['equipment_id']);

        if ($equipment->available_stock < $validated['quantity']) {
            return back()->withInput()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $equipment->available_stock);
        }

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $durationDays = $startDate->diffInDays($endDate) + 1;
        $totalPrice = $equipment->price_per_day * $validated['quantity'] * $durationDays;

        $rental = Rental::create([
            'user_id' => Auth::id(),
            'equipment_id' => $validated['equipment_id'],
            'quantity' => $validated['quantity'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'duration_days' => $durationDays,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $validated['notes'],
        ]);

        // Update available stock
        $equipment->decrement('available_stock', $validated['quantity']);

        return redirect()->route('rentals.show', $rental->id)
            ->with('success', 'Pesanan berhasil dibuat. Menunggu persetujuan admin.');
    }

    public function show($id)
    {
        $rental = Rental::with(['equipment', 'user', 'review'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('rentals.show', compact('rental'));
    }

    public function cancel($id)
    {
        $rental = Rental::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

        $rental->update(['status' => 'cancelled']);

        // Restore available stock
        $rental->equipment->increment('available_stock', $rental->quantity);

        return redirect()->route('rentals.index')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
