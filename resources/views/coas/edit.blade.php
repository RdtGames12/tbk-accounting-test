@extends('layouts.app')

@section('content')

<h3>Edit Chart Of Account</h3>

<form action="{{ route('coas.update', $coa->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">

        <label>Category</label>

        <select name="category_id"
                class="form-select">

            @foreach($categories as $category)

                <option value="{{ $category->id }}"
                    {{ $coa->category_id == $category->id ? 'selected' : '' }}>

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

        <input type="text"
               name="code"
               value="{{ $coa->code }}"
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
               value="{{ $coa->name }}"
               class="form-control">

        @error('name')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror

    </div>

    <button class="btn btn-primary">
        Update
    </button>

    <a href="{{ route('coas.index') }}"
       class="btn btn-secondary">
        Back
    </a>

</form>

@endsection