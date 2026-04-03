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
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $target = SavingsTarget::findOrFail($validated['savings_target_id']);
        if ($target->user_id !== auth()->id()) abort(403);

        $transaction = SavingsTransaction::create($validated);

        // Auto update current_amount in Target
        $target->increment('current_amount', $transaction->amount);
        
        // Auto update current balance in Account
        $account = \App\Models\Account::findOrFail($validated['account_id']);
        $account->decrement('balance', $transaction->amount);
        
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
        $accountId = $savingsTransaction->account_id;
        $savingsTransaction->delete();

        // Reduce amount in Target
        $target->decrement('current_amount', $amount);
        
        // Revert balance in Account
        if ($accountId) {
            $account = \App\Models\Account::findOrFail($accountId);
            $account->increment('balance', $amount);
        }

        if ($target->current_amount < $target->target_amount) {
            $target->status = 'ongoing';
        }
        $target->save();

        return redirect()->back()->with('success', 'Transaction removed successfully.');
    }
}
