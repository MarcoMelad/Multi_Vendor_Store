@extends('layout.dashboard')

@section('title', 'Edit Profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="#">Edit Profile</a></li>
@endsection

@section('content')
    <form action="{{ route('profile.update')}}" method="post" class="ml-3" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-row">
            <div class="col-md-6">
                <x-form.input name="name" label="Name" :value="$user->profile->name"/>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <x-form.input name="birthday" label="BirthDay" :value="$user->profile->birthday"/>
            </div>
            <div class="col-md-6">
                <x-form.radio name="gender" label="Gender" :options="['male' => 'Male', 'female' => 'Female']"
                              :checked="$user->profile->gender"/>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4">
                <x-form.input name="street_address" label="Street Address" :value="$user->profile->street_address"/>
            </div>
            <div class="col-md-4">
                <x-form.input name="city" label="City" :value="$user->profile->city"/>
            </div>
            <div class="col-md-4">
                <x-form.input name="state" label="State" :value="$user->profile->state"/>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4">
                <x-form.input name="postal_code" label="Postal Code" :value="$user->profile->postal_code"/>
            </div>
            <div class="col-md-4">
                <x-form.select name="country" :options="$countries"  label="Country" :selected="$user->profile->country"/>
            </div>
            <div class="col-md-4">
                <x-form.select name="local" :options="$locales"  label="Locale" :selected="$user->profile->local"/>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
