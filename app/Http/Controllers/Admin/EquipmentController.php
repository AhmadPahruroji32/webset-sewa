<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::with('category')
            ->when(request('search'), function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->latest()
            ->paginate(10);

        return view('admin.equipment.index', compact('equipments'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.equipment.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'condition' => 'required|in:excellent,good,fair',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['available_stock'] = $validated['stock'];

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('equipment', 'public');
        }

        Equipment::create($validated);

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        $categories = Category::all();
        return view('admin.equipment.edit', compact('equipment', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'condition' => 'required|in:excellent,good,fair',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $equipment = Equipment::findOrFail($id);

        // Calculate the rented quantity (not available)
        $rentedQuantity = $equipment->stock - $equipment->available_stock;
        
        // Adjust available stock based on new stock
        $validated['available_stock'] = max(0, $validated['stock'] - $rentedQuantity);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($equipment->image) {
                Storage::disk('public')->delete($equipment->image);
            }
            $validated['image'] = $request->file('image')->store('equipment', 'public');
        }

        $equipment->update($validated);

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);

        if ($equipment->rentals()->whereIn('status', ['pending', 'approved', 'active'])->count() > 0) {
            return back()->with('error', 'Alat tidak dapat dihapus karena masih ada penyewaan aktif.');
        }

        if ($equipment->image) {
            Storage::disk('public')->delete($equipment->image);
        }

        $equipment->delete();

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Alat berhasil dihapus.');
    }
}
