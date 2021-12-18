@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <span class="breadcrumb-item active">Dashboard
                </span>
            </div>
        </div>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content container">
    <!-- Blocks with chart-->
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex pb-1">
                    <div>
                        <span class="card-title font-weight-semibold">Today's Deposit</span>
                        <h2 class="font-weight-bold mb-0">{{ $today_total_deposit }} BDT
                        </h2>
                    </div>
                </div>

                <div class="chart-container">
                    <div class="chart" id="deposit_chart" style="height: 100px"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex pb-1">
                    <div>
                        <span class="card-title font-weight-semibold">Today's Invoice Amount</span>
                        <h2 class="font-weight-bold mb-0">{{ $today_deposit_total_SI }} BDT</h2>
                    </div>
                </div>

                <div class="chart-container">
                    <div class="chart" id="deposit_chart_SI" style="height: 100px"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex pb-1">
                    <div>
                        <span class="card-title font-weight-semibold">Today's Payment Amount</span>
                        <h2 class="font-weight-bold mb-0">{{ $today_deposit_total_SP }} BDT</h2>
                    </div>
                </div>

                <div class="chart-container">
                    <div class="chart" id="deposit_chart_SP" style="height: 100px"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex pb-1">
                    <div>
                        <span class="card-title font-weight-semibold">Today's Withdraw</span>
                        <h2 class="font-weight-bold mb-0">{{ $today_total_withdraw }} BDT
                        </h2>
                    </div>
                </div>

                <div class="chart-container">
                    <div class="chart" id="withdraw_chart" style="height: 100px"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex pb-1">
                    <div>
                        <span class="card-title font-weight-semibold">Today's Purchase Amount</span>
                        <h2 class="font-weight-bold mb-0">{{ $today_withdraw_total_PA }} BDT</h2>
                    </div>
                </div>

                <div class="chart-container">
                    <div class="chart" id="withdraw_chart_PA" style="height: 100px"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex pb-1">
                    <div>
                        <span class="card-title font-weight-semibold">Today's Purchase Payment</span>
                        <h2 class="font-weight-bold mb-0">{{ $today_withdraw_total_PP }} BDT</h2>
                    </div>
                </div>

                <div class="chart-container">
                    <div class="chart" id="withdraw_chart_PP" style="height: 100px"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /blocks with chart-->

    <!-- Deposit vs Withdraw -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <!-- Basic pie -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="chart-container">
                                        <div class="chart has-fixed-height" id="ar_vs_ap"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /basic pie -->
                        </div>

                        <div class="col-xl-6">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="d-flex align-items-center justify-content-sm-center mb-3">
                                        <span class="bg-pink-100 text-pink line-height-1 rounded p-2 mr-3">
                                            <i class="icon-cart top-0"></i>
                                        </span>
                                        <div>
                                            <h6 class="font-weight-bold mb-0">
                                                @php
                                                $total_balance = 0;
                                                @endphp
                                                @foreach($depositWithdrawArray as $key=>$value)
                                                    @php
                                                        $total_balance = $total_balance+ $value['total_balance']
                                                    @endphp
                                                @endforeach

                                                @php
                                                    $grand_total = $total_balance;
                                                @endphp

                                                <span style="font-size: 15px;font-weight: 800;">৳</span> {{ $grand_total }}
                                            </h6>
                                            <span class="text-muted">Total Balance</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="chart-container">
                                <div class="chart" id="progress_deposit_vs_withdraw" style="height: 333px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Deposit vs Withdraw -->
</div>
<!-- /content area -->
@endsection

