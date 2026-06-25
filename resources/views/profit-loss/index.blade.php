@extends('layouts.app')

@section('content')

<h3>Profit Loss Report</h3>

<form method="GET">

    <div class="row mb-3">

        <div class="col-md-3">
            <label>Start Date</label>

            <input
                type="date"
                name="start_date"
                class="form-control"
                value="{{ $startDate }}">
        </div>

        <div class="col-md-3">
            <label>End Date</label>

            <input
                type="date"
                name="end_date"
                class="form-control"
                value="{{ $endDate }}">
        </div>

        <div class="col-md-2 mt-4">

            <button class="btn btn-primary">
                Filter
            </button>

        </div>

    </div>

</form>
<div class="row mb-4">

    <div class="col-md-4">

        <div class="card">

            <div class="card-body">

                <h5>Total Income</h5>

                <h3>
                    Rp {{ number_format($totalIncome,0,',','.') }}
                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card">

            <div class="card-body">

                <h5>Total Expense</h5>

                <h3>
                    Rp {{ number_format($totalExpense,0,',','.') }}
                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card">

            <div class="card-body">

                <h5>Net Profit</h5>

                <h3>
                    Rp {{ number_format($netProfit,0,',','.') }}
                </h3>

            </div>

        </div>

    </div>

</div>
<a href="{{ route('profit-loss.export', [
        'start_date' => request('start_date'),
        'end_date' => request('end_date')
    ]) }}"
   class="btn btn-success">
    Export Excel
</a>
<br><br>
<table class="table table-bordered">

    <thead>

        <tr>
            <th>No</th>
            <th>Date</th>
            <th>Category</th>
            <th>Chart Of Account</th>
            <th>Debit</th>
            <th>Credit</th>
        </tr>

    </thead>

    <tbody>

        @foreach($transactions as $transaction)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $transaction->transaction_date }}
            </td>

            <td>
                {{ $transaction->coa->category->name }}
            </td>

            <td>
                {{ $transaction->coa->code }}
                -
                {{ $transaction->coa->name }}
            </td>

            <td>
                Rp {{ number_format($transaction->debit,0,',','.') }}
            </td>

            <td>
                {{ number_format($transaction->credit,0,',','.') }}
            </td>

        </tr>

        @endforeach

    </tbody>

</table>
{{ $transactions->links() }}
@endsection