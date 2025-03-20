@extends('layouts.admin.app')
@section('title')
Create new User or Delivery
@endsection
@section('content')
<main class="app sidebar-mini rtl">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> Users and Deliveries </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" title="Users and Deliveries">Users
                    and Deliveries</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('admin.users.create') }}"
                    title="Create new User or Delivery">Create new User or Delivery</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tile">
                <div class="tile-body">
                    <div class="col-lg-6">
                        <form action="{{route('admin.users.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- name --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input class="form-control" id="exampleInputEmail1" name="username"
                                    value="{{old('username')}}" type="text" placeholder="Name">
                                @error('username')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- // password --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input class="form-control" id="exampleInputEmail1" name="password"
                                    value="{{old('password')}}" type="password" placeholder="Password">
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- // mobile number --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mobile Number</label>
                                <input class="form-control" id="exampleInputEmail1" name="mobile_number"
                                    value="{{old('mobile_number')}}" type="text" placeholder="Mobile Number">
                                @error('mobile_number')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- // user type --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">User Type</label>
                                <select class="form-control" name="user_type">
                                    <option value="user">User</option>
                                    <option value="delivery">Delivery</option>
                                    <option value="admin">Admin</option>
                                </select>
                                @error('user_type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- // location --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Location Name</label>
                                <input class="form-control" id="exampleInputEmail1" name="location_name"
                                    value="{{old('location_name')}}" type="text" placeholder="location name">
                                @error('location_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- // longitude --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Longitude</label>
                                <input class="form-control" id="exampleInputEmail1" name="longitude"
                                    value="{{old('longitude')}}" type="text" placeholder="longitude">
                                @error('longitude')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- // latitude --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Latitude</label>
                                <input class="form-control" id="exampleInputEmail1" name="latitude"
                                    value="{{old('latitude')}}" type="text" placeholder="latitude">
                                @error('latitude')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- // is verified --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Is Verified</label>
                                <select class="form-control" name="is_verified">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                @error('is_verified')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- // profile image --}}
                            <div class="form-group">
                                <label for="profile_image">Profile Image</label>
                                <input class="form-control @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image"
                                    type="file">
                                @error('file')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
