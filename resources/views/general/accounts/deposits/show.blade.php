@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/selectize/dist/css/selectize.bootstrap4.css') }}">
@endpush
@section('title', $deposit->voucher_number)

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                <span class="breadcrumb-item active">{{ $deposit->voucher_number }}</span>
            </div>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card" id="print">
        <div class="card-header header-elements-inline">
            <div class="header-elements ml-auto">
                <a type="button" href="#" class="btn custom-btn-print mr-3" onclick="window.print();"><i class="icon-printer2 mr-2"></i>Print</a>
                <a type="button" href="{{ route('deposit.index') }}" class="btn custom-btn-success"><i class="icon-circle-left2 mr-2"></i>Back</a>
            </div>
        </div>

        <div class="card-body">
            <div style="padding-bottom:30px; border-bottom:1px dashed #595959">
                <div class="row">
                    <div class="col-12">
                        <table style="width:100%; margin-bottom:15px; border:0px solid #FFFFFF;">
                            <tr>
                                <td>
                                    <div style="text-align:left;">
                                        <img src="{{ asset('assets/img/invoice-logo.jpg') }}" alt="" style="width:150px">
                                    </div>
                                </td>

                                <td>
                                    <div style="text-align:center;">
                                        <span style="color:#595959;display:block;padding:0px 0px;text-align:center; font-size: 30px;line-height:20px;font-weight:700;">
                                            DEPOSIT SLIP
                                        </span>
                                    </div>
                                </td>


                                <td>
                                    <div style="text-align:right;">
                                        <span style="color:#595959;display:block;padding:0px 0px;font-size: 30px;line-height:20px;font-weight:700;">
                                            OFFICE COPY
                                        </span>
                                    </div>
                                </td>
                        </table>

                        <table style="width:100%; margin-bottom:15px; border:0px solid #FFFFFF;">
                            <tr>
                                <td>
                                    <span style="color:#595959; display:inline-block;padding:5px 0px;text-align:center;font-size:18px;font-weight:700;">Date:</span>
                                    <span style="dispaly:block;">
                                        {{ date('d-m-Y g:i:s A', strtotime($deposit->deposit_date)) }}
                                    </span>
                                </td>
                                <td style="text-align:right;">
                                    <span style="color:#595959; display:inline-block;padding:5px 0px;text-align:center;font-size:18px;font-weight:700;">Bank:</span>
                                    <span style="dispaly:block;">
                                        {{ $deposit->account->bank_name }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-bordered" style="border-color: #595959; width:100%;">
                            <tbody>
                                <tr>
                                    <td>
                                        <span style="color:#595959; display:block;padding:5px 0px;text-align:center;font-size:18px;font-weight:700;">
                                            Customer Name
                                        </span>
                                    </td>
                                    <td colspan="4">
                                        {{ (!is_null($deposit->customer)) ? $deposit->customer->name : 'Not set' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                            Voucher Number
                                        </span>
                                    </td>
                                    <td colspan="4">
                                        {{ $deposit->voucher_number }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                            Purpose
                                        </span>
                                    </td>
                                    <td style="width:200px;">
                                        {{ ucfirst($deposit->purpose->name) }}
                                    </td>
                                    <td>
                                        <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                            Deposit Type
                                        </span>
                                    </td>
                                    <td style="width:200px;">
                                        {{ ucfirst($deposit->deposit_type) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                            Note
                                        </span>
                                    </td>
                                    <td colspan="4">
                                        {{ ucfirst($deposit->note) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td width="200" rowspan="2">
                                        <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                            Amount in Words
                                        </span>
                                    </td>
                                    <td width="354" colspan="2" rowspan="2">
                                        {{ $totalAmountToWord }}
                                    </td>
                                    <td width="254">
                                        <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                            Amount in figures
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">

                                        <span style="display: block; text-align:center;">
                                            BDT  {{ $deposit->total_amount }}
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3" style="padding:60px 0px 10px 0px;">
                                        <div  style="text-align:center;">
                                            <b><span style="color:#595959">---------------------------------------------------</span></b>
                                            <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                                Authorized Signature
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                            Seal & Signature
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- CUSTOMER COPY-->
            <div style="padding-top:30px;">
                <div class="row">
                    <div class="col-12">
                        <table style="width:100%; margin-bottom:15px; border:0px solid #FFFFFF;">
                            <tr>
                                <td>
                                    <div style="text-align:left;">
                                        <img src="{{ asset('assets/img/invoice-logo.jpg') }}" alt="" style="width:150px">
                                    </div>
                                </td>
                                <td>
                                    <div style="text-align:center;">
                                        <span style="color:#595959;display:block; text-align:center; font-size: 30px;line-height:20px;font-weight:700;">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEPOSIT SLIP
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div style="text-align:right;">
                                        <span style="color:#595959;display:block;padding:0px 0px;font-size: 30px;line-height:20px;font-weight:700;">
                                            CUSTOMER COPY
                                        </span>
                                    </div>
                                </td>
                        </table>

                        <table style="width:100%; margin-bottom:15px; border:0px solid #FFFFFF;">
                            <tr>
                                <td>
                                    <span style="color:#595959; display:inline-block;padding:5px 0px;text-align:center;font-size:18px;font-weight:700;">Date:</span>
                                    <span style="dispaly:block;">
                                        {{ date('d-m-Y g:i:s A', strtotime($deposit->deposit_date)) }}
                                    </span>
                                </td>
                                <td style="text-align:right;">
                                    <span style="color:#595959; display:inline-block;padding:5px 0px;text-align:center;font-size:18px;font-weight:700;">Bank:</span>
                                    <span style="dispaly:block;">
                                        {{ $deposit->account->bank_name }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-bordered" style="border-color: #595959; width:100%;">
                            <tbody>
                                <tr>
                                    <td>
                                        <span style="color:#595959; display:block;padding:5px 0px;text-align:center;font-size:18px;font-weight:700;">
                                            Customer Name
                                        </span>
                                    </td>
                                    <td colspan="4">
                                        {{ (!is_null($deposit->customer)) ? $deposit->customer->name : 'Not set' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                            Voucher Number
                                        </span>
                                    </td>
                                    <td colspan="4">
                                        {{ $deposit->voucher_number }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                            Purpose
                                        </span>
                                    </td>
                                    <td style="width:200px;">
                                        {{ ucfirst($deposit->purpose->name) }}
                                    </td>
                                    <td>
                                        <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                            Deposit Type
                                        </span>
                                    </td>
                                    <td style="width:200px;">
                                        {{ ucfirst($deposit->deposit_type) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                            Note
                                        </span>
                                    </td>
                                    <td colspan="4">
                                        {{ ucfirst($deposit->note) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td width="200" rowspan="2">
                                        <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                            Amount in Words
                                        </span>
                                    </td>
                                    <td width="354" colspan="2" rowspan="2">
                                        {{ $totalAmountToWord }}
                                    </td>
                                    <td width="254">
                                        <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                            Amount in figures
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">

                                        <span style="display: block; text-align:center;">
                                            BDT  {{ $deposit->total_amount }}
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3" style="padding:60px 0px 10px 0px;">
                                        <div  style="text-align:center;">
                                            <b><span style="color:#595959">---------------------------------------------------</span></b>
                                            <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                                Authorized Signature
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="color:#595959; display:block;padding:0px 0px;text-align:center;font-size:18px;line-height:20px;font-weight:700;">
                                            Seal & Signature
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
            e.preventDefault();
        });


    </script>
@endpush
