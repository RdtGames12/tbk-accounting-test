@extends('layouts.app')

@section('content')

<h3>Add Chart Of Account</h3>

<form action="{{ route('coas.store') }}"
      method="POST">

    @csrf

    <div class="mb-3">
        <label>Category</label>

        <select name="category_id"
                class="form-select">

            <option value="">
                Choose Category
            </option>

            @foreach($categories as $category)

                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>

            @endforeach

        </select>

        @error('category_id')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror

    </div>

    <div class="mb-3">
        <label>Code</label>

        <input
            type="text"
            name="code"
            class="form-control"
            maxlength="20"
            required>

        @error('code')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror

    </div>

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

    <a href="{{ route('coas.index') }}"
       class="btn btn-secondary">
        Back
    </a>

</form>

@endsection