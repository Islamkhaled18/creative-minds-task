@extends('layouts.admin.app')
@section('title')
All Users and Deliveries
@endsection
@section('content')
<main class="app sidebar-mini rtl">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> All Users and Deliveries </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a></li>
            <li class="breadcrumb-item active"><a href="{{ route('admin.users.index') }}"
                    title="All Users and Deliveries">All Users and Deliveries</a></li>
        </ul>
    </div>
    <div>
        <a class="btn btn-primary btn-sm" href="{{ route('admin.users.create') }}"
            title="Create new User or Delivery">Create new User or Delivery</a>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User name</th>
                                <th>User Type</th>
                                <th>Mobile Number</th>
                                <th>Verified</th>
                                <th>Location</th>
                                <th>Profile Image</th>
                                <th>Verified ?</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>

                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->user_type }}</td>
                                <td>{{ $user->mobile_number }}</td>
                                <td>{{ $user->is_verified == 1 ? 'Yes' : 'No' }}</td>
                                <td>{{ $user->location_name }}</td>
                                <td>
                                    @if($user->profile_image && file_exists(public_path('storage/' . $user->profile_image)))
                                        <img src="{{ asset('storage/' . $user->profile_image) }}"
                                             title="{{ $user->username }}"
                                             alt="{{ $user->username }}"
                                             width="60"
                                             height="60">
                                    @else
                                        <div style="width: 60px; height: 60px; background-color: #eee; text-align: center; line-height: 60px; border-radius: 50%;">
                                            {{ strtoupper(substr($user->username, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <input type="checkbox" class="verified-checkbox" data-user-id="{{ $user->id }}" {{
                                        $user->is_verified ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-dark" title="Update"
                                        href="{{ route('admin.users.edit', $user) }}">Update</a>

                                        <a class="btn btn-sm btn-info" title="Show"
                                        href="{{ route('admin.users.show', $user) }}">Show</a>

                                    <form action="{{ route('admin.users.destroy', $user ) }}" method="post"
                                        style="display: inline-block">
                                        @csrf
                                        @method('delete')
                                        <button type="'submit" title="Delete" class="btn btn-danger delete btn-sm"><i
                                                class="fa fa-trash"></i>Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script type="text/javascript">
    $('#sampleTable').DataTable();

</script>
<!-- Google analytics script-->
<script type="text/javascript">
    if (document.location.hostname == 'pratikborsadiya.in') {
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o)
                , m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-72504830-1', 'auto');
        ga('send', 'pageview');
    }
    $(document).ready(function() {
        $('.verified-checkbox').change(function() {
            var userId = $(this).data('user-id');
            var isVerified = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('admin.users.updateVerifiedStatus') }}",
                method: 'POST',
                data: {
                    user_id: userId,
                    is_verified: isVerified,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        window.location.reload();
                    } else {
                        alert('Failed to update verified status.');
                    }
                },
                error: function() {
                    alert('An error occurred while updating the verified status.');
                }
            });
        });
    });
</script>
@endpush
