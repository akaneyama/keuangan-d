<?php

namespace App\Exports;

use App\Models\Income;
use App\Models\Expense;
use App\Models\Debt;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FinancialReportExport implements FromView
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function view(): View
    {
        $incomes = Income::ownedByUser()->whereMonth('date', $this->month)->whereYear('date', $this->year)->get();
        $expenses = Expense::ownedByUser()->whereMonth('date', $this->month)->whereYear('date', $this->year)->get();

        $totalIncome = $incomes->sum('amount');
        $totalExpense = $expenses->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        $unpaidDebts = Debt::ownedByUser()->where('type', 'debt')->where('status', 'unpaid')->sum('amount');
        $unpaidReceivables = Debt::ownedByUser()->where('type', 'receivable')->where('status', 'unpaid')->sum('amount');

        $month = $this->month;
        $year = $this->year;

        return view('reports.excel', compact('incomes', 'expenses', 'totalIncome', 'totalExpense', 'netBalance', 'month', 'year', 'unpaidDebts', 'unpaidReceivables'));
    }
}
