@extends('layout.dashboard')

@section('title', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="#">Categories</a></li>
@endsection

@section('content')
    <form action="{{ route('categories.store') }}" method="post" class="ml-3">
        @csrf
        @include('dashboard.categories.form')
    </form>
@endsection
