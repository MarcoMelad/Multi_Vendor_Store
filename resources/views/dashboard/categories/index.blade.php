@php use Illuminate\Support\Facades\URL; @endphp
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

    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between m-4">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')"/>
        <select name="status" class="form-control mx-2">
            <option value="">All</option>
            <option value="active" @selected(request('status') == "active")>Active</option>
            <option value="archived" @selected(request('status') == "archived")>Archived</option>
        </select>
        <button class="btn btn-dark mx-2">Filter</button>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Status</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
        </thead>
        <tbody>

        @forelse($categories as $category)
            <tr>
                <th></th>
                <td>{{$loop->index+1}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->parent_id}}</td>
                <td>{{$category->status}}</td>
                <td>{{$category->created_at}}</td>
                <td>
                    <a href="{{route('categories.edit', $category->id)}}"
                       class="btn btn-sm btn-outline-success">Edit</a>
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

    {{ $categories->withQueryString()->links() }}
@endsection
