@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/selectize/dist/css/selectize.bootstrap4.css') }}">
@endpush

@section('title', 'New Role')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
                <span class="breadcrumb-item active">New Role</span>
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
            <h5 class="card-title">New Role</h5>
            <div class="header-elements">
                <a href="#" class="btn custom-btn-success mr-2" onclick="event.preventDefault();document.getElementById('submit-form').submit();"><i class="icon-folder-check mr-2"></i>Save</a>
                <a type="button" href="{{ route('role.index') }}" class="btn custom-btn-success"><i class="icon-arrow-left13 mr-2"></i>Back</a>
            </div>
        </div>

        <div class="card-body">
            <form method="POST" id="submit-form" action="{{ route('role.store')}}">
                @csrf
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Title</label>
                    <div class="col-lg-10">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">
                        Related Permissions
                    </label>
                    <div class="col-12">
                        <div class="bg-light p-3">
                            @error('permissions')
                                <div class="text-danger text-center">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="col-12">
                        <div class="bg-light p-3">
                            <div class="form-check ml-auto mr-auto" style="width:200px;">
                                <label class="form-check-label">
                                    <input id="select-all-checkbox" type="checkbox" class="form-check-input-styled-success" data-fouc>
                                    All Permissions
                                </label>
                            </div>
                            @error('permissions')
                                <div class="text-danger text-center">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="col-lg-12">
                        @error('permission')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror

                        <div class="row p-2">
                            @if($pages->isEmpty())
                                <div class="col-8 offset-2">
                                    <div class="text-center">
                                        <div class="alert alert-danger border-0 alert-dismissible">
                                            <span class="font-weight-semibold">Oh snap!</span> No permission found. Please  <a href="{{ route('permission.create') }}" class="alert-link">try creating</a> new permission.
                                        </div>
                                    </div>
                                </div>
                            @else
                                @foreach($pages as $page)
                                    <div class="col-lg-4">
                                        <div class="card card-body custom-border-top" style="min-height:266px!important;">
                                            <div class="text-center">
                                                <h4 class="mb-0 font-weight-bold">{{ ucfirst($page->title) }}</h4>
                                            </div>
                                            <div class="card card-body bg-light mb-0">
                                                <div id="group{{$page->id}}">
                                                    <span id="addClass{{$page->id}}" onclick="checkSelectedAll(this)" class="select-group d-block text-center badge badge-secondary badge-pill" style="cursor: pointer;font-size:12px;">Check All</span>
                                                    @if($page->title == 'global')
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $page->title }}" {{ (collect(old('permissions'))->contains($page->title)) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                {{ $page->title }}
                                                            </label>
                                                        </div>

                                                        @if((collect(old('permissions'))->contains('global')))
                                                           <script>
                                                                var element = document.getElementById('addClass{{$page->id}}');
                                                                element.classList.add("badge-success");
                                                            </script>

                                                        @endif
                                                    @else
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $page->title.' view' }}" {{ (collect(old('permissions'))->contains($page->title.' view')) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                {{ $page->title }} view
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $page->title.' create' }}" {{ (collect(old('permissions'))->contains($page->title.' create')) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                {{ $page->title }} create
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $page->title.' edit' }}" {{ (collect(old('permissions'))->contains($page->title.' edit')) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                {{ $page->title }} edit
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $page->title.' delete' }}" {{ (collect(old('permissions'))->contains($page->title.' delete')) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                {{ $page->title }} delete
                                                            </label>
                                                        </div>

                                                        @if((collect(old('permissions'))->contains($page->title.' view')) || (collect(old('permissions'))->contains($page->title.' create')) || (collect(old('permissions'))->contains($page->title.' edit')) || (collect(old('permissions'))->contains($page->title.' delete')))
                                                           <script>
                                                                var element = document.getElementById('addClass{{$page->id}}');
                                                                element.classList.add("badge-success");
                                                            </script>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
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

        function checkSelectedAll(me){
            var divid = $(me).parent().attr('id');
            var inp = $("#" + divid).find("input");
            inp.prop("checked", !inp.prop("checked"));
            $(me).toggleClass("badge-success");
        }

    </script>
@endpush
