@extends('layout.dashboard')

@section('title', 'Creat Category')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="#">Categories</a></li>
    <li class="breadcrumb-item active"><a href="#">Creat Category</a></li>
@endsection

@section('content')
    <form action="{{ route('categories.store') }}" method="post" class="ml-3">
        @csrf
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <div class="form-group">
                <label for="">Category Name</label>
                <input type="text" name="name"
                       value="{{ old('name') }}"  class="form-control"/>
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Category Parent</label>
                <select name="parent_id" class="form-control form-select">
                    <option value="">Primary Category</option>
                    @foreach($parents as $parent)
                        <option
                            value="{{$parent->id}}"
                            @selected(old('parent_id'))>{{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">Description</label>
                <textarea name="description" class="form-control">{{old('description')}}</textarea>
            </div>
            <div class="form-group">
                <label for="">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="form-group">
                <label for="">Status</label>
                <div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status"
                               value="active" @checked(old('status')) >
                        <label class="form-check-label">
                            Active
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status"
                               value="archived" @checked(old('status'))>
                        <label class="form-check-label">
                            Archived
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-outline-primary">Save</button>
            </div>
        </div>

    </form>
@endsection
