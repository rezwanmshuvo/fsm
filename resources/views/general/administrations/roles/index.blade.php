@extends('layouts.app')

@push('css')

@endpush

@section('title', 'Roles')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
                <span class="breadcrumb-item active">Roles</span>
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
            <h5 class="card-title">All Roles</h5>
            <div class="header-elements">
                <a type="button" href="{{ route('role.create') }}" class="btn custom-btn-success"><i class="icon-plus3 mr-2"></i>Add Role</a>
            </div>
        </div>

        <div class="card-body">
            <table class="table datatable-basic">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Name</th>
                        <th>Permissions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>
                            @if($role->name == 'super admin')
                                <span class="badge badge-danger">
                                    Modification restricted
                                </span>
                            @elseif($role->name == 'uncategorized')
                                <span class="badge badge-danger">
                                    Modification restricted
                                </span>
                            @else
                            <div class="list-icons">
                                <div class="dropdown">
                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="{{ route('role.edit', $role->id) }}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
                                        <a href="{{ route('dashboard') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('delete-form').submit();"><i class="icon-bin"></i> Delete</a>
                                        <form id="delete-form" action="{{ route('role.destroy', $role->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>
                        <td>{{ ucfirst($role->name) }}</td>
                        <td>
                            @if($role->permissions->isEmpty())
                                <span class="badge badge-danger mb-2" style="font-size: 12px;">
                                    No permissions
                                </span>
                            @else
                                @foreach($role->permissions as $permission)
                                    <span class="badge badge-success mb-2" style="font-size: 12px;">
                                        {{ str_replace(['-', '_'], ' ', $permission->name) }}
                                    </span>
                                @endforeach
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
