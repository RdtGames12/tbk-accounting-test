<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        Transaction::insert([

            [
                'transaction_date' => '2022-01-01',
                'coa_id' => 1,
                'description' => 'Gaji Di Perusahaan A',
                'debit' => 0,
                'credit' => 5000000,
            ],

            [
                'transaction_date' => '2022-01-02',
                'coa_id' => 2,
                'description' => 'Gaji Ketum',
                'debit' => 0,
                'credit' => 7000000,
            ],

            [
                'transaction_date' => '2022-01-10',
                'coa_id' => 5,
                'description' => 'Bensin',
                'debit' => 25000,
                'credit' => 0,
            ],

            [
                'transaction_date' => '2026-06-01',
                'coa_id' => 1,
                'description' => 'Monthly Salary',
                'debit' => 0,
                'credit' => 8000000,
            ],

            [
                'transaction_date' => '2026-06-03',
                'coa_id' => 3,
                'description' => 'Trading Profit',
                'debit' => 0,
                'credit' => 1500000,
            ],

            [
                'transaction_date' => '2026-06-05',
                'coa_id' => 5,
                'description' => 'Fuel Expense',
                'debit' => 300000,
                'credit' => 0,
            ],

            [
                'transaction_date' => '2026-06-06',
                'coa_id' => 7,
                'description' => 'Lunch Expense',
                'debit' => 150000,
                'credit' => 0,
            ],

            [
                'transaction_date' => '2026-06-08',
                'coa_id' => 6,
                'description' => 'Parking Expense',
                'debit' => 100000,
                'credit' => 0,
            ],

            [
                'transaction_date' => '2026-06-09',
                'coa_id' => 4,
                'description' => 'School Fee',
                'debit' => 800000,
                'credit' => 0,
            ],

            [
                'transaction_date' => '2026-06-11',
                'coa_id' => 3,
                'description' => 'Crypto Profit',
                'debit' => 0,
                'credit' => 2000000,
            ],

            [
                'transaction_date' => '2026-06-12',
                'coa_id' => 7,
                'description' => 'Restaurant Expense',
                'debit' => 250000,
                'credit' => 0,
            ],

            [
                'transaction_date' => '2026-06-13',
                'coa_id' => 5,
                'description' => 'Motorcycle Fuel',
                'debit' => 350000,
                'credit' => 0,
            ],

            [
                'transaction_date' => '2026-06-15',
                'coa_id' => 1,
                'description' => 'Additional Salary',
                'debit' => 0,
                'credit' => 1000000,
            ],
        ]);
    }
}