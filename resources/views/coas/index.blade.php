@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Master Chart Of Account</h3>

    <a href="{{ route('coas.create') }}"
       class="btn btn-primary">
        Add Chart Of Account
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
                placeholder="Search chart of account..."
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
            <th width="5%">No</th>
            <th>Category</th>
            <th>Code</th>
            <th>Name</th>
            <th width="20%">Action</th>
        </tr>
    </thead>

    <tbody>

    @forelse($coas as $key => $coa)

        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $coa->category->name }}</td>
            <td>{{ $coa->code }}</td>
            <td>{{ $coa->name }}</td>

            <td>
                <a href="{{ route('coas.edit', $coa->id) }}"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="{{ route('coas.destroy', $coa->id) }}"
                      method="POST"
                      style="display:inline">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete this data?')">
                        Delete
                    </button>

                </form>
            </td>
        </tr>

    @empty

        <tr>
            <td colspan="5" class="text-center">
                No Data
            </td>
        </tr>

    @endforelse

    </tbody>
</table>
{{ $coas->links() }}

@endsection