@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Transactions</h3>

    <a href="{{ route('transactions.create') }}"
       class="btn btn-primary">
        Add Transaction
    </a>
</div>

<form method="GET"
      class="mb-3">
    <div class="row gx-2 align-items-center">
        <div class="col">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search transaction..."
                value="{{ request('search') }}">
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-secondary w-100" type="submit">
                Search
            </button>
        </div>
    </div>
</form>
<table class="table table-bordered table-striped">

    <thead>
        <tr>
            <th>No</th>
            <th>Date</th>
            <th>Chart Of Account</th>
            <th>Description</th>
            <th>Debit</th>
            <th>Credit</th>
            <th width="20%">Action</th>
        </tr>
    </thead>

    <tbody>

        @forelse($transactions as $transaction)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $transaction->transaction_date }}
            </td>

            <td>
                {{ $transaction->coa->code }}
                -
                {{ $transaction->coa->name }}
            </td>

            <td>
                {{ $transaction->description }}
            </td>

            <td>
               Rp {{ number_format($transaction->debit,0,',','.') }}
            </td>

            <td>
               Rp {{ number_format($transaction->credit,0,',','.') }}
            </td>

            <td>

                <a href="{{ route('transactions.edit',$transaction->id) }}"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="{{ route('transactions.destroy',$transaction->id) }}"
                      method="POST"
                      style="display:inline">

                    @csrf
                    @method('DELETE')

                    <button
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Delete data?')">

                        Delete

                    </button>

                </form>

            </td>

        </tr>

        @empty

        <tr>
            <td colspan="6"
                class="text-center">

                No Data

            </td>
        </tr>

        @endforelse

    </tbody>

</table>
{{ $transactions->links() }}

@endsection