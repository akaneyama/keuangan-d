<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        $month = request('month', now()->month);
        $year = request('year', now()->year);

        $budgets = Budget::ownedByUser()
            ->where('month', $month)
            ->where('year', $year)
            ->with('category')
            ->get();
        
        $categories = Category::ownedByUser()->where('type', 'expense')->get();

        // Get actual expenses for each budget's category in the same month/year
        $budgets->map(function ($budget) use ($month, $year) {
            $budget->actual = \App\Models\Expense::ownedByUser()
                ->where('category_id', $budget->category_id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount');
            return $budget;
        });

        return view('budgets.index', compact('budgets', 'categories', 'month', 'year'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer',
        ]);

        Budget::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'category_id' => $validated['category_id'],
                'month' => $validated['month'],
                'year' => $validated['year'],
            ],
            ['amount' => $validated['amount']]
        );

        return redirect()->route('budgets.index', ['month' => $validated['month'], 'year' => $validated['year']])
            ->with('success', 'Budget saved successfully.');
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== auth()->id()) abort(403);
        $budget->delete();

        return redirect()->back()->with('success', 'Budget deleted successfully.');
    }
}
