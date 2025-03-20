@extends('layouts.admin.app')
@section('title')
Edit user or delivery
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
            <li class="breadcrumb-item active"><a href="{{ route('admin.users.edit', $user->id) }}"
                    title="Update - {{ $user->username }}">Update - {{ $user->username }}</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="col-lg-6">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <input name="id" value="{{ $user->id }}" type="hidden">

                            {{-- user name --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Name </label>
                                <input class="form-control" id="exampleInputEmail1" name="username"
                                    value="{{ $user->username }}" type="text" placeholder="Name">
                                @error('username')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- password --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Password </label>
                                <input class="form-control" id="exampleInputEmail1" name="password"
                                    value="***************" type="password" placeholder="Password">
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- mobile number --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Mobile Number </label>
                                <input class="form-control" id="exampleInputEmail1" name="mobile_number"
                                    value="{{ $user->mobile_number }}" type="text" placeholder="Mobile Number">
                                @error('mobile_number')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- user type --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1"> User Type </label>
                                <select class="form-control" name="user_type">
                                    <option value="user" {{ $user->user_type == 'user' ? 'selected' : '' }}> User
                                    </option>
                                    <option value="delivery" {{ $user->user_type == 'delivery' ? 'selected' : '' }}>
                                        Delivery </option>
                                    <option value="admin" {{ $user->user_type == 'admin' ? 'selected' : '' }}> Admin
                                    </option>
                                </select>
                                @error('user_type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- location --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Location </label>
                                <input class="form-control" id="exampleInputEmail1" name="location_name"
                                    value="{{ $user->location_name }}" type="text" placeholder="Location Name">
                                @error('location_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- longitude --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Longitude </label>
                                <input class="form-control" id="exampleInputEmail1" name="longitude"
                                    value="{{ $user->longitude }}" type="text" placeholder="Longitude">
                                @error('longitude')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- latitude --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Latitude </label>
                                <input class="form-control" id="exampleInputEmail1" name="latitude"
                                    value="{{ $user->latitude }}" type="text" placeholder="Latitude">
                                @error('latitude')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- is verified --}}
                            <div class="form-group
                                ">
                                <label for="exampleInputEmail1"> Is Verified </label>
                                <select class="form-control" name="is_verified">
                                    <option value="1" {{ $user->is_verified == 1 ? 'selected' : '' }}> Yes </option>
                                    <option value="0" {{ $user->is_verified == 0 ? 'selected' : '' }}> No </option>
                                </select>
                                @error('is_verified')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- profile image --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Profile Image </label>
                                <input class="form-control" id="exampleInputEmail1" name="profile_image"
                                    value="{{ $user->profile_image }}" type="file" placeholder="Profile Image">
                                @error('profile_image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection
