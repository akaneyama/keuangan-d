<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function index(Request $request)
    {
        $query = Debt::ownedByUser();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $debts = $query->latest()->paginate(10)->withQueryString();
        
        $totalDebt = Debt::ownedByUser()->where('type', 'debt')->where('status', 'unpaid')->sum('amount');
        $totalReceivable = Debt::ownedByUser()->where('type', 'receivable')->where('status', 'unpaid')->sum('amount');

        return view('debts.index', compact('debts', 'totalDebt', 'totalReceivable'));
    }

    public function create()
    {
        return view('debts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:debt,receivable',
            'due_date' => 'nullable|date',
            'note' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'unpaid';

        Debt::create($validated);

        return redirect()->route('debts.index')->with('success', 'Catatan hutang/piutang berhasil ditambahkan.');
    }

    public function edit(Debt $debt)
    {
        if ($debt->user_id !== auth()->id()) abort(403);
        return view('debts.edit', compact('debt'));
    }

    public function update(Request $request, Debt $debt)
    {
        if ($debt->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:debt,receivable',
            'due_date' => 'nullable|date',
            'note' => 'nullable|string',
            'status' => 'required|in:unpaid,paid',
        ]);

        $debt->update($validated);

        return redirect()->route('debts.index')->with('success', 'Catatan hutang/piutang berhasil diperbarui.');
    }

    public function destroy(Debt $debt)
    {
        if ($debt->user_id !== auth()->id()) abort(403);
        $debt->delete();

        return redirect()->route('debts.index')->with('success', 'Catatan hutang/piutang berhasil dihapus.');
    }

    public function markAsPaid(Debt $debt)
    {
        if ($debt->user_id !== auth()->id()) abort(403);
        $debt->update(['status' => 'paid']);

        return redirect()->back()->with('success', 'Ditandai sebagai lunas.');
    }
}
