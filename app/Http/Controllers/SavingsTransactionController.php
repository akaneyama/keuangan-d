<?php

namespace App\Http\Controllers;

use App\Models\SavingsTarget;
use App\Models\SavingsTransaction;
use Illuminate\Http\Request;

class SavingsTransactionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'savings_target_id' => 'required|exists:savings_targets,id',
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $target = SavingsTarget::findOrFail($validated['savings_target_id']);
        if ($target->user_id !== auth()->id()) abort(403);

        $transaction = SavingsTransaction::create($validated);

        // Auto update current_amount
        $target->current_amount += $transaction->amount;
        
        if ($target->current_amount >= $target->target_amount) {
            $target->status = 'completed';
        }
        $target->save();

        return redirect()->route('savings-targets.show', $target->id)->with('success', 'Transaction added successfully.');
    }

    public function destroy(SavingsTransaction $savingsTransaction)
    {
        $target = $savingsTransaction->target;
        if ($target->user_id !== auth()->id()) abort(403);

        $amount = $savingsTransaction->amount;
        $savingsTransaction->delete();

        // Reduce amount
        $target->current_amount -= $amount;
        if ($target->current_amount < $target->target_amount) {
            $target->status = 'ongoing';
        }
        $target->save();

        return redirect()->back()->with('success', 'Transaction removed successfully.');
    }
}
