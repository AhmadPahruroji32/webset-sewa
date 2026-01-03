<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $rentals = Rental::with(['user', 'equipment'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completed', 'active'])
            ->get();

        $totalRevenue = $rentals->sum('total_price');
        $totalRentals = $rentals->count();
        $completedRentals = $rentals->where('status', 'completed')->count();
        $activeRentals = $rentals->where('status', 'active')->count();

        return view('admin.reports.index', compact(
            'rentals',
            'totalRevenue',
            'totalRentals',
            'completedRentals',
            'activeRentals',
            'startDate',
            'endDate'
        ));
    }
}
