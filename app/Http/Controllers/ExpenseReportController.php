<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExpenseReportController extends Controller
{
    public function index(Request $request)
    {
        // 表示する年月の取得（デフォルトは今月）
        $yearMonth = $request->input('year_month', Carbon::now()->format('Y-m'));
        $date = Carbon::createFromFormat('Y-m', $yearMonth);

        // 月ごとの支出合計
        $monthlyTotal = Expense::where('user_id', auth()->id())
            ->whereYear('expense_date', $date->year)
            ->whereMonth('expense_date', $date->month)
            ->sum('amount');

        // カテゴリーごとの支出合計（全てのカテゴリーを含める）
        $categoryTotals = collect(Expense::CATEGORIES)->map(function ($category) use ($date) {
            $total = Expense::where('user_id', auth()->id())
                ->whereYear('expense_date', $date->year)
                ->whereMonth('expense_date', $date->month)
                ->where('category', $category)
                ->sum('amount');

            return [
                'category' => $category,
                'total' => $total
            ];
        });

        // 過去6ヶ月の月を生成
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push($date->copy()->subMonths($i)->format('Y-m'));
        }

        // 過去6ヶ月分の支出を取得
        $expenses = Expense::where('user_id', auth()->id())
            ->where('expense_date', '>=', $date->copy()->subMonths(5)->startOfMonth())
            ->where('expense_date', '<=', $date->endOfMonth())
            ->get();

        // 月ごとに合計を集計
        $monthlyTotals = $months->map(function ($month) use ($expenses) {
            $total = $expenses->filter(function ($expense) use ($month) {
                return $expense->expense_date->format('Y-m') === $month;
            })->sum('amount');
            return [
                'month' => $month,
                'total' => $total
            ];
        });

        // デバッグ情報
        \Log::info('Category Totals:', $categoryTotals->toArray());
        \Log::info('Monthly Totals:', $monthlyTotals->toArray());

        return view('expenses.report', compact(
            'yearMonth',
            'monthlyTotal',
            'categoryTotals',
            'monthlyTotals'
        ));
    }
} 