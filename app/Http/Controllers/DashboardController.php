<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $monthlyTotal = Expense::where('user_id', auth()->id())
            ->whereYear('expense_date', Carbon::now()->year)
            ->whereMonth('expense_date', Carbon::now()->month)
            ->sum('amount');

        return view('dashboard', compact('monthlyTotal'));
    }
} 