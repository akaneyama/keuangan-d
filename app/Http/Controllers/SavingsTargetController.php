<?php

namespace App\Http\Controllers;

use App\Models\SavingsTarget;
use Illuminate\Http\Request;

class SavingsTargetController extends Controller
{
    public function index(Request $request)
    {
        $query = SavingsTarget::ownedByUser();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $targets = $query->latest()->paginate(10)->withQueryString();
        return view('savings_targets.index', compact('targets'));
    }

    public function create()
    {
        return view('savings_targets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:1',
            'deadline' => 'nullable|date',
        ]);
        
        $validated['user_id'] = auth()->id();
        $validated['current_amount'] = 0;
        $validated['status'] = 'ongoing';

        SavingsTarget::create($validated);

        return redirect()->route('savings-targets.index')->with('success', 'Savings Target created successfully.');
    }

    public function show(SavingsTarget $savingsTarget)
    {
        if ($savingsTarget->user_id !== auth()->id()) abort(403);
        $savingsTarget->load(['transactions' => function($q) {
            $q->with('account')->latest('date');
        }]);
        
        $accounts = \App\Models\Account::ownedByUser()->get();
        
        return view('savings_targets.show', compact('savingsTarget', 'accounts'));
    }

    public function edit(SavingsTarget $savingsTarget)
    {
        if ($savingsTarget->user_id !== auth()->id()) abort(403);
        return view('savings_targets.edit', compact('savingsTarget'));
    }

    public function update(Request $request, SavingsTarget $savingsTarget)
    {
        if ($savingsTarget->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:1',
            'deadline' => 'nullable|date',
        ]);

        $savingsTarget->update($validated);
        
        // Check if status should change
        if ($savingsTarget->current_amount >= $savingsTarget->target_amount) {
            $savingsTarget->update(['status' => 'completed']);
        } else {
            $savingsTarget->update(['status' => 'ongoing']);
        }

        return redirect()->route('savings-targets.index')->with('success', 'Savings Target updated successfully.');
    }

    public function destroy(SavingsTarget $savingsTarget)
    {
        if ($savingsTarget->user_id !== auth()->id()) abort(403);
        $savingsTarget->delete();
        return redirect()->route('savings-targets.index')->with('success', 'Savings Target deleted successfully.');
    }
}
