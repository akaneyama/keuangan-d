<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $filter = $request->get('filter', 'month'); // day, month, year
        
        $incomeQuery = Income::ownedByUser();
        $expenseQuery = Expense::ownedByUser();

        if ($filter === 'day') {
            $incomeQuery->whereDate('date', today());
            $expenseQuery->whereDate('date', today());
        } elseif ($filter === 'year') {
            $incomeQuery->whereYear('date', now()->year);
            $expenseQuery->whereYear('date', now()->year);
        } else {
            $incomeQuery->whereMonth('date', now()->month)->whereYear('date', now()->year);
            $expenseQuery->whereMonth('date', now()->month)->whereYear('date', now()->year);
        }

        $totalIncome = $incomeQuery->sum('amount');
        $totalExpense = $expenseQuery->sum('amount');
        
        $totalIncomeOverall = Income::ownedByUser()->sum('amount');
        $totalExpenseOverall = Expense::ownedByUser()->sum('amount');
        $currentBalance = $totalIncomeOverall - $totalExpenseOverall;
        
        // Month over month growth (for month filter)
        $prevMonthIncome = Income::ownedByUser()->whereMonth('date', now()->subMonth()->month)->whereYear('date', now()->subMonth()->year)->sum('amount');
        $prevMonthExpense = Expense::ownedByUser()->whereMonth('date', now()->subMonth()->month)->whereYear('date', now()->subMonth()->year)->sum('amount');
        
        $incomeGrowth = $prevMonthIncome > 0 ? (($totalIncome - $prevMonthIncome) / $prevMonthIncome) * 100 : 0;
        $expenseGrowth = $prevMonthExpense > 0 ? (($totalExpense - $prevMonthExpense) / $prevMonthExpense) * 100 : 0;

        // Recent Transactions
        $recentIncomes = Income::ownedByUser()->with('category')->latest('date')->take(5)->get()->map(function($i) {
            $i->type = 'income';
            return $i;
        });
        $recentExpenses = Expense::ownedByUser()->with('category')->latest('date')->take(5)->get()->map(function($e) {
            $e->type = 'expense';
            return $e;
        });
        $recentTransactions = $recentIncomes->concat($recentExpenses)->sortByDesc('date')->take(5);

        // Savings Progress
        $savingsTargets = \App\Models\SavingsTarget::ownedByUser()->where('status', 'ongoing')->latest()->take(3)->get();

        // Avg per month
        $firstIncomeDate = Income::ownedByUser()->min('date');
        $monthsActive = 1;
        if ($firstIncomeDate) {
            $monthsActive = now()->diffInMonths(\Carbon\Carbon::parse($firstIncomeDate)) + 1;
        }
        $avgIncomePerMonth = $totalIncomeOverall / max($monthsActive, 1);
        
        // Chart: Income vs Expense grouped by Month (Last 6 months)
        $chartMonths = collect();
        $chartIncome = collect();
        $chartExpense = collect();
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartMonths->push($date->format('M Y'));
            
            $chartIncome->push(Income::ownedByUser()->whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('amount'));
            $chartExpense->push(Expense::ownedByUser()->whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('amount'));
        }

        // Chart: Expense by Category
        $expensesByCategory = Expense::ownedByUser()
            ->with('category')
            ->selectRaw('category_id, sum(amount) as total')
            ->groupBy('category_id')
            ->get();
            
        $pieLabels = $expensesByCategory->pluck('category.name');
        $pieData = $expensesByCategory->pluck('total');

        return view('dashboard', compact(
            'totalIncome', 'totalExpense', 'currentBalance', 'avgIncomePerMonth',
            'chartMonths', 'chartIncome', 'chartExpense', 'pieLabels', 'pieData', 'filter',
            'recentTransactions', 'savingsTargets', 'incomeGrowth', 'expenseGrowth'
        ));
    }
}
