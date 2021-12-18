@extends('layouts.app')

@section('title', 'New Bank')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                <span class="breadcrumb-item active">New Bank</span>
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
            <h5 class="card-title">New Bank</h5>
            <div class="header-elements">
                <a type="button" href="{{ route('bank.index') }}" class="btn custom-btn-success"><i class="icon-circle-left2 mr-2"></i>Back</a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('bank.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Bank Name</label>
                    <div class="col-lg-10">
                        <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror" placeholder="Bank Name" value="{{ old('bank_name') }}">
                        @error('bank_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Bank Branch</label>
                    <div class="col-lg-10">
                        <input type="text" name="bank_branch" class="form-control" placeholder="Bank Branch" value="{{ old('bank_branch') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Account Holder</label>
                    <div class="col-lg-10">
                        <input type="text" name="account_name" class="form-control" placeholder="Account Holder" value="{{ old('account_name') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Account Number</label>
                    <div class="col-lg-10">
                        <input type="text" name="account_number" class="form-control" placeholder="Account Number" value="{{ old('account_number') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Opening Balance</label>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </span>
                            <input type="text" name="opening_balance" class="form-control @error('opening_balance') is-invalid @enderror" placeholder="Opening Balance" value="{{ old('opening_balance') }}">
                        </div>
                        @error('opening_balance')
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
