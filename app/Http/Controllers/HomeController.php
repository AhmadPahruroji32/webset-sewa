<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;
use App\Models\Rental;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('equipment')->get();
        $equipments = Equipment::with('category', 'reviews')
            ->where('available_stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('categories', 'equipments'));
    }

    public function equipment()
    {
        $categories = Category::all();
        $equipments = Equipment::with('category', 'reviews')
            ->when(request('category'), function ($query) {
                $query->where('category_id', request('category'));
            })
            ->when(request('search'), function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->paginate(12);

        return view('equipment.index', compact('equipments', 'categories'));
    }

    public function show($id)
    {
        $equipment = Equipment::with(['category', 'reviews.user'])->findOrFail($id);
        $relatedEquipment = Equipment::where('category_id', $equipment->category_id)
            ->where('id', '!=', $equipment->id)
            ->take(4)
            ->get();

        return view('equipment.show', compact('equipment', 'relatedEquipment'));
    }
}
