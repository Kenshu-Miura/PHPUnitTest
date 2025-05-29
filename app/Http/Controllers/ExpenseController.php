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
        $expenses = Expense::where('user_id', Auth::id())
            ->orderBy('expense_date', 'desc')
            ->get();
        return view('expenses.index', compact('expenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'description' => 'required|max:255',
            'category' => 'required|max:50',
            'expense_date' => 'required|date'
        ]);

        $expense = new Expense($request->all());
        $expense->user_id = Auth::id();
        $expense->save();

        return redirect()->route('expenses.index')
            ->with('success', '支出を登録しました。');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }
        
        $expense->delete();
        return redirect()->route('expenses.index')
            ->with('success', '支出を削除しました。');
    }
} 