@push('js')
<script src="{{ asset('assets/global_assets/js/plugins/visualization/echarts/echarts.min.js') }}"></script>
<!--TOP 6 CHART-->
<script>
    /* ------------------------------------------------------------------------------
    *
    *  # Echarts - area gradient example
    *
    *  Demo JS code for area chart with gradient [light theme]
    *
    * ---------------------------------------------------------------------------- */


    // Setup module
    // ------------------------------

    var EchartsAreaGradientLight = function() {


        //
        // Setup module components
        //

        // Basic bar chart
        var _areaGradientExample = function() {
            if (typeof echarts == 'undefined') {
                console.warn('Warning - echarts.min.js is not loaded.');
                return;
            }

            // Define element
            var deposit_chart_element    = document.getElementById('deposit_chart');
            var deposit_chart_SI_element = document.getElementById('deposit_chart_SI');
            var deposit_chart_SP_element = document.getElementById('deposit_chart_SP');

            // Define element
            var withdraw_chart_element      = document.getElementById('withdraw_chart');
            var withdraw_chart_PA_element   = document.getElementById('withdraw_chart_PA');
            var withdraw_chart_PP_element   = document.getElementById('withdraw_chart_PP');

            // HEX to RGBA conversion
            function hex2rgba_convert(hex, alpha) {
                if (!hex || [4, 7].indexOf(hex.length) === -1) {
                    return;
                }

                hex = hex.substr(1);
                if (hex.length === 3) {
                    hex = hex.split('').map(function (el) {
                        return el + el + '';
                    }).join('');
                }

                var r = parseInt(hex.slice(0, 2), 16),
                    g = parseInt(hex.slice(2, 4), 16),
                    b = parseInt(hex.slice(4, 6), 16);

                if (alpha !== undefined) {
                    return "rgba(" + r + ", " + g + ", " + b + ", " + alpha + ")";
                } else {
                    return "rgb(" + r + ", " + g + ", " + b + ")";
                }
            }


            //
            // Chart configuration
            //

            // Area chart with gradient - deposit chart
            if (deposit_chart_element) {

                // Initialize chart
                var deposit_chart = echarts.init(deposit_chart_element);


                //
                // Chart config
                //

                // Define variables
                var DepositDateData = [];
                var DepositAmountData = [];
                @foreach($DepositChartDate as $DepositGetDate)
                    var DepositGetDate = "{{ $DepositGetDate }}";
                    if(!DepositDateData.includes(DepositGetDate))
                    {
                        DepositDateData.push(DepositGetDate);
                    }
                @endforeach

                @foreach($DepositChartAmount as $DepositGetAmount)
                    var DepositGetAmount = "{{ $DepositGetAmount }}";
                    if(!DepositAmountData.includes(DepositGetAmount))
                    {
                        DepositAmountData.push(DepositGetAmount);
                    }
                @endforeach
                var axisData = DepositDateData,
                    data = DepositAmountData,
                    color = '#0092f6',
                    lineWidth = 1.5;

                // Options
                deposit_chart.setOption({

                    // Global text styles
                    textStyle: {
                        fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                        fontSize: 14
                    },

                    // Setup grid
                    grid: {
                        left: 20,
                        right: 20,
                        bottom: 20,
                        top: 10,
                        containLabel: true
                    },

                    // Add tooltip
                    tooltip: {
                        trigger: 'axis',
                        padding: [10, 15],
                        formatter: '{b} <br/> {c} {a}',
                        axisPointer: {
                            lineStyle: {
                                color: color,
                                type: 'dotted'
                            }
                        }
                    },

                    // Horizontal axis
                    xAxis: {
                        type: "category",
                        boundaryGap: false,
                        data: axisData,
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            show: false
                        },
                        axisLine: {
                            show: false
                        }
                    },

                    // Vertical axis
                    yAxis: {
                        type: 'value',
                        max: function (value) {
                            return value.max;
                        },
                        min: function (value) {
                            return value.min;
                        },
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            show: false
                        },
                        axisLine: {
                            show: false
                        },
                        splitLine: {
                            show: false
                        }
                    },

                    // Add series
                    series: [{
                        name: 'BDT',
                        type: 'line',
                        symbol: 'circle',
                        smooth: true,
                        showSymbol: false,
                        symbolSize: 3,
                        itemStyle: {
                            normal: {
                                color: color,
                                lineStyle: {
                                    color: color,
                                    width: lineWidth
                                },
                                areaStyle: {
                                    color: {
                                        type: 'linear',
                                        x: 0,
                                        y: 0,
                                        x2: 0,
                                        y2: 1,
                                        colorStops: [{
                                            offset: 0,
                                            color: hex2rgba_convert(color, 0.25)
                                        }, {
                                            offset: 1,
                                            color: hex2rgba_convert(color, 0)
                                        }]
                                    }
                                }
                            },
                            emphasis: {
                                borderColor: hex2rgba_convert(color, 0.25),
                                borderWidth: 10
                            }
                        },
                        data: data
                    }]
                });
            }

            // Area chart with gradient - deposit chart sales invoice
            if (deposit_chart_SI_element) {

                // Initialize chart
                var deposit_chart_SI = echarts.init(deposit_chart_SI_element);


                //
                // Chart config
                //

                // Define variables
                var DepositDateData_SI = [];
                var DepositAmountData_SI = [];
                @foreach($DepositChartDate_SI as $DepositGetDate_SI)
                    var DepositGetDate_SI = "{{ $DepositGetDate_SI }}";
                    if(!DepositDateData_SI.includes(DepositGetDate_SI))
                    {
                        DepositDateData_SI.push(DepositGetDate_SI);
                    }
                @endforeach

                @foreach($DepositChartAmount_SI as $DepositGetAmount_SI)
                    var DepositGetAmount_SI = "{{ $DepositGetAmount_SI }}";
                    if(!DepositAmountData_SI.includes(DepositGetAmount_SI))
                    {
                        DepositAmountData_SI.push(DepositGetAmount_SI);
                    }
                @endforeach

                var axisData = DepositDateData_SI,
                    data = DepositAmountData_SI,
                    color = '#ff7043',
                    lineWidth = 1.5;

                // Options
                deposit_chart_SI.setOption({

                    // Global text styles
                    textStyle: {
                        fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                        fontSize: 14
                    },

                    // Setup grid
                    grid: {
                        left: 20,
                        right: 20,
                        bottom: 20,
                        top: 10,
                        containLabel: true
                    },

                    // Add tooltip
                    tooltip: {
                        trigger: 'axis',
                        padding: [10, 15],
                        formatter: '{b} <br/> {c} {a}',
                        axisPointer: {
                            lineStyle: {
                                color: color,
                                type: 'dotted'
                            }
                        }
                    },

                    // Horizontal axis
                    xAxis: {
                        type: "category",
                        boundaryGap: false,
                        data: axisData,
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            show: false
                        },
                        axisLine: {
                            show: false
                        }
                    },

                    // Vertical axis
                    yAxis: {
                        type: 'value',
                        max: function (value) {
                            return value.max;
                        },
                        min: function (value) {
                            return value.min;
                        },
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            show: false
                        },
                        axisLine: {
                            show: false
                        },
                        splitLine: {
                            show: false
                        }
                    },

                    // Add series
                    series: [{
                        name: 'BDT',
                        type: 'line',
                        symbol: 'circle',
                        smooth: true,
                        showSymbol: false,
                        symbolSize: 3,
                        itemStyle: {
                            normal: {
                                color: color,
                                lineStyle: {
                                    color: color,
                                    width: lineWidth
                                },
                                areaStyle: {
                                    color: {
                                        type: 'linear',
                                        x: 0,
                                        y: 0,
                                        x2: 0,
                                        y2: 1,
                                        colorStops: [{
                                            offset: 0,
                                            color: hex2rgba_convert(color, 0.25)
                                        }, {
                                            offset: 1,
                                            color: hex2rgba_convert(color, 0)
                                        }]
                                    }
                                }
                            },
                            emphasis: {
                                borderColor: hex2rgba_convert(color, 0.25),
                                borderWidth: 10
                            }
                        },
                        data: data
                    }]
                });
            }

            // Area chart with gradient - deposit chart sales payment
            if (deposit_chart_SP_element) {

                // Initialize chart
                var deposit_chart_SP = echarts.init(deposit_chart_SP_element);


                //
                // Chart config
                //

                // Define variables
                var DepositDateData_SP = [];
                var DepositAmountData_SP = [];
                @foreach($DepositChartDate_SP as $DepositGetDate_SP)
                    var DepositGetDate_SP = "{{ $DepositGetDate_SP }}";
                    if(!DepositDateData_SP.includes(DepositGetDate_SP))
                    {
                        DepositDateData_SP.push(DepositGetDate_SP);
                    }
                @endforeach

                @foreach($DepositChartAmount_SP as $DepositGetAmount_SP)
                    var DepositGetAmount_SP = "{{ -1*$DepositGetAmount_SP }}";
                    if(!DepositAmountData_SP.includes(DepositGetAmount_SP))
                    {
                        DepositAmountData_SP.push(DepositGetAmount_SP);
                    }
                @endforeach

                var axisData = DepositDateData_SP,
                    data = DepositAmountData_SP,
                    color = '#66bb6a',
                    lineWidth = 1.5;

                // Options
                deposit_chart_SP.setOption({

                    // Global text styles
                    textStyle: {
                        fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                        fontSize: 14
                    },

                    // Setup grid
                    grid: {
                        left: 20,
                        right: 20,
                        bottom: 20,
                        top: 10,
                        containLabel: true
                    },

                    // Add tooltip
                    tooltip: {
                        trigger: 'axis',
                        padding: [10, 15],
                        formatter: '{b} <br/> {c} {a}',
                        axisPointer: {
                            lineStyle: {
                                color: color,
                                type: 'dotted'
                            }
                        }
                    },

                    // Horizontal axis
                    xAxis: {
                        type: "category",
                        boundaryGap: false,
                        data: axisData,
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            show: false
                        },
                        axisLine: {
                            show: false
                        }
                    },

                    // Vertical axis
                    yAxis: {
                        type: 'value',
                        max: function (value) {
                            return value.max;
                        },
                        min: function (value) {
                            return value.min;
                        },
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            show: false
                        },
                        axisLine: {
                            show: false
                        },
                        splitLine: {
                            show: false
                        }
                    },

                    // Add series
                    series: [{
                        name: 'BDT',
                        type: 'line',
                        symbol: 'circle',
                        smooth: true,
                        showSymbol: false,
                        symbolSize: 3,
                        itemStyle: {
                            normal: {
                                color: color,
                                lineStyle: {
                                    color: color,
                                    width: lineWidth
                                },
                                areaStyle: {
                                    color: {
                                        type: 'linear',
                                        x: 0,
                                        y: 0,
                                        x2: 0,
                                        y2: 1,
                                        colorStops: [{
                                            offset: 0,
                                            color: hex2rgba_convert(color, 0.25)
                                        }, {
                                            offset: 1,
                                            color: hex2rgba_convert(color, 0)
                                        }]
                                    }
                                }
                            },
                            emphasis: {
                                borderColor: hex2rgba_convert(color, 0.25),
                                borderWidth: 10
                            }
                        },
                        data: data
                    }]
                });
            }

            // Area chart with gradient - withdraw chart
            if (withdraw_chart_element) {

                // Initialize chart
                var withdraw_chart = echarts.init(withdraw_chart_element);


                //
                // Chart config
                //

                // Define variables
                var WithdrawDateData = [];
                var WithdrawAmountData = [];
                @foreach($WithdrawChartDate as $WithdrawGetDate)
                    var WithdrawGetDate = "{{ $WithdrawGetDate }}";
                    if(!WithdrawDateData.includes(WithdrawGetDate))
                    {
                        WithdrawDateData.push(WithdrawGetDate);
                    }
                @endforeach

                @foreach($WithdrawChartAmount as $WithdrawGetAmount)
                    var WithdrawGetAmount = "{{ $WithdrawGetAmount }}";
                    if(!WithdrawAmountData.includes(WithdrawGetAmount))
                    {
                        WithdrawAmountData.push(WithdrawGetAmount);
                    }
                @endforeach
                var axisData = WithdrawDateData,
                    data = WithdrawAmountData,
                    color = '#0092f6',
                    lineWidth = 1.5;

                // Options
                withdraw_chart.setOption({

                    // Global text styles
                    textStyle: {
                        fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                        fontSize: 14
                    },

                    // Setup grid
                    grid: {
                        left: 20,
                        right: 20,
                        bottom: 20,
                        top: 10,
                        containLabel: true
                    },

                    // Add tooltip
                    tooltip: {
                        trigger: 'axis',
                        padding: [10, 15],
                        formatter: '{b} <br/> {c} {a}',
                        axisPointer: {
                            lineStyle: {
                                color: color,
                                type: 'dotted'
                            }
                        }
                    },

                    // Horizontal axis
                    xAxis: {
                        type: "category",
                        boundaryGap: false,
                        data: axisData,
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            show: false
                        },
                        axisLine: {
                            show: false
                        }
                    },

                    // Vertical axis
                    yAxis: {
                        type: 'value',
                        max: function (value) {
                            return value.max;
                        },
                        min: function (value) {
                            return value.min;
                        },
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            show: false
                        },
                        axisLine: {
                            show: false
                        },
                        splitLine: {
                            show: false
                        }
                    },

                    // Add series
                    series: [{
                        name: 'BDT',
                        type: 'line',
                        symbol: 'circle',
                        smooth: true,
                        showSymbol: false,
                        symbolSize: 3,
                        itemStyle: {
                            normal: {
                                color: color,
                                lineStyle: {
                                    color: color,
                                    width: lineWidth
                                },
                                areaStyle: {
                                    color: {
                                        type: 'linear',
                                        x: 0,
                                        y: 0,
                                        x2: 0,
                                        y2: 1,
                                        colorStops: [{
                                            offset: 0,
                                            color: hex2rgba_convert(color, 0.25)
                                        }, {
                                            offset: 1,
                                            color: hex2rgba_convert(color, 0)
                                        }]
                                    }
                                }
                            },
                            emphasis: {
                                borderColor: hex2rgba_convert(color, 0.25),
                                borderWidth: 10
                            }
                        },
                        data: data
                    }]
                });
            }

            // Area chart with gradient - withdraw chart purchase amount invoice
            if (withdraw_chart_PA_element) {

                // Initialize chart
                var withdraw_chart_PA = echarts.init(withdraw_chart_PA_element);


                //
                // Chart config
                //

                // Define variables
                var WithdrawDateData_PA = [];
                var WithdrawAmountData_PA = [];
                @foreach($WithdrawChartDate_PA as $WithdrawGetDate_PA)
                    var WithdrawGetDate_PA = "{{ $WithdrawGetDate_PA }}";
                    if(!WithdrawDateData_PA.includes(WithdrawGetDate_PA))
                    {
                        WithdrawDateData_PA.push(WithdrawGetDate_PA);
                    }
                @endforeach

                @foreach($WithdrawChartAmount_PA as $WithdrawGetAmount_PA)
                    var WithdrawGetAmount_PA = "{{ $WithdrawGetAmount_PA }}";
                    if(!WithdrawAmountData_PA.includes(WithdrawGetAmount_PA))
                    {
                        WithdrawAmountData_PA.push(WithdrawGetAmount_PA);
                    }
                @endforeach

                var axisData = WithdrawDateData_PA,
                    data = WithdrawAmountData_PA,
                    color = '#ff7043',
                    lineWidth = 1.5;

                // Options
                withdraw_chart_PA.setOption({

                    // Global text styles
                    textStyle: {
                        fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                        fontSize: 14
                    },

                    // Setup grid
                    grid: {
                        left: 20,
                        right: 20,
                        bottom: 20,
                        top: 10,
                        containLabel: true
                    },

                    // Add tooltip
                    tooltip: {
                        trigger: 'axis',
                        padding: [10, 15],
                        formatter: '{b} <br/> {c} {a}',
                        axisPointer: {
                            lineStyle: {
                                color: color,
                                type: 'dotted'
                            }
                        }
                    },

                    // Horizontal axis
                    xAxis: {
                        type: "category",
                        boundaryGap: false,
                        data: axisData,
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            show: false
                        },
                        axisLine: {
                            show: false
                        }
                    },

                    // Vertical axis
                    yAxis: {
                        type: 'value',
                        max: function (value) {
                            return value.max;
                        },
                        min: function (value) {
                            return value.min;
                        },
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            show: false
                        },
                        axisLine: {
                            show: false
                        },
                        splitLine: {
                            show: false
                        }
                    },

                    // Add series
                    series: [{
                        name: 'BDT',
                        type: 'line',
                        symbol: 'circle',
                        smooth: true,
                        showSymbol: false,
                        symbolSize: 3,
                        itemStyle: {
                            normal: {
                                color: color,
                                lineStyle: {
                                    color: color,
                                    width: lineWidth
                                },
                                areaStyle: {
                                    color: {
                                        type: 'linear',
                                        x: 0,
                                        y: 0,
                                        x2: 0,
                                        y2: 1,
                                        colorStops: [{
                                            offset: 0,
                                            color: hex2rgba_convert(color, 0.25)
                                        }, {
                                            offset: 1,
                                            color: hex2rgba_convert(color, 0)
                                        }]
                                    }
                                }
                            },
                            emphasis: {
                                borderColor: hex2rgba_convert(color, 0.25),
                                borderWidth: 10
                            }
                        },
                        data: data
                    }]
                });
            }

            // Area chart with gradient - withdraw chart purchase payment
            if (withdraw_chart_PP_element) {

                // Initialize chart
                var withdraw_chart_PP = echarts.init(withdraw_chart_PP_element);

                //
                // Chart config
                //

                // Define variables
                var WithdrawDateData_PP = [];
                var WithdrawAmountData_PP = [];
                @foreach($WithdrawChartDate_PP as $WithdrawGetDate_PP)
                    var WithdrawGetDate_PP = "{{ $WithdrawGetDate_PP }}";
                    if(!WithdrawDateData_PP.includes(WithdrawGetDate_PP))
                    {
                        WithdrawDateData_PP.push(WithdrawGetDate_PP);
                    }
                @endforeach

                @foreach($WithdrawChartAmount_PP as $WithdrawGetAmount_PP)
                    var WithdrawGetAmount_PP = "{{ $WithdrawGetAmount_PP }}";
                    if(!WithdrawAmountData_PP.includes(WithdrawGetAmount_PP))
                    {
                        WithdrawAmountData_PP.push(WithdrawGetAmount_PP);
                    }
                @endforeach

                var axisData = WithdrawDateData_PP,
                    data = WithdrawAmountData_PP,
                    color = '#66bb6a',
                    lineWidth = 1.5;

                // Options
                withdraw_chart_PP.setOption({

                    // Global text styles
                    textStyle: {
                        fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                        fontSize: 14
                    },

                    // Setup grid
                    grid: {
                        left: 20,
                        right: 20,
                        bottom: 20,
                        top: 10,
                        containLabel: true
                    },

                    // Add tooltip
                    tooltip: {
                        trigger: 'axis',
                        padding: [10, 15],
                        formatter: '{b} <br/> {c} {a}',
                        axisPointer: {
                            lineStyle: {
                                color: color,
                                type: 'dotted'
                            }
                        }
                    },

                    // Horizontal axis
                    xAxis: {
                        type: "category",
                        boundaryGap: false,
                        data: axisData,
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            show: false
                        },
                        axisLine: {
                            show: false
                        }
                    },

                    // Vertical axis
                    yAxis: {
                        type: 'value',
                        max: function (value) {
                            return value.max;
                        },
                        min: function (value) {
                            return value.min;
                        },
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            show: false
                        },
                        axisLine: {
                            show: false
                        },
                        splitLine: {
                            show: false
                        }
                    },

                    // Add series
                    series: [{
                        name: 'BDT',
                        type: 'line',
                        symbol: 'circle',
                        smooth: true,
                        showSymbol: false,
                        symbolSize: 3,
                        itemStyle: {
                            normal: {
                                color: color,
                                lineStyle: {
                                    color: color,
                                    width: lineWidth
                                },
                                areaStyle: {
                                    color: {
                                        type: 'linear',
                                        x: 0,
                                        y: 0,
                                        x2: 0,
                                        y2: 1,
                                        colorStops: [{
                                            offset: 0,
                                            color: hex2rgba_convert(color, 0.25)
                                        }, {
                                            offset: 1,
                                            color: hex2rgba_convert(color, 0)
                                        }]
                                    }
                                }
                            },
                            emphasis: {
                                borderColor: hex2rgba_convert(color, 0.25),
                                borderWidth: 10
                            }
                        },
                        data: data
                    }]
                });
            }


            //
            // Resize charts
            //

            // Resize function
            var triggerChartResize = function() {
                deposit_chart_element && deposit_chart.resize();
                deposit_chart_SI_element && deposit_chart_SI.resize();
                deposit_chart_SP_element && deposit_chart_SP.resize();

                withdraw_chart_element && withdraw_chart.resize();
                withdraw_chart_element && withdraw_chart_PA.resize();
                withdraw_chart_element && withdraw_chart_PP.resize();
            };

            // On sidebar width change
            var sidebarToggle = document.querySelectorAll('.sidebar-control');
            if (sidebarToggle) {
                sidebarToggle.forEach(function(togglers) {
                    togglers.addEventListener('click', triggerChartResize);
                });
            }

            // On window resize
            var resizeCharts;
            window.addEventListener('resize', function() {
                clearTimeout(resizeCharts);
                resizeCharts = setTimeout(function () {
                    triggerChartResize();
                }, 200);
            });
        };


        //
        // Return objects assigned to module
        //

        return {
            init: function() {
                _areaGradientExample();
            }
        }
    }();


    // Initialize module
    // ------------------------------

    document.addEventListener('DOMContentLoaded', function() {
        EchartsAreaGradientLight.init();
    });
