@extends('layouts.dashboard')

@section('title', 'Edit Category')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item "><a href="#">Categories</a></li>
    <li class="breadcrumb-item active"><a href="#">Edit Category</a></li>
@endsection

@section('content')
    <form action="{{ route('categories.update', $category->id) }}" method="post" class="ml-3">
        @csrf
        @method('put')
        @include('dashboard.categories.form')
    </form>
@endsection

