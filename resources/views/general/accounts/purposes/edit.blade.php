@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/selectize/dist/css/selectize.bootstrap4.css') }}">
@endpush
@section('title', $purpose->name)

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                <span class="breadcrumb-item active">{{ $purpose->name }}</span>
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
            <h5 class="card-title">{{ $purpose->name }}</h5>
            <div class="header-elements">
                <a type="button" href="{{ route('purpose.index') }}" class="btn custom-btn-success"><i class="icon-circle-left2 mr-2"></i>Back</a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('purpose.update', $purpose->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Parent Purpose</label>
                    <div class="col-lg-10">
                        <select name="purpose_id" class="form-control select-search">
                            <option value="">Selelct Parent Purpose</option>
                            @foreach($purposes as $purpose_parent_select)
                                <option value="{{ $purpose_parent_select->id }}" {{ (old('purpose_id', $purpose->purpose_id) == $purpose_parent_select->id) ? 'selected=selected' : ''}}>{{ $purpose_parent_select->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Purpose</label>
                    <div class="col-lg-10">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Purpose" value="{{ old('name', $purpose->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Purpose Type</label>
                    <div class="col-lg-10">
                        <select name="purpose_type" class="form-control select-search @error('purpose_type') is-invalid @enderror">
                            <option value="">Selelct Purpose Type</option>
                            <option value="income" {{ (old('purpose_type', $purpose->purpose_type) == 'income') ? 'selected=selected' : ''}}>Income</option>
                            <option value="expanse" {{ (old('purpose_type', $purpose->purpose_type) == 'expanse') ? 'selected=selected' : ''}}>Expanse</option>
                        </select>
                        @error('purpose_type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary float-right">Save</button>
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
                create: false,
                sortField: 'text'
            });
        });
    </script>
@endpush
