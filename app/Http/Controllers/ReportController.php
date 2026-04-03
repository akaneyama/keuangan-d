<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Debt;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FinancialReportExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $incomes = Income::ownedByUser()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->with('category')
            ->get();
            
        $expenses = Expense::ownedByUser()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->with('category')
            ->get();

        $totalIncome = $incomes->sum('amount');
        $totalExpense = $expenses->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        $unpaidDebts = Debt::ownedByUser()->where('type', 'debt')->where('status', 'unpaid')->sum('amount');
        $unpaidReceivables = Debt::ownedByUser()->where('type', 'receivable')->where('status', 'unpaid')->sum('amount');

        return view('reports.index', compact('incomes', 'expenses', 'totalIncome', 'totalExpense', 'netBalance', 'month', 'year', 'unpaidDebts', 'unpaidReceivables'));
    }

    public function exportPdf(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $incomes = Income::ownedByUser()->whereMonth('date', $month)->whereYear('date', $year)->get();
        $expenses = Expense::ownedByUser()->whereMonth('date', $month)->whereYear('date', $year)->get();

        $totalIncome = $incomes->sum('amount');
        $totalExpense = $expenses->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        $unpaidDebts = Debt::ownedByUser()->where('type', 'debt')->where('status', 'unpaid')->sum('amount');
        $unpaidReceivables = Debt::ownedByUser()->where('type', 'receivable')->where('status', 'unpaid')->sum('amount');

        $pdf = Pdf::loadView('reports.pdf', compact('incomes', 'expenses', 'totalIncome', 'totalExpense', 'netBalance', 'month', 'year', 'unpaidDebts', 'unpaidReceivables'));
        return $pdf->download("Financial_Report_{$year}_{$month}.pdf");
    }

    public function exportExcel(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        
        return Excel::download(new FinancialReportExport($month, $year), "Financial_Report_{$year}_{$month}.xlsx");
    }
}
