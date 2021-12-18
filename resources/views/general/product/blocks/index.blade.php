@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/selectize/dist/css/selectize.bootstrap4.css') }}">
@endpush

@section('title', 'Blocks')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                <span class="breadcrumb-item active">Blocks</span>
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
            <h5 class="card-title">Blocks</h5>
            <div class="header-elements">
                <a type="button" href="" class="btn custom-btn-success" data-toggle="modal" data-target="#create_modal"><i class="icon-plus3 mr-2"></i>Add Block</a>
            </div>
        </div>

        <div class="card-body">
            <table class="table datatable-basic">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Godown</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <div class="list-icons">
                                <div class="dropdown">
                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#edit_modal"><i class="icon-pencil7"></i> Edit</a>
                                        <a href="#" class="dropdown-item"><i class="icon-bin"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>#</td>
                        <td>Block One</td>
                        <td>NULL</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /form inputs -->

    <!-- create modal -->
    <div id="create_modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Block</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
                        <form action="#">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Block Name</label>
                                <div class="col-lg-10">
                                    <input type="text" name="" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Parent Godown</label>
                                <div class="col-lg-10">
                                    <select name="active_status" class="form-control select-search">
                                        <option value="">Selelct Parent Godown</option>
                                        <option value="1" >Godown one</option>
                                        <option value="0" >Godown two</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-bottom: -20px!important;;">
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-primary float-right">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /create modal -->

    <!-- edit modal -->
    <div id="edit_modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Block</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
                        <form action="#">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Block Name</label>
                                <div class="col-lg-10">
                                    <input type="text" name="" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Parent Godown</label>
                                <div class="col-lg-10">
                                    <select name="active_status" class="form-control select-search">
                                        <option value="">Selelct Parent Godown</option>
                                        <option value="1" >Godown one</option>
                                        <option value="0" >Godown two</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-bottom: -20px!important;;">
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-primary float-right">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /edit modal -->
</div>
<!-- /content area -->
@endsection

@push('js')
    <!-- Theme JS files -->
    <script src="{{ asset('assets/global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/forms/styling/switch.min.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/demo_pages/form_checkboxes_radios.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/selectize/dist/js/standalone/selectize.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/demo_pages/form_inputs.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/pickers/anytime.min.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/global_assets/js/demo_pages/datatables_basic.js') }}"></script> --}}

    <script>
        $(document).ready(function() {

            $('.select-search').selectize({
                create: true,
                sortField: 'text'
            });
            // Basic datatable
            $('.datatable-basic').DataTable({
                responsive: true
            });

            // Date and time
            $('#anytime-both').AnyTime_picker({
                format: '%M %D %H:%i',
            });
        });

    </script>
@endpush
