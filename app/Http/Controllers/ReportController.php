<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
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

        return view('reports.index', compact('incomes', 'expenses', 'totalIncome', 'totalExpense', 'netBalance', 'month', 'year'));
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

        $pdf = Pdf::loadView('reports.pdf', compact('incomes', 'expenses', 'totalIncome', 'totalExpense', 'netBalance', 'month', 'year'));
        return $pdf->download("Financial_Report_{$year}_{$month}.pdf");
    }

    public function exportExcel(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        
        return Excel::download(new FinancialReportExport($month, $year), "Financial_Report_{$year}_{$month}.xlsx");
    }
}
