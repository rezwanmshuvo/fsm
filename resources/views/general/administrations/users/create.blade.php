@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/selectize/dist/css/selectize.bootstrap4.css') }}">
@endpush

@section('title', 'New User')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
                <span class="breadcrumb-item active">New User</span>
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
            <h5 class="card-title">New User</h5>
            <div class="header-elements">
                <a href="#" class="btn custom-btn-success mr-2" onclick="event.preventDefault();document.getElementById('submit-form').submit();"><i class="icon-folder-check mr-2"></i>Save</a>
                <a type="button" href="{{ route('user.index') }}" class="btn custom-btn-success"><i class="icon-arrow-left13 mr-2"></i>Back</a>
            </div>
        </div>

        <div class="card-body">
            <form method="POST" id="submit-form" action="{{ route('user.store')}}">
                @csrf
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Role</label>
                    <div class="col-lg-10">
                        <select name="role" id="role-select" class="form-control role-select @error('role') is-invalid @enderror">
                            <option value="">Select role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ (old('role')) ? 'selected':'' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">User Name</label>
                    <div class="col-lg-10">
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Full Name</label>
                    <div class="col-lg-10">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Email</label>
                    <div class="col-lg-10">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Phone</label>
                    <div class="col-lg-10">
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Address</label>
                    <div class="col-lg-10">
                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Password</label>
                    <div class="col-lg-10">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Confirm Password</label>
                    <div class="col-lg-10">
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
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
        // $(document).ready(function() {
        //     $('#select-all-checkbox').click(function() {
        //         $('input[type="checkbox"]').prop('checked', this.checked);
        //     })
        // });

        $('.role-select').selectize({
                create: false,
                sortField: 'text'
        });

        function checkSelectedAll(me){
            var divid = $(me).parent().attr('id');
            var inp = $("#" + divid).find("input");
            inp.prop("checked", !inp.prop("checked"));
            $(me).toggleClass("badge-success");
        }

    </script>
@endpush
