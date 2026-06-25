@extends('layouts.app')

@section('content')

<h3>Add Category</h3>

<form action="{{ route('categories.store') }}"
      method="POST">

    @csrf

    <div class="mb-3">
        <label>Name</label>

        <input type="text"
               name="name"
               class="form-control">

        @error('name')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror

    </div>

    <button class="btn btn-primary">
        Save
    </button>

    <a href="{{ route('categories.index') }}"
       class="btn btn-secondary">
        Back
    </a>

</form>

@endsection