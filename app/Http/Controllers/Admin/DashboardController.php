<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEquipment = Equipment::count();
        $totalCategories = Category::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalRentals = Rental::count();
        
        $pendingRentals = Rental::where('status', 'pending')->count();
        $activeRentals = Rental::where('status', 'active')->count();
        
        $thisMonthRevenue = Rental::whereIn('status', ['completed', 'active'])
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_price');

        $recentRentals = Rental::with(['user', 'equipment'])
            ->latest()
            ->take(5)
            ->get();

        // Stok menipis: stok tersedia <= 2 (termasuk 0)
        $lowStockEquipment = Equipment::with('category')
            ->where('available_stock', '<=', 2)
            ->orderBy('available_stock', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'totalEquipment',
            'totalCategories',
            'totalUsers',
            'totalRentals',
            'pendingRentals',
            'activeRentals',
            'thisMonthRevenue',
            'recentRentals',
            'lowStockEquipment'
        ));
    }
}
