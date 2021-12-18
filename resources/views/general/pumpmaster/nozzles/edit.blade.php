@extends('layouts.app')

@section('title', $nozzle->name)

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                <span class="breadcrumb-item active">{{ $nozzle->name }}</span>
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
            <h5 class="card-title">{{ $nozzle->name }}</h5>
            <div class="header-elements">
                <a type="button" href="{{ route('nozzle.index') }}" class="btn custom-btn-success"><i class="icon-circle-left2 mr-2"></i>Back</a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('nozzle.update', $nozzle->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Nozzle Name</label>
                    <div class="col-lg-10">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Machine Name" value="{{ old('name', $nozzle->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Select Machine</label>
                    <div class="col-lg-10">
                        <select name="machine_id" class="form-control select-search @error('machine_id') is-invalid @enderror">
                            <option value="">Selelct Machine</option>
                            @foreach($machines as $machine)
                                <option value="{{ $machine->id }}" {{ (old('machine_id', $nozzle->machine_id)== $machine->id) ? 'selected=selected': ''}}>{{ $machine->name }}</option>
                            @endforeach
                        </select>
                        @error('machine_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Select Item</label>
                    <div class="col-lg-10">
                        <select name="item_id" class="form-control select-search @error('item_id') is-invalid @enderror">
                            <option value="">Selelct Item</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" {{ (old('item_id', $nozzle->item_id)== $item->id) ? 'selected=selected': ''}}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('item_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 ">Start Reading</label>
                    <div class="col-lg-10">
                        <input type="view_only" name="start_reading" class="form-control" placeholder="Start Reading" readonly value="{{ old('start_reading', $nozzle->start_reading) }}">
                        @error('start_reading')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Current Reading</label>
                    <div class="col-lg-10">
                        <input type="view_only" name="current_reading" class="form-control" placeholder="Current Reading" readonly value="{{ old('current_reading', $nozzle->current_reading) }}">
                        @error('current_reading')
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
