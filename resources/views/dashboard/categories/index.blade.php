@extends('layout.dashboard')

@section('title', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="#">Categories</a></li>
@endsection

@section('content')
    <div class="mb-5 ml-3">
        <a href="{{route('categories.create')}}" class="btn btn-sm btn-outline-primary">Create</a>
    </div>
    <x-alert type="success"/>
    <x-alert type="info"/>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
        </thead>
        <tbody>

        @forelse($categories as $category)
            <tr>
                <td><img src="{{asset('storage/'. $category->image)}}" alt="" height="50"></td>
                <td>{{$loop->index+1}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->parent_id}}</td>
                <td>{{$category->created_at}}</td>
                <td>
                    <a href="{{route('categories.edit', $category->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                </td>
                <td>
                    <form action="{{route('categories.destroy', $category->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No Categories Defined.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $categories->links() }}
@endsection
