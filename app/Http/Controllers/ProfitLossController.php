<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\ProfitLossExport;
use Maatwebsite\Excel\Facades\Excel;

class ProfitLossController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $query = Transaction::with(['coa.category']);

        if ($startDate && $endDate) {
            $query->whereBetween(
                'transaction_date',
                [$startDate, $endDate]
            );
        }

        $totalIncome = (clone $query)->sum('credit');
        $totalExpense = (clone $query)->sum('debit');
        $netProfit = $totalIncome - $totalExpense;

        $transactions = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'profit-loss.index',
            compact(
                'transactions',
                'totalIncome',
                'totalExpense',
                'netProfit',
                'startDate',
                'endDate'
            )
        );
    }
    public function export(Request $request)
    {
        return Excel::download(
            new ProfitLossExport(
                $request->start_date,
                $request->end_date
            ),
            'profit-loss.xlsx'
        );
    }
}