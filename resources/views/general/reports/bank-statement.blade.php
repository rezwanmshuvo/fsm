@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/selectize/dist/css/selectize.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/daterangepicker-master/daterangepicker.css') }}" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.bootstrap4.min.css">
@endpush
@section('title', 'Bank Statement')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                <span class="breadcrumb-item active">Bank Statement
                </span>
            </div>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <!-- Filter -->
    <div class="card hide-filter-on-print">
        <div class="card-header bg-transparent header-elements-inline">
            <span class="text-uppercase font-size-sm font-weight-semibold">Filter</span>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>

        <div class="card-body">

            <form action="{{ route('reports.bank-statement.post') }}" method="POST" id="get_form">
                @csrf
                <div class="form-group row">
                    <input type="hidden" class="form-control" name="start_date" id="start_date">
                    <input type="hidden" class="form-control" name="end_date" id="end_date">
                    <label class="col-form-label col-lg-2 text-mandatory">Date Range</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="date_filter" id="date_filter">
                        @error('date_filter')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Banks</label>
                    <div class="col-lg-10">
                        <select id="select-banks" name="bank[]" multiple class="form-control select-search">
                            <option value="">Selelct Banks</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                            @endforeach
                        </select>
                        @error('bank')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary float-right">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /filter -->

    <!-- Table -->
    @if(!empty($tabular_data))
        <div class="card">
            <div class="card-header bg-transparent header-elements-inline">
                <span class="text-uppercase font-size-sm font-weight-semibold">Data
                    {{-- <input type="button" onclick="printDiv('printableArea')" value="print a div!" /> --}}

                </span>
                <div class="header-elements">
                    <div class="list-icons">
                        <a type="button" href="#" class="btn custom-btn-print mr-3" onclick="printDiv('printableArea')"><i class="icon-printer2 mr-2"></i>Print</a>
                    </div>
                </div>
            </div>
            <div class="card-body" id="printableArea">
                <div class="row">
                    <div class="col-12">
                        <div>
                            <table class="table">
                                <tr>
                                    <td style="width:35%">
                                    <img src="{{ asset('assets/img/invoice-logo.jpg') }}" alt="" style="width:35%;">
                                    </td>

                                    <td class="text-right"  style="width:65%" id="header-left-info">
                                        <b>Date Range:</b> {{ date('j F, Y', strtotime($start_Date)) }} <b>To</b> {{ date('j F, Y', strtotime($end_Date)) }}<br>
                                        <b>
                                            Banks:
                                        </b>
                                        @foreach ($tableBanks as $bankData)
                                            {{ $bankData->bank_name }},
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="" id="get_table_data">
                    <table class="table table-bordered table-striped table_data" id="table_data">
                        <thead>
                            <tr>
                                <th style="width: 10%!important">Date</th>
                                <th style="width: 10%!important">Voucher No</th>
                                <th style="width: 10%!important">Transaction Type</th>
                                <th style="width: 10%!important">Note</th>
                                <th style="width: 20%!important">Deposits</th>
                                <th style="width: 20%!important">Withdraws</th>
                                <th style="width: 20%!important">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-right font-weight-bolder">Previous Balance</td>
                                <td class="font-weight-bold" id="tot4">{{ $previousBalance }}</td>
                            </tr>
                            @foreach ($tabular_data as $data)
                                <tr>
                                    <td>{{ $data['date'] }}</td>
                                    <td>{{ $data['voucher_number'] }}</td>
                                    <td>{{ $data['type'] }}</td>
                                    <td>{{ $data['note'] }}</td>
                                    <td>{{ $data['debit'] }}</td>
                                    <td>{{ $data['credit'] }}</td>
                                    <td>{{ $data['balance'] }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="6" class="text-right font-weight-bolder">Total Deposit</td>
                                <td class="font-weight-bold" id="tot4">{{ $totalDb }}</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right font-weight-bolder">Total Withdraw</td>
                                <td class="font-weight-bold" id="tot4">{{ $totalCr }}</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right font-weight-bolder">Final Balance</td>
                                <td class="font-weight-bold" id="tot4">{{ $balance_amnt }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    <!-- /Table -->

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
    <script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker-master/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker-master/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            let dateInterval = getQueryParameter('date_filter');
            let start = moment().startOf('isoWeek');
            let end = moment().endOf('isoWeek');
            if (dateInterval) {
                dateInterval = dateInterval.split(' - ');
                start = dateInterval[0];
                end = dateInterval[1];
            }
            $('#date_filter').daterangepicker({
                "showDropdowns": true,
                "showWeekNumbers": true,
                "alwaysShowCalendars": true,
                startDate: start,
                endDate: end,
                locale: {
                    format: 'DD/MM/YYYY',
                    firstDay: 1,
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                    'All time': [moment().subtract(30, 'year').startOf('month'), moment().endOf('month')],
                }
            },
            function(){
                var start_Date = $('#date_filter').data('daterangepicker').startDate._d;
                var end_Date = $('#date_filter').data('daterangepicker').endDate._d;
                start_Date = start_Date.toLocaleDateString('en-US');
                end_Date   = end_Date.toLocaleDateString('en-US');

                $("#start_date").val(start_Date);
                $("#end_date").val(end_Date);
            });
        });
        function getQueryParameter(name) {
            const url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
    </script>

    <script>
        $(document).ready(function() {
            Selectize.define('select_remove_all_options', function(options) {
                if (this.settings.mode === 'single') return;

                var self = this;

                self.setup = (function() {
                    var original = self.setup;
                    return function() {
                        original.apply(this, arguments);

                        var allBtn = $('<button type="button" class="btn btn-primary" style="padding: .1375rem .875rem!important;">Select All Banks</button>');
                        var clearBtn = $('<button type="button" class="btn btn-warning" style="padding: .1375rem .875rem!important;">Clear</button>');
                        var btnGrp = $('<div class="selectize-plugin-select_remove_all_options-btn-grp"></div>');
                        btnGrp.append(allBtn, ' ', clearBtn);

                        allBtn.on('click', function() {
                            self.setValue($.map(self.options, function(v, k) {
                                return k
                            }));
                        });
                        clearBtn.on('click', function() {
                            self.setValue([]);
                        });

                        this.$wrapper.append(btnGrp)
                    };
                })();
            });

            $('.select-search').selectize({
                create: false,
                sortField: 'text',
                plugins: ['remove_button', 'select_remove_all_options']
            });

        });
    </script>

    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }

        window.onafterprint = function(){
            window.location.reload(true);
        }
    </script>
@endpush
