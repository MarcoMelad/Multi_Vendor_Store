@php use Illuminate\Support\Facades\URL; @endphp
@extends('layouts.dashboard')

@section('title', 'Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="#">Products</a></li>
@endsection

@section('content')
    <div class="mb-5 ml-3">
        <a href="{{route('products.create')}}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
{{--        <a href="{{route('categories.trash')}}" class="btn btn-sm btn-outline-dark">Trash</a>--}}
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
            <th>Category</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
        </thead>
        <tbody>

        @forelse($products as $product)
            <tr>
                <th></th>
                <td>{{$loop->index+1}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->category->name}}</td>
                <td>{{$product->store->name}}</td>
                <td>{{$product->status}}</td>
                <td>{{$product->created_at}}</td>
                <td>
                    <a href="{{route('products.edit', $product->id)}}"
                       class="btn btn-sm btn-outline-success">Edit</a>
                </td>
                <td>
                    <form action="{{route('products.destroy', $product->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">No Categories Defined.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $products->withQueryString()->links() }}
@endsection
