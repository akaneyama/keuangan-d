<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::ownedByUser()->with('category')->latest('date');

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

        $expenses = $query->paginate(10)->withQueryString();
        $categories = Category::ownedByUser()->where('type', 'expense')->get();

        return view('expenses.index', compact('expenses', 'categories'));
    }

    public function create()
    {
        $categories = \App\Models\Category::ownedByUser()->where('type', 'expense')->get();
        $accounts = \App\Models\Account::ownedByUser()->get();
        $savingsTargets = \App\Models\SavingsTarget::ownedByUser()->where('status', 'ongoing')->get();
        
        return view('expenses.create', compact('categories', 'accounts', 'savingsTargets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'savings_target_id' => 'nullable|exists:savings_targets,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);
        
        $validated['user_id'] = auth()->id();
        $expense = Expense::create($validated);

        // Update Account Balance
        $account = \App\Models\Account::findOrFail($validated['account_id']);
        $account->decrement('balance', $validated['amount']);

        // Update Savings Target if applicable
        if ($validated['savings_target_id']) {
            $target = \App\Models\SavingsTarget::findOrFail($validated['savings_target_id']);
            $target->decrement('current_amount', $validated['amount']);
            
            // Log as a negative transaction for history
            \App\Models\SavingsTransaction::create([
                'savings_target_id' => $target->id,
                'account_id' => $account->id,
                'amount' => -$validated['amount'],
                'date' => $validated['date'],
                'note' => 'Expense: ' . ($validated['description'] ?? 'Withdrawal for expense'),
            ]);
        }

        return redirect()->route('expenses.index')->with('success', 'Expense recorded successfully.');
    }

    public function edit(Expense $expense)
    {
        if ($expense->user_id !== auth()->id()) abort(403);
        $categories = \App\Models\Category::ownedByUser()->where('type', 'expense')->get();
        $accounts = \App\Models\Account::ownedByUser()->get();
        $savingsTargets = \App\Models\SavingsTarget::ownedByUser()->get(); // show all targets in edit

        return view('expenses.edit', compact('expense', 'categories', 'accounts', 'savingsTargets'));
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'savings_target_id' => 'nullable|exists:savings_targets,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        // Revert old account balance
        $oldAccount = \App\Models\Account::findOrFail($expense->account_id);
        $oldAccount->increment('balance', $expense->amount);

        // Revert old savings target if any
        if ($expense->savings_target_id) {
            $oldTarget = \App\Models\SavingsTarget::findOrFail($expense->savings_target_id);
            $oldTarget->increment('current_amount', $expense->amount);
        }

        // Update expense
        $expense->update($validated);

        // Apply new account balance
        $newAccount = \App\Models\Account::findOrFail($validated['account_id']);
        $newAccount->decrement('balance', $validated['amount']);

        // Apply new savings target if any
        if ($validated['savings_target_id']) {
            $newTarget = \App\Models\SavingsTarget::findOrFail($validated['savings_target_id']);
            $newTarget->decrement('current_amount', $validated['amount']);
        }

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== auth()->id()) abort(403);
        
        // Revert account balance
        if ($expense->account_id) {
            $account = \App\Models\Account::findOrFail($expense->account_id);
            $account->increment('balance', $expense->amount);
        }

        // Revert savings target balance
        if ($expense->savings_target_id) {
            $target = \App\Models\SavingsTarget::findOrFail($expense->savings_target_id);
            $target->increment('current_amount', $expense->amount);
        }

        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
