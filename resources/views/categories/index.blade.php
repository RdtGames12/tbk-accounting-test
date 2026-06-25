@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h3>Categories</h3>

    <a href="{{ route('categories.create') }}"
       class="btn btn-primary">
       Add Category
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
                placeholder="Search category..."
                value="{{ request('search') }}">
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-secondary w-100" type="submit">
                Search
            </button>
        </div>
    </div>
</form>
<table class="table table-bordered">
    <thead>
        <tr>
            <th width="10%">No</th>
            <th>Name</th>
            <th width="20%">Action</th>
        </tr>
    </thead>

    <tbody>

        @forelse($categories as $key => $category)

        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $category->name }}</td>

            <td>

                <a href="{{ route('categories.edit',$category->id) }}"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="{{ route('categories.destroy',$category->id) }}"
                      method="POST"
                      style="display:inline">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete data?')">
                        Delete
                    </button>

                </form>

            </td>
        </tr>

        @empty

        <tr>
            <td colspan="3" class="text-center">
                No Data
            </td>
        </tr>

        @endforelse

    </tbody>
</table>

{{ $categories->links() }}

@endsection