</script>
<!--TOP 6 CHART-->

<!--BANK BAR CHART-->
<script>
    /* ------------------------------------------------------------------------------
    *
    *  # Echarts - sortable progress bars example
    *
    *  Demo JS code for sortable progress bar chart [light theme]
    *
    * ---------------------------------------------------------------------------- */


    // Setup module
    // ------------------------------

    var EchartsProgressBarSortedLight = function() {


        //
        // Setup module components
        //

        // Basic bar chart
        var _progressBarSortedExample = function() {
            if (typeof echarts == 'undefined') {
                console.warn('Warning - echarts.min.js is not loaded.');
                return;
            }

            // Define element
            var progress_deposit_vs_withdraw_element = document.getElementById('progress_deposit_vs_withdraw');

            // Chart configuration
            if (progress_deposit_vs_withdraw_element) {

                // Initialize chart
                var progress_deposit_vs_withdraw = echarts.init(progress_deposit_vs_withdraw_element);

                //
                // Chart config
                //

                var DepositVsWithdrawArray = [];
                @foreach($depositWithdrawArray as $keyData=>$valueData)
                    var DWName = "{{ $valueData['name'] }}";
                    var DWValue = "{{ $valueData['total_balance'] }}";

                    var DWObj = {
                        name: DWName,
                        value: DWValue
                    };

                    if(!DepositVsWithdrawArray.includes(DWObj))
                    {
                        DepositVsWithdrawArray.push(DWObj);
                    }
                @endforeach
                // Data
                var data = DepositVsWithdrawArray;

                // Sort data
                data = data.sort(function(a, b) {
                    return b.value - a.value
                });

                // Main vars
                var nameData = [],
                    valueData = [],
                    len = data.length,
                    foregroundColor = '#1990FF',
                    backgroundColor = '#b82323',
                    barWidth = 5;

                // Bars foreground
                for (var i = 0; i < len; i++) {
                    nameData.push(data[i].name);
                    valueData.push({
                        name: data[i].name,
                        visitors: data[i].visitors,
                        sales: data[i].sales,
                        value: data[i].value
                    });
                }

                // Options
                progress_deposit_vs_withdraw.setOption({

                    // Global text styles
                    textStyle: {
                        fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                        fontSize: 14
                    },

                    // Chart grid
                    grid: {
                        top: 0,
                        bottom: -20,
                        right: 40,
                        left: 0,
                        containLabel: true
                    },

                    // Tooltip
                    tooltip: {
                        show: true,
                        trigger: 'item',
                        padding: [5, 10],
                        formatter: function (params, i) {
                            //return 'Visitors: ' + params.data.visitors + '<br>Sales: ' + params.data.sales + '<br>Conversion rate：' + (params.data.visitors / params.data.sales).toFixed(2) + '%';
                        }
                    },

                    // Horizontal axis
                    xAxis: {
                        show: false
                    },

                    // Vertical axis
                    yAxis: [
                        {
                            show: true,
                            inverse: true,
                            data: nameData,
                            axisLine: {
                                show: false
                            },
                            splitLine: {
                                show: false
                            },
                            axisTick: {
                                show: false
                            },
                            axisLabel: {
                                margin: 20,
                                fontSize: 14
                            }
                        },
                        {
                            show: true,
                            inverse: true,
                            data: nameData,
                            axisLine: {
                                show: false
                            },
                            splitLine: {
                                show: false
                            },
                            axisTick: {
                                show: false
                            },
                            axisLabel: {
                                align: 'left',
                                margin: 20,
                                fontSize: 14,
                                fontWeight: 500,
                                formatter: function (value, index) {
                                    return '৳' + data[index].value.toLocaleString();
                                }
                            }
                        }
                    ],

                    // Chart series
                    series: [
                        {
                            name: 'Foreground',
                            type: 'bar',
                            data: valueData,
                            barWidth: barWidth,
                            itemStyle: {
                                color: foregroundColor,
                                barBorderRadius: 30
                            },
                            z: 10,
                            showBackground: true,
                            backgroundStyle: {
                                barBorderRadius: 30,
                                color: backgroundColor
                            }
                        }
                    ]
                });
            }


            //
            // Resize charts
            //

            // Resize function
            var triggerChartResize = function() {
                progress_deposit_vs_withdraw_element && progress_deposit_vs_withdraw.resize();
            };

            // On sidebar width change
            var sidebarToggle = document.querySelectorAll('.sidebar-control');
            if (sidebarToggle) {
                sidebarToggle.forEach(function(togglers) {
                    togglers.addEventListener('click', triggerChartResize);
                });
            }

            // On window resize
            var resizeCharts;
            window.addEventListener('resize', function() {
                clearTimeout(resizeCharts);
                resizeCharts = setTimeout(function () {
                    triggerChartResize();
                }, 200);
            });
        };


        //
        // Return objects assigned to module
        //

        return {
            init: function() {
                _progressBarSortedExample();
            }
        }
    }();

    // Initialize module
    // ------------------------------

    document.addEventListener('DOMContentLoaded', function() {
        EchartsProgressBarSortedLight.init();
    });
