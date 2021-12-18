@extends('layouts.app')

@push('css')

@endpush

@section('title', 'Users')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
                <span class="breadcrumb-item active">Users</span>
            </div>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card" style="min-height:550px!important;">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">All Users</h5>
            @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('user create'))
                <div class="header-elements">
                    <a type="button" href="{{ route('user.create') }}" class="btn custom-btn-success"><i class="icon-plus3 mr-2"></i>Add User</a>
                </div>
            @endif
        </div>

        <div class="card-body">
            <table class="table datatable-basic">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Role</th>
                        <th>User Name</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            @if (Auth::user()->id === $user->id)
                                <span class="badge badge-danger">
                                    Self modification restricted
                                </span>
                            @elseif(($user->id === 1) || ($user->id === 2))
                                <span class="badge badge-danger">
                                    Modification restricted
                                </span>
                            @else
                                @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('user edit') || auth()->user()->can('user delete'))
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('user edit'))
                                                <a href="{{ route('user.edit', $user->username) }}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
                                            @endif

                                            @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('delete edit'))
                                                <a href="{{ route('dashboard') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('delete-form').submit();"><i class="icon-bin"></i> Delete</a>
                                                <form id="delete-form" action="{{ route('user.destroy', $user->username) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <span class="badge badge-danger">
                                        Modification restricted
                                    </span>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($user->roles->isEmpty())
                                <span class="badge badge-danger mb-2" style="font-size: 12px;">
                                    No role
                                </span>
                            @else
                                @foreach($user->roles as $role)
                                    <span class="badge badge-success mb-2" style="font-size: 12px;">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('user.show', $user->username) }}" class="font-weight-bolder">{{ $user->username }}</a>
                        </td>
                        <td>{{ ucfirst($user->name) }}</td>
                        <td>
                            @if($user->email == null)
                                Not set
                            @else
                                {{ $user->email }}
                            @endif
                        </td>
                        <td>
                            @if($user->phone == null)
                                Not set
                            @else
                                {{ $user->phone }}
                            @endif
                        </td>
                        <td>
                            @if($user->address == null)
                                Not set
                            @else
                                {{ $user->address }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /form inputs -->

</div>
<!-- /content area -->
@endsection

@push('js')
	<!-- Theme JS files -->
	<script src="{{ asset('assets/global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/global_assets/js/demo_pages/datatables_basic.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            // Basic datatable
            $('.datatable-basic').DataTable({
                responsive: true
            });
        });

    </script>
@endpush
