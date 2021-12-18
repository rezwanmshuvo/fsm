@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/selectize/dist/css/selectize.bootstrap4.css') }}">
@endpush

@section('title', 'Invoice View')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                <span class="breadcrumb-item active">Invoice View</span>
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
            <h5 class="card-title">Invoice View</h5>
            <div class="header-elements">
                <a type="button" href="#" class="btn custom-btn-print mr-3" onclick="window.print();"><i class="icon-printer2 mr-2"></i>Print</a>
                <a type="button" href="#" data-toggle="modal" data-target="#add_payment" class="btn custom-btn-success"><i class="icon-cash mr-2"></i>Make Payment</a>
            </div>
        </div>

        <div class="card-body">
                <!-- Invoice Header -->
                <table class="table invoice-table">
                    <tr>
                        <td style="width: 75%;">
                            <h4>
                                <b>
                                    Demo Company
                                </b>
                            </h4>
                            <address>
                                Chawliapatty, Dianjpur<br>
                                info@democompany.com<br>
                                01723099974
                            </address>
                        </td>
                        <td>
                            <img src="{{ asset('assets/img/invoice-logo.jpg') }}" alt="" width="100px">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <h4>
                                <b>
                                    Invoice To
                                </b>
                            </h4>
                            <address>
                                Head Master<br>
                                dinajpurgirlsschool@gmail.com<br>
                                Dinajpur Govt Girls' High School<br>
                                Goneshtola Dinajpur Sadar
                            </address>
                        </td>
                        <td>
                            <h4>
                                <b>
                                    Invoice Details
                                </b>
                            </h4>
                            <address>
                                <b>Invoice #:</b> IN1057<br>

                                <b>Invoice Date:</b>
                                03/Oct/2021<br>

                                <b>Due Date:</b>
                                03/Oct/2021<br>

                                <b>Payment Status:</b>
                                Paid<br>
                            </address>
                        </td>
                    </tr>
                </table>

                <!-- Invoice Boady -->
                <table class="table table-bordered">
                    <thead>
                        <tr style="background-color:#F5f5f5f5;">
                            <th>Name</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Discount</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Patrol</td>
                            <td class="text-right">100.00</td>
                            <td class="text-right">1.5</td>
                            <td class="text-right">5.00</td>
                            <td class="text-right">95.00</td>
                        </tr>
                        <tr>
                            <td>Patrol</td>
                            <td class="text-right">100.00</td>
                            <td class="text-right">1.5</td>
                            <td class="text-right">5.00</td>
                            <td class="text-right">95.00</td>
                        </tr>
                        <tr>
                            <td>Patrol</td>
                            <td class="text-right">100.00</td>
                            <td class="text-right">1.5</td>
                            <td class="text-right">5.00</td>
                            <td class="text-right">95.00</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Invoice Summery -->
                <div style="width: 30%; margin-left:70%;" class="mt-3 mb-3">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="invoice-summary-table">
                            <tbody>
                                <tr>
                                    <td style="background-color:#F5f5f5f5;"><b>Sub Total</b></td>
                                    <td class="text-right">
                                        <b>BDT 95.00</b>
                                    </td>
                                </tr>
                                                                    <tr>
                                    <td style="background-color:#F5f5f5f5;"><b>Total Discount</b></td>
                                    <td class="text-right">
                                        <span>BDT 5.00</span>
                                    </td>
                                </tr>
                                                                    <tr>
                                    <td style="background-color:#F5f5f5f5;"><b>Grand Total</b></td>
                                    <td class="text-right">BDT 1,750.00</td>
                                </tr>
                                <tr>
                                    <td style="background-color:#F5f5f5f5;"><b>Total Paid</b></td>
                                    <td class="text-right">BDT 11,111.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--Invoice Summery -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="invoice-payment-history-table">
                        <thead class="base_color">
                            <tr style="background-color:#F5f5f5f5;">
                                <td colspan="4" class="text-center"><b>Payment History</b></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Account</th>
                                <th class="text-right">Amount</th>
                                <th>Payment Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="transaction-55">
                                <td>04/Oct/2021</td>
                                <td>City Bank Account
                                </td>
                                <td class="text-right">BDT 11,111.00</td>
                                <td>Paytm</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
    <!-- /form inputs -->

    <!-- add supplier modal -->
    <div id="add_payment" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Payment</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('withdraw.store') }}" method="POST" id="save_data">
                        @csrf
                        <input type="hidden" name="purpose_id">
                        <input type="hidden" name="supplier_id">
                        <input id="save_print" type="hidden" name="save_print">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2 text-mandatory">Payment Date</label>
                            <div class="col-lg-10">
                                <input type="text" name="withdraw_date" class="form-control  @error('withdraw_date') is-invalid @enderror" id="anytime-both" value="{{ old('withdraw_date', date('d-m-Y g:i:s A', strtotime(now()))) }}">
                                @error('withdraw_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2 text-mandatory">Bank</label>
                            <div class="col-lg-10">
                                <select name="account_id" class="form-control select-search @error('account_id') is-invalid @enderror">
                                    <option value="">Selelct Bank</option>

                                </select>
                                @error('account_id')
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
                            <label class="col-form-label col-lg-2">Due Amount</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </span>
                                    <input readonly type="text" name="due_amount" class="form-control @error('due_amount') is-invalid @enderror" placeholder="Due Amount" value="{{ old('due_amount') }}">
                                </div>
                                @error('due_amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
                            <label class="col-form-label col-lg-2">Payment Note</label>
                            <div class="col-lg-10">
                                <textarea name="" id="" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <button type="submit" id="save_only" class="btn btn-primary float-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /add supplier modal -->
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
    <script src="{{ asset('assets/plugins/selectize/dist/js/standalone/selectize.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/demo_pages/form_inputs.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/pickers/anytime.min.js') }}"></script>

    <script src="{{ asset('assets/js/purchase.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select-search').selectize({
                create: false,
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
