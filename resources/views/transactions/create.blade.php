@extends('layouts.app')

@section('content')

<h3>Add Transaction</h3>

<form action="{{ route('transactions.store') }}"
      method="POST">

    @csrf

    <div class="mb-3">
        <label>Date</label>

        <input type="date"
               name="transaction_date"
               class="form-control"
               value="{{ old('transaction_date') }}">
    </div>

    <div class="mb-3">
        <label>COA</label>

        <select name="coa_id"
                class="form-select">

            <option value="">
                Choose COA
            </option>

            @foreach($coas as $coa)

            <option value="{{ $coa->id }}">
                {{ $coa->code }}
                -
                {{ $coa->name }}
            </option>

            @endforeach

        </select>

    </div>

    <div class="mb-3">
        <label>Description</label>

        <textarea name="description"
                  class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Debit</label>

        <input type="number"
               name="debit"
               class="form-control"
               value="0">
    </div>

    <div class="mb-3">
        <label>Credit</label>

        <input type="number"
               name="credit"
               class="form-control"
               value="0">
    </div>

    <button class="btn btn-primary">
        Save
    </button>

</form>

@endsection