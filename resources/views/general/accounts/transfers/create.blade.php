@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/selectize/dist/css/selectize.bootstrap4.css') }}">
@endpush
@section('title', 'New Transfer')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                <span class="breadcrumb-item active">New Transfer</span>
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
            <h5 class="card-title">New Transfer</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('transfer.store') }}" method="POST" id="save_data">
                @csrf
                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Transfer Date</label>
                    <div class="col-lg-10">
                        <input type="text" name="transfer_date" class="form-control  @error('transfer_date') is-invalid @enderror" id="anytime-both" value="{{ old('transfer_date', date('d-m-Y g:i:s A', strtotime(now()))) }}">
                        @error('transfer_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Bank From</label>
                    <div class="col-lg-10">
                        <select name="bank_from" class="form-control select-search @error('bank_from') is-invalid @enderror">
                            <option value="">Selelct Bank From</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}" {{ (old('bank_from')== $bank->id) ? 'selected=selected': ''}}>{{ $bank->bank_name }}</option>
                            @endforeach
                        </select>
                        @error('bank_from')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Bank To</label>
                    <div class="col-lg-10">
                        <select name="bank_to" class="form-control select-search @error('bank_to') is-invalid @enderror">
                            <option value="">Selelct Bank To</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}" {{ (old('bank_to')== $bank->id) ? 'selected=selected': ''}}>{{ $bank->bank_name }}</option>
                            @endforeach
                        </select>
                        @error('bank_to')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Money Receipt</label>
                    <div class="col-lg-10">
                        <input type="text" name="money_receipt" class="form-control" placeholder="Money Receipt" value="{{ old('money_receipt') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Total Amount</label>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </span>
                            <input type="text" name="total_amount" class="form-control @error('total_amount') is-invalid @enderror" placeholder="Total Amount" value="{{ old('total_amount') }}">
                        </div>
                        @error('total_amount')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Note</label>
                    <div class="col-lg-10">
                        <input type="text" name="note" class="form-control" placeholder="Note" value="{{ old('note') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary float-right ml-3">Save</button>
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

            // Selectize
            $('.select-search').selectize({
                create: true,
                sortField: 'text'
            });

            // Date and time
            $('#anytime-both').AnyTime_picker({
                format: '%d-%m-%Y %h:%i:%s %p',
            });

            //remove readonly for the input field each button datepicker clicked
            $('#anytime-both').attr("readonly", true);
            //unbind "keydown" event for the input field to make it editable
            $('#anytime-both').unbind("keydown");
            // e.preventDefault();
        });


    </script>
@endpush
