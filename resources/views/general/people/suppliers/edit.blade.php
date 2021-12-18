@extends('layouts.app')

@section('title', $supplier->name)

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                <span class="breadcrumb-item active">{{ $supplier->name }}</span>
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
            <h5 class="card-title">{{ $supplier->name }}</h5>
            <div class="header-elements">
                <a type="button" href="{{ route('supplier.index') }}" class="btn custom-btn-success"><i class="icon-circle-left2 mr-2"></i>Back</a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Supplier Name</label>
                    <div class="col-lg-10">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Supplier Name" value="{{ old('name', $supplier->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Supplier Phone</label>
                    <div class="col-lg-10">
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Supplier Phone" value="{{ old('phone', $supplier->phone) }}">
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Supplier Email</label>
                    <div class="col-lg-10">
                        <input type="text" name="email" class="form-control" placeholder="Supplier Email" value="{{ old('email', $supplier->email) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Supplier Address</label>
                    <div class="col-lg-10">
                        <input type="text" name="address" class="form-control" placeholder="Supplier Address" value="{{ old('address', $supplier->address) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Bank Name</label>
                    <div class="col-lg-10">
                        <input type="text" name="bank_name" class="form-control" placeholder="Bank Name" value="{{ old('bank_name', $supplier->bank_name) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Bank Branch</label>
                    <div class="col-lg-10">
                        <input type="text" name="bank_branch" class="form-control" placeholder="Bank Branch" value="{{ old('bank_branch', $supplier->bank_branch) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Account Holder</label>
                    <div class="col-lg-10">
                        <input type="text" name="account_name" class="form-control" placeholder="Account Holder" value="{{ old('account_name', $supplier->account_name) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Account Number</label>
                    <div class="col-lg-10">
                        <input type="text" name="account_number" class="form-control" placeholder="Account Number" value="{{ old('account_number', $supplier->account_number) }}">
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
