@extends('layout.dashboard')

@section('title', 'Edit Product')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item "><a href="#">Products</a></li>
    <li class="breadcrumb-item active"><a href="#">Edit Product</a></li>
@endsection

@section('content')
    <form action="{{ route('products.update', $product->id) }}" method="post" class="ml-3">
        @csrf
        @method('put')
        @include('dashboard.products.form')
    </form>
@endsection
