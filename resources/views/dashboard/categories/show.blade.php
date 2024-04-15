@extends('layouts.dashboard')

@section('title', $category->name)

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item "><a href="#">Categories</a></li>
    <li class="breadcrumb-item active"><a href="#">{{$category->name}}</a></li>
@endsection

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
        </thead>
        <tbody>

        @php
            $products = $category->products()->with('store')->paginate(5)
        @endphp

        @forelse($products as $product)
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->store->name}}</td>
                <td>{{$product->status}}</td>
                <td>{{$product->created_at}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No Categories Defined.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $products->links() }}
@endsection
