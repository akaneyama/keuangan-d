<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::ownedByUser()->latest()->get();
        return view('accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cash,bank,e-wallet',
            'balance' => 'required|numeric',
        ]);

        Account::create($validated);

        return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
    }

    public function show(Account $account)
    {
        if ($account->user_id !== auth()->id()) abort(403);
        return view('accounts.show', compact('account'));
    }

    public function edit(Account $account)
    {
        if ($account->user_id !== auth()->id()) abort(403);
        return view('accounts.edit', compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        if ($account->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cash,bank,e-wallet',
            'balance' => 'required|numeric',
        ]);

        $account->update($validated);

        return redirect()->route('accounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy(Account $account)
    {
        if ($account->user_id !== auth()->id()) abort(403);
        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }
}
