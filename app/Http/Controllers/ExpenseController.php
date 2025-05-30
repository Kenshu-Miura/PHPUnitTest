<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $expenses = Expense::where('user_id', auth()->id())
            ->orderBy('expense_date', 'desc')
            ->get();

        return view('expenses.index', [
            'expenses' => $expenses,
            'categories' => Expense::CATEGORIES
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category' => 'required|in:' . implode(',', Expense::CATEGORIES),
            'description' => 'nullable|string|max:255',
            'expense_date' => 'required|date'
        ]);

        $expense = new Expense();
        $expense->user_id = auth()->id();
        $expense->amount = $request->amount;
        $expense->category = $request->category;
        $expense->description = $request->description;
        $expense->expense_date = $request->expense_date;
        $expense->save();

        return redirect()->route('expenses.index')
            ->with('success', '支出を登録しました。');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== auth()->id()) {
            abort(403);
        }
        
        $expense->delete();
        return redirect()->route('expenses.index')
            ->with('success', '支出を削除しました。');
    }
} 