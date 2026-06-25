<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('coa');

        if ($request->search) {

            $search = $request->search;

            $query->where(
                'description',
                'like',
                "%{$search}%"
            )
            ->orWhereHas(
                'coa',
                function ($q) use ($search) {

                    $q->where(
                        'name',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'code',
                        'like',
                        "%{$search}%"
                    );

                }
            );
        }

        $transactions = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'transactions.index',
            compact('transactions')
        );
    }

    public function create()
    {
        $coas = Coa::orderBy('code')->get();

        return view(
            'transactions.create',
            compact('coas')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'coa_id' => 'required',
            'description' => 'nullable',
            'debit' => 'required|numeric|min:0',
            'credit' => 'required|numeric|min:0',
        ]);

        if ($request->debit > 0 && $request->credit > 0) {
            return back()
                ->withInput()
                ->withErrors([
                    'debit' => 'Debit dan Credit tidak boleh diisi bersamaan.'
                ]);
        }

        Transaction::create([
            'transaction_date' => $request->transaction_date,
            'coa_id' => $request->coa_id,
            'description' => $request->description,
            'debit' => $request->debit,
            'credit' => $request->credit,
        ]);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction created successfully');
    }

    public function edit(Transaction $transaction)
    {
        $coas = Coa::orderBy('code')->get();

        return view(
            'transactions.edit',
            compact(
                'transaction',
                'coas'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'coa_id' => 'required',
            'description' => 'nullable',
            'debit' => 'required|numeric|min:0',
            'credit' => 'required|numeric|min:0',
        ]);

        if ($request->debit > 0 && $request->credit > 0) {
            return back()
                ->withInput()
                ->withErrors([
                    'debit' => 'Debit dan Credit tidak boleh diisi bersamaan.'
                ]);
        }

        $transaction->update([
            'transaction_date' => $request->transaction_date,
            'coa_id' => $request->coa_id,
            'description' => $request->description,
            'debit' => $request->debit,
            'credit' => $request->credit,
        ]);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction updated successfully');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction deleted successfully');
    }
}
