@php use Illuminate\Support\Facades\URL; @endphp
@extends('layout.dashboard')

@section('title', 'Trashed Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="#">Categories</a></li>
    <li class="breadcrumb-item active"><a href="#">Trashed</a></li>
@endsection

@section('content')
    <div class="mb-5 ml-3">
        <a href="{{route('categories.index')}}" class="btn btn-sm btn-outline-primary">Back</a>
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
            <th>Status</th>
            <th>Deleted At</th>
            <th colspan="2"></th>
        </tr>
        </thead>
        <tbody>

        @forelse($categories as $category)
            <tr>
                <th></th>
                <td>{{$loop->index+1}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->status}}</td>
                <td>{{$category->deleted_at}}</td>
                <td>
                    <form action="{{route('categories.restore', $category->id)}}" method="post">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-sm btn-outline-info">Restore</button>
                    </form>
                </td>
                <td>
                    <form action="{{route('categories.force-delete', $category->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Force Delete</button>
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
