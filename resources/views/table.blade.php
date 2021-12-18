@extends('layouts.app')

@push('css')

@endpush

@section('title', 'Table')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <span class="breadcrumb-item active">Table</span>
            </div>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Basic Data Table</h5>
            <div class="header-elements">
                <a type="button" href="#" class="btn custom-btn-success"><i class="icon-plus3 mr-2"></i>New User</a>
            </div>
        </div>

        <div class="card-body">
            <table class="table datatable-basic">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Field One</th>
                        <th>Field Two</th>
                        <th>Field Status</th>
                        <th>Field Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>#</td>
                        <td>This is field one</td>
                        <td>This is field two</td>
                        <td>
                            <span class="badge badge-success">Complete</span>
                            <span class="badge badge-danger">Pending</span>
                        </td>
                        <td class="text-center">
                            <div class="list-icons">
                                <div class="dropdown">
                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
                                        <a href="#" class="dropdown-item"><i class="icon-bin"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
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
