@extends('layouts.app')

@section('content')

<h3>Edit Transaction</h3>

<form action="{{ route('transactions.update', $transaction->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Date</label>

        <input type="date"
               name="transaction_date"
               class="form-control"
               value="{{ $transaction->transaction_date }}">
    </div>

    <div class="mb-3">
        <label>Chart Of Account</label>

        <select name="coa_id" class="form-select">

            @foreach($coas as $coa)

                <option value="{{ $coa->id }}"
                    {{ $transaction->coa_id == $coa->id ? 'selected' : '' }}>

                    {{ $coa->code }} - {{ $coa->name }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="mb-3">
        <label>Description</label>

        <textarea name="description"
          class="form-control">{{ $transaction->description }}</textarea>
    </div>

    <div class="mb-3">
        <label>Debit</label>

        <input type="number"
               name="debit"
               class="form-control"
               value="{{ $transaction->debit }}">
    </div>

    <div class="mb-3">
        <label>Credit</label>

        <input type="number"
               name="credit"
               class="form-control"
               value="{{ $transaction->credit }}">
    </div>

    <button class="btn btn-primary">
        Save
    </button>

</form>

@endsection