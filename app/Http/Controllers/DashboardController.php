<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coa;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategory = Category::count();

        $totalCoa = Coa::count();

        $totalTransaction = Transaction::count();

        $totalIncome = Transaction::sum('credit');

        $totalExpense = Transaction::sum('debit');

        $netProfit = $totalIncome - $totalExpense;

        return view(
            'dashboard',
            compact(
                'totalCategory',
                'totalCoa',
                'totalTransaction',
                'totalIncome',
                'totalExpense',
                'netProfit'
            )
        );
    }
}
