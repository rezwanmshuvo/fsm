@extends('layouts.app')

@section('title', 'New Tank')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                <span class="breadcrumb-item active">New Tank</span>
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
            <h5 class="card-title">New Tank</h5>
            <div class="header-elements">
                <a type="button" href="{{ route('tank.index') }}" class="btn custom-btn-success"><i class="icon-circle-left2 mr-2"></i>Back</a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('tank.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Tank Name</label>
                    <div class="col-lg-10">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Tank Name" value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Capacity</label>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror" placeholder="Capacity" value="{{ old('capacity') }}">
                            @error('capacity')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <span class="input-group-prepend">
                                 <span class="input-group-text">Ltr</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Minimum Dip</label>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <input type="number" name="dip_min" class="form-control" placeholder="Minimum Dip" value="{{ old('dip_min') }}">
                            @error('dip_min')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <span class="input-group-prepend">
                                 <span class="input-group-text">cm</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Maximum Dip</label>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <input type="number" name="dip_max" class="form-control" placeholder="Maximum Dip" value="{{ old('dip_max') }}">
                            @error('dip_max')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <span class="input-group-prepend">
                                 <span class="input-group-text">cm</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Dip Difereance</label>
                    <div class="col-lg-10">

                        <div class="input-group">
                            <input type="number" name="dip_in_mm" class="form-control @error('dip_in_mm') is-invalid @enderror" placeholder="Dip Difereance" value="{{ old('dip_in_mm') }}">
                            @error('dip_in_mm')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <span class="input-group-prepend">
                                 <span class="input-group-text">cm</span>
                            </span>
                        </div>
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
