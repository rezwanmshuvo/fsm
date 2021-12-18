@extends('layouts.app')

@section('title', $machine->name)

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                <span class="breadcrumb-item active">{{ $machine->name }}</span>
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
            <h5 class="card-title">{{ $machine->name }}</h5>
            <div class="header-elements">
                <a type="button" href="{{ route('machine.index') }}" class="btn custom-btn-success"><i class="icon-circle-left2 mr-2"></i>Back</a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('machine.update', $machine->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Machine Name</label>
                    <div class="col-lg-10">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Machine Name" value="{{ old('name', $machine->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Select Tank</label>
                    <div class="col-lg-10">
                        <select name="tank_id" class="form-control select-search @error('tank_id') is-invalid @enderror">
                            <option value="">Selelct Tank</option>
                            @foreach($tanks as $tank)
                                <option value="{{ $tank->id }}" {{ (old('tank_id', $machine->tank->id)== $tank->id) ? 'selected=selected': ''}}>{{ $tank->name }}</option>
                            @endforeach
                        </select>
                        @error('tank_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Model</label>
                    <div class="col-lg-10">
                        <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" placeholder="Model" value="{{ old('model', $machine->model) }}">
                        @error('model')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">No of Nozzle</label>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <input type="number" name="no_of_nozzle" class="form-control" placeholder="No of Nozzle" value="{{ old('no_of_nozzle', $machine->no_of_nozzle) }}">
                            @error('no_of_nozzle')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <span class="input-group-prepend">
                                 <span class="input-group-text">Pcs</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Serial No</label>
                    <div class="col-lg-10">
                        <input type="text" name="serial_no" class="form-control" placeholder="Serial No" value="{{ old('serial_no', $machine->serial_no) }}">
                        @error('serial_no')
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
    <script src="{{ asset('assets/global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/demo_pages/form_inputs.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/pickers/anytime.min.js') }}"></script>
@endpush
