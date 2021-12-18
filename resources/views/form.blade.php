@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/selectize/dist/css/selectize.bootstrap4.css') }}">
@endpush

@section('title', 'Form')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <span class="breadcrumb-item active">Form</span>
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
            <h5 class="card-title">Basic Form</h5>
            <div class="header-elements">
                <a type="button" href="#" class="btn custom-btn-success"><i class="icon-plus3 mr-2"></i>New User</a>
            </div>
        </div>

        <div class="card-body">
            <form action="#">
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default input modal</label>
                    <div class="col-lg-10">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_large">Launch <i class="icon-play3 ml-2"></i></button>
                    </div>

                    <!-- Large modal -->
                    <div id="modal_large" class="modal fade" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Large modal</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <form action="#">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Default input Alert Success</label>
                                            <div class="col-lg-10">
                                                <div class="alert alert-success border-0 alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                                                    <span class="font-weight-semibold">Well done!</span> You successfully read <a href="#" class="alert-link">this important</a> alert message.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Default input Alert Danger</label>
                                            <div class="col-lg-10">
                                                <div class="alert alert-danger border-0 alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                                                    <span class="font-weight-semibold">Oh snap!</span> Change a few things up and <a href="#" class="alert-link">try submitting again</a>.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Default text input</label>
                                            <div class="col-lg-10">
                                                <input type="text" name="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Default password input</label>
                                            <div class="col-lg-10">
                                                <input type="password" name="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Default select2 input</label>
                                            <div class="col-lg-10">
                                                <select name="active_status" class="form-control select-search">
                                                    <option value="">Selelct Active Status</option>
                                                    <option value="1" >Active</option>
                                                    <option value="0" >Deactive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Default Multi select2 input</label>
                                            <div class="col-lg-10">
                                                <select multiple="multiple" class="form-control select-search" data-fouc>
                                                    <option value="AZ">Arizona</option>
                                                    <option value="CO">Colorado</option>
                                                    <option value="ID">Idaho</option>
                                                    <option value="WY">Wyoming</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Default DateTime input</label>
                                            <div class="col-lg-10">
                                                <input type="text" class="form-control" id="anytime-both2" value="{{ date('d-m-Y g:i:s A', strtotime(now()) ) }}" readonly="">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Default File input</label>
                                            <div class="col-lg-10">
                                                <input type="file" class="form-control-uniform-custom">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Default Checkbox input</label>
                                            <div class="col-lg-10">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input-styled-success" checked data-fouc>
                                                        checkbox
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input-styled-success" data-fouc>
                                                        checkbox
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input-styled-success" data-fouc>
                                                        checkbox
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Default Checkbox input</label>
                                            <div class="col-lg-10">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="radio-styled-color" class="form-check-input-styled-success" data-fouc>
                                                        Radio
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="radio-styled-color" class="form-check-input-styled-success" data-fouc>
                                                        Radio
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="radio-styled-color" class="form-check-input-styled-success" data-fouc>
                                                        Radio
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Default Checkbox input</label>
                                            <div class="col-lg-10">
                                                <div class="form-check form-check-switchery">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input-switchery-primary" checked data-fouc>
                                                        switch
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-switchery">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input-switchery-primary" data-fouc>
                                                        switch
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Default input Group</label>
                                            <div class="col-lg-10">
                                                <div class="input-group">
                                                    <span class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </span>
                                                    <input type="text" class="form-control" placeholder="Left and right addons">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Default input Group</label>
                                            <div class="col-lg-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Left and right addons">
                                                    <span class="input-group-prepend">
                                                        <span class="input-group-text">%</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Default input Group Dropdown</label>
                                            <div class="col-lg-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Left and right dropdowns">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-light custom-input-group-dropdown-btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action</button>
                                                        <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(968px, -2px, 0px);">
                                                            <a href="#" class="dropdown-item">Action</a>
                                                            <a href="#" class="dropdown-item">Another action</a>
                                                            <a href="#" class="dropdown-item">Something else here</a>
                                                            <a href="#" class="dropdown-item">One more line</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Default input Button</label>
                                            <div class="col-lg-10">
                                                <button type="button" class="btn btn-primary">Default button</button>
                                                <button type="button" class="btn btn-danger">Default button</button>
                                                <button type="button" class="btn btn-warning">Default button</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /large modal -->
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default input Alert Success</label>
                    <div class="col-lg-10">
                        <div class="alert alert-success border-0 alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                            <span class="font-weight-semibold">Well done!</span> You successfully read <a href="#" class="alert-link">this important</a> alert message.
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default input Alert Danger</label>
                    <div class="col-lg-10">
                        <div class="alert alert-danger border-0 alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                            <span class="font-weight-semibold">Oh snap!</span> Change a few things up and <a href="#" class="alert-link">try submitting again</a>.
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default text input</label>
                    <div class="col-lg-10">
                        <input type="text" name="" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default password input</label>
                    <div class="col-lg-10">
                        <input type="password" name="" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default select2 input</label>
                    <div class="col-lg-10">
                        <select name="active_status" class="form-control select-search">
                            <option value="">Selelct Active Status</option>
                            <option value="1" >Active</option>
                            <option value="0" >Deactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default Multi select2 input</label>
                    <div class="col-lg-10">
                        <select multiple="multiple" class="form-control select-search" data-fouc>
                            <option value="AZ">Arizona</option>
                            <option value="CO">Colorado</option>
                            <option value="ID">Idaho</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default DateTime input</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="anytime-both" value="{{ date('d-m-Y g:i:s A', strtotime(now()) ) }}" readonly="">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default File input</label>
                    <div class="col-lg-10">
                        <input type="file" class="form-control-uniform-custom">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default Checkbox input</label>
                    <div class="col-lg-10">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input-styled-success" checked data-fouc>
                                checkbox
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input-styled-success" data-fouc>
                                checkbox
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input-styled-success" data-fouc>
                                checkbox
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default Checkbox input</label>
                    <div class="col-lg-10">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" name="radio-styled-color" class="form-check-input-styled-success" data-fouc>
                                Radio
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" name="radio-styled-color" class="form-check-input-styled-success" data-fouc>
                                Radio
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" name="radio-styled-color" class="form-check-input-styled-success" data-fouc>
                                Radio
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default Checkbox input</label>
                    <div class="col-lg-10">
                        <div class="form-check form-check-switchery">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input-switchery-primary" checked data-fouc>
                                switch
                            </label>
                        </div>
                        <div class="form-check form-check-switchery">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input-switchery-primary" data-fouc>
                                switch
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default input Group</label>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </span>
                            <input type="text" class="form-control" placeholder="Left and right addons">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default input Group</label>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Left and right addons">
                            <span class="input-group-prepend">
                                <span class="input-group-text">%</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default input Group Dropdown</label>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Left and right dropdowns">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-light custom-input-group-dropdown-btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action</button>
                                <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(968px, -2px, 0px);">
                                    <a href="#" class="dropdown-item">Action</a>
                                    <a href="#" class="dropdown-item">Another action</a>
                                    <a href="#" class="dropdown-item">Something else here</a>
                                    <a href="#" class="dropdown-item">One more line</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Default input Button</label>
                    <div class="col-lg-10">
                        <button type="button" class="btn btn-primary">Default button</button>
                        <button type="button" class="btn btn-danger">Default button</button>
                        <button type="button" class="btn btn-warning">Default button</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->

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

    <script>
        $(document).ready(function() {
            $('.select-search').selectize({
                create: true,
                sortField: 'text'
            });

            // Date and time
            $('#anytime-both').AnyTime_picker({
                format: '%d-%m-%Y %h:%i:%s %p',
            });

            // Date and time
            $('#anytime-both2').AnyTime_picker({
                format: '%d-%m-%Y %h:%i:%s %p',
            });
        });
    </script>


@endpush
