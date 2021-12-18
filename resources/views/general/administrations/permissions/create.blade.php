@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/selectize/dist/css/selectize.bootstrap4.css') }}">
@endpush

@section('title', 'New Permission')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
                <span class="breadcrumb-item active">New Permission</span>
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
            <h5 class="card-title">New Permission</h5>
            <div class="header-elements">
                <a href="#" class="btn custom-btn-success mr-2" onclick="event.preventDefault();document.getElementById('submit-form').submit();"><i class="icon-folder-check mr-2"></i>Save</a>
                <a type="button" href="{{ route('permission.index') }}" class="btn custom-btn-success"><i class="icon-arrow-left13 mr-2"></i>Back</a>
            </div>
        </div>

        <div class="card-body">
            <form method="POST" id="submit-form" action="{{ route('permission.store')}}">
                @csrf
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Title</label>
                    <div class="col-lg-10">
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                        @error('title')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror
                        <span class="form-text text-justify text-muted" style="font-size:14px;">
                            only specify crud name.
                            It will automatically generate all related permissions for the crud.
                            e.g. If you want a crud for categories, just put "category" as CRUD name.
                            It will generate follwing permissions for category: category view, category create, category edit, category delete
                        </span>
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
@endpush
