<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['user', 'equipment'])
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })
            ->latest()
            ->paginate(15);

        return view('admin.rentals.index', compact('rentals'));
    }

    public function show($id)
    {
        $rental = Rental::with(['user', 'equipment', 'review'])->findOrFail($id);
        return view('admin.rentals.show', compact('rental'));
    }

    public function approve($id)
    {
        $rental = Rental::where('status', 'pending')->findOrFail($id);
        $rental->update(['status' => 'approved']);

        return back()->with('success', 'Pesanan berhasil disetujui.');
    }

    public function activate($id)
    {
        $rental = Rental::where('status', 'approved')->findOrFail($id);
        $rental->update(['status' => 'active']);

        return back()->with('success', 'Penyewaan berhasil diaktifkan.');
    }

    public function complete($id)
    {
        $rental = Rental::where('status', 'active')->findOrFail($id);
        $rental->update(['status' => 'completed']);

        // Restore available stock
        $rental->equipment->increment('available_stock', $rental->quantity);

        return back()->with('success', 'Penyewaan berhasil diselesaikan.');
    }

    public function reject($id, Request $request)
    {
        $request->validate([
            'notes' => 'required|string',
        ]);

        $rental = Rental::where('status', 'pending')->findOrFail($id);
        $rental->update([
            'status' => 'cancelled',
            'notes' => $request->notes,
        ]);

        // Restore available stock
        $rental->equipment->increment('available_stock', $rental->quantity);

        return back()->with('success', 'Pesanan berhasil ditolak.');
    }
}
