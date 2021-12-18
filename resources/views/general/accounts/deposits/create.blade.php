@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/selectize/dist/css/selectize.bootstrap4.css') }}">
@endpush
@section('title', 'New Deposit')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                <span class="breadcrumb-item active">New Deposit</span>
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
            <h5 class="card-title">New Deposit</h5>
            <div class="header-elements">
                <a type="button" href="{{ route('deposit.index') }}" class="btn custom-btn-success"><i class="icon-circle-left2 mr-2"></i>Back</a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('deposit.store') }}" method="POST" id="save_data">
                @csrf
                <input id="save_print" type="hidden" name="save_print">
                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Deposit Date</label>
                    <div class="col-lg-10">
                        <input type="text" name="deposit_date" class="form-control  @error('deposit_date') is-invalid @enderror" id="anytime-both" value="{{ old('deposit_date', date('d-m-Y g:i:s A', strtotime(now()))) }}">
                        @error('deposit_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Customer</label>
                    <div class="col-lg-10">
                        <select name="customer_id" class="form-control select-search">
                            <option value="">Selelct Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ (old('customer_id')== $customer->id) ? 'selected=selected': ''}}>{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Bank</label>
                    <div class="col-lg-10">
                        <select name="account_id" class="form-control select-search @error('account_id') is-invalid @enderror">
                            <option value="">Selelct Bank</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}" {{ (old('account_id')== $bank->id) ? 'selected=selected': ''}}>{{ $bank->bank_name }}</option>
                            @endforeach
                        </select>
                        @error('account_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Purpose</label>
                    <div class="col-lg-10">
                        <select name="purpose_id" class="form-control select-search @error('purpose_id') is-invalid @enderror">
                            <option value="">Selelct Purpose</option>
                            @foreach($purposes as $purpose)
                                <option value="{{ $purpose->id }}" {{ (old('purpose_id')== $purpose->id) ? 'selected=selected': ''}}>{{ $purpose->name }}</option>
                            @endforeach
                        </select>
                        @error('purpose_id')
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
                        <button type="submit" id="save_and_print" class="btn btn-primary float-right ml-3">Save & Print</button>
                        <button type="submit" id="save_only" class="btn btn-primary float-right">Save</button>
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


            $("#save_only").on("click",function(event){
                event.preventDefault();
                $("#save_print").val("save_only");
                document.getElementById('save_data').submit();
            });

            $("#save_and_print").on("click",function(event){
                event.preventDefault();
                $("#save_print").val("save_and_print");
                document.getElementById('save_data').submit();
            });

        });


    </script>
@endpush