</script>
<!--BANK BAR CHART-->

<script>
    /* ------------------------------------------------------------------------------
    *
    *  # Echarts - Basic pie example
    *
    *  Demo JS code for basic pie chart [light theme]
    *
    * ---------------------------------------------------------------------------- */


    // Setup module
    // ------------------------------

    var EchartsPieBasicLight = function() {


    //
    // Setup module components
    //

    // Basic pie chart
    var _scatterPieBasicLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var ar_vs_ap_element = document.getElementById('ar_vs_ap');


        //
        // Charts configuration
        //

        if (ar_vs_ap_element) {

            // Initialize chart
            var ar_vs_ap = echarts.init(ar_vs_ap_element);


            //
            // Chart config
            //

            // Options
            var ar_balance = "{{ $ARbankSum }}";
            var ap_balance = "{{ $APbankSum }}";
            ar_vs_ap.setOption({

                // Colors
                color: [
                    '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80',
                    '#8d98b3','#e5cf0d','#97b552','#95706d','#dc69aa',
                    '#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
                    '#59678c','#c9ab00','#7eb00a','#6f5553','#c14089'
                ],

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Add title
                title: {
                    text: 'AR vs AP',
                    subtext: '',
                    left: 'center',
                    textStyle: {
                        fontSize: 17,
                        fontWeight: 500
                    },
                    subtextStyle: {
                        fontSize: 12
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'item',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    },
                    formatter: "{a} <br/>{b}: {c} ({d}%)"
                },

                // Add legend
                legend: {
                    orient: 'vertical',
                    top: 'center',
                    left: 0,
                    data: ['AR', 'AP'],
                    itemHeight: 8,
                    itemWidth: 8
                },

                // Add series
                series: [{
                    name: 'AR vs AP',
                    type: 'pie',
                    radius: '70%',
                    center: ['50%', '57.5%'],
                    itemStyle: {
                        normal: {
                            borderWidth: 1,
                            borderColor: '#fff'
                        }
                    },
                    data: [
                        {value: ar_balance, name: 'AR'},
                        {value: ap_balance, name: 'AP'}
                    ]
                }]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            ar_vs_ap_element && ar_vs_ap.resize();
        };

        // On sidebar width change
        var sidebarToggle = document.querySelectorAll('.sidebar-control');
        if (sidebarToggle) {
            sidebarToggle.forEach(function(togglers) {
                togglers.addEventListener('click', triggerChartResize);
            });
        }

        // On window resize
        var resizeCharts;
        window.addEventListener('resize', function() {
            clearTimeout(resizeCharts);
            resizeCharts = setTimeout(function () {
                triggerChartResize();
            }, 200);
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _scatterPieBasicLightExample();
        }
    }
    }();


    // Initialize module
    // ------------------------------

    document.addEventListener('DOMContentLoaded', function() {
    EchartsPieBasicLight.init();
    });
</script>
@endpush
