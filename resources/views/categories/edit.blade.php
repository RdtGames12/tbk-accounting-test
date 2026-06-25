@extends('layouts.app')

@section('content')

<h3>Edit Category</h3>

<form action="{{ route('categories.update',$category->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Name</label>

        <input type="text"
               name="name"
               value="{{ $category->name }}"
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

    <a href="{{ route('categories.index') }}"
       class="btn btn-secondary">
        Back
    </a>

</form>

@endsection