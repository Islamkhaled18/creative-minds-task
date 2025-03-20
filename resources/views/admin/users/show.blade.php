@extends('layouts.admin.app')
@section('title')
User or delivery
@endsection
@section('content')
<main class="app sidebar-mini rtl">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> Users or Deliveries </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" title="Users or Deliveries">Users or
                    Deliveries</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('admin.users.show', $user->id) }}"
                    title="{{ $user->username }}">{{ $user->username }}</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="col-lg-6">

                        {{-- user name --}}
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Name </label>
                            <input class="form-control" id="exampleInputEmail1" name="username"
                                value="{{ $user->username }}" type="text" placeholder="Name" disabled>

                        </div>

                        {{-- mobile number --}}
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Mobile Number </label>
                            <input class="form-control" id="exampleInputEmail1" name="mobile_number"
                                value="{{ $user->mobile_number }}" type="text" placeholder="Mobile Number" disabled>

                        </div>

                        {{-- user type --}}
                        <div class="form-group">
                            <label for="exampleInputEmail1"> User Type </label>
                            <select class="form-control" name="user_type" disabled>
                                <option value="user" {{ $user->user_type == 'user' ? 'selected' : '' }}> User
                                </option>
                                <option value="delivery" {{ $user->user_type == 'delivery' ? 'selected' : '' }}>
                                    Delivery </option>
                                <option value="admin" {{ $user->user_type == 'admin' ? 'selected' : '' }}> Admin
                                </option>
                            </select>

                        </div>

                        {{-- location --}}
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Location </label>
                            <input class="form-control" id="exampleInputEmail1" name="location_name"
                                value="{{ $user->location_name }}" type="text" placeholder="Location Name" disabled>

                        </div>

                        {{-- longitude --}}
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Longitude </label>
                            <input class="form-control" id="exampleInputEmail1" name="longitude"
                                value="{{ $user->longitude }}" type="text" placeholder="Longitude" disabled>

                        </div>

                        {{-- latitude --}}
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Latitude </label>
                            <input class="form-control" id="exampleInputEmail1" name="latitude"
                                value="{{ $user->latitude }}" type="text" placeholder="Latitude" disabled>
                        </div>

                        {{-- is verified --}}
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Is Verified </label>
                            <select class="form-control" name="is_verified" disabled>
                                <option value="1" {{ $user->is_verified == 1 ? 'selected' : '' }}> Yes </option>
                                <option value="0" {{ $user->is_verified == 0 ? 'selected' : '' }}> No </option>
                            </select>
                        </div>

                        {{-- profile image --}}
                        <label for="exampleInputEmail1"> Profile Image </label>
                        <div class="form-group"><img src="{{ asset('storage/' . $user->profile_image) }}"
                            title="{{ $user->username }}" alt="{{ $user->username }}" width="120" height="120">
                        </div>

                        {{-- thumbnail image --}}
                        <label for="exampleInputEmail1"> thumbnail Image </label>
                        <div class="form-group"><img src="{{ asset('storage/' . $user->thumbnail) }}"
                            title="{{ $user->username }}" alt="{{ $user->username }}" width="120" height="120">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection
