<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Income::ownedByUser()->with('category')->latest('date');

        // Search by description or exact amount
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('amount', $search);
            });
        }

        // Filter by Category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by specific Date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // Filter by Month & Year
        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        // Filter by Date Range
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        $incomes = $query->paginate(10)->withQueryString();
        $categories = Category::ownedByUser()->where('type', 'income')->get();
        
        return view('incomes.index', compact('incomes', 'categories'));
    }

    public function create()
    {
        $categories = Category::ownedByUser()->where('type', 'income')->get();
        $accounts = \App\Models\Account::ownedByUser()->get();
        return view('incomes.create', compact('categories', 'accounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);
        
        $validated['user_id'] = auth()->id();
        $income = Income::create($validated);

        // Update Account Balance
        $account = \App\Models\Account::findOrFail($validated['account_id']);
        $account->increment('balance', $validated['amount']);

        return redirect()->route('incomes.index')->with('success', 'Income recorded successfully.');
    }

    public function edit(Income $income)
    {
        if ($income->user_id !== auth()->id()) abort(403);
        $categories = Category::ownedByUser()->where('type', 'income')->get();
        $accounts = \App\Models\Account::ownedByUser()->get();
        return view('incomes.edit', compact('income', 'categories', 'accounts'));
    }

    public function update(Request $request, Income $income)
    {
        if ($income->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        // Revert old account balance
        $oldAccount = \App\Models\Account::findOrFail($income->account_id);
        $oldAccount->decrement('balance', $income->amount);

        // Update income
        $income->update($validated);

        // Update new account balance
        $newAccount = \App\Models\Account::findOrFail($validated['account_id']);
        $newAccount->increment('balance', $validated['amount']);

        return redirect()->route('incomes.index')->with('success', 'Income updated successfully.');
    }

    public function destroy(Income $income)
    {
        if ($income->user_id !== auth()->id()) abort(403);
        
        // Revert account balance
        if ($income->account_id) {
            $account = \App\Models\Account::findOrFail($income->account_id);
            $account->decrement('balance', $income->amount);
        }

        $income->delete();
        return redirect()->route('incomes.index')->with('success', 'Income deleted successfully.');
    }
}
