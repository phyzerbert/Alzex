@extends('layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('master/global_assets/js/plugins/daterangepicker/daterangepicker.css')}}">
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Dashboard</h4>
                    <a href="index.html#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>
                @php
                    $accountgroups = \App\Models\Accountgroup::all();
                @endphp                
                <div class="header-elements d-flex">
                    <div class="d-flex justify-content-center">
                        <div class="btn-group justify-content-center">
                            <a href="#" class="btn bg-primary-400 dropdown-toggle" data-toggle="dropdown"><i class="icon-wallet"></i>  Account Balance</a>
                            <div class="dropdown-menu">
                                @foreach ($accountgroups as $accountgroup)
                                    <div class="dropdown-header dropdown-header-highlight">{{$accountgroup->name}}</div>
                                    @foreach ($accountgroup->accounts as $item)                                         
                                        <div class="dropdown-item"><div class="flex-grow-1">{{$item->name}}</div><div class="">{{$item->balance}}</div></div>
                                    @endforeach
                                    <div class="dropdown-divider"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="{{url('/')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                        <span class="breadcrumb-item active">Dashboard</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Overview</h5>
                    <div class="form-search">
                        <form action="" class="form-inline" method="post">
                            @csrf
                            <input type="text" name="period" id="overview-period" class="form-control form-control-sm period" value="{{$period}}" placeholder="Timestamp" style="min-width:200px;">
                            <button type="submit" class="btn btn-primary btn-sm ml-2"><i class="icon-search4"></i> Search</button>
                        </form>
                    </div>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                            <a class="list-icons-item" data-action="remove"></a>
                        </div>
                    </div>
                </div>
                @php
                    use Carbon\Carbon;

                    $now = Carbon::now();
                    $mod1 = new \App\Models\Transaction;
                    $mod2 = new \App\Models\Transaction;

                    if($from != '' && $to != ''){
                        $chart_start = Carbon::createFromFormat('Y-m-d', $from);
                        $chart_end = Carbon::createFromFormat('Y-m-d', $to);
                    }else{
                        $chart_start = Carbon::now()->startOfMonth();
                        $chart_end = Carbon::now()->endOfMonth();
                    }
                    
                    $key_array = $expense_array = $incoming_array = array();

                    for ($dt=$chart_start; $dt < $chart_end; $dt->addDay()) {
                        $key = $dt->format('Y-m-d');
                        $key1 = $dt->format('M/d');
                        array_push($key_array, $key1);
                        $daily_expense = $mod1->where('type', 1)->whereDate('timestamp', $key)->sum('amount');
                        $daily_incoming = $mod2->where('type', 2)->whereDate('timestamp', $key)->sum('amount');
                        array_push($expense_array, $daily_expense);
                        array_push($incoming_array, $daily_incoming);
                    }

                @endphp

                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart has-fixed-height" id="overview_chart"></div>
                    </div>
                </div>
            </div>
        </div>                
    </div>                
@endsection

@section('script')
<script src="{{asset('master/global_assets/js/plugins/daterangepicker/jquery.daterangepicker.min.js')}}"></script>
    <script src="{{asset('master/global_assets/js/plugins/visualization/echarts/echarts.min.js')}}"></script>
    <script src="{{asset('master/assets/js/app.js')}}"></script>
    <script>
        var EchartsAreas = function() {

            var dashboard_chart = function() {
                if (typeof echarts == 'undefined') {
                    console.warn('Warning - echarts.min.js is not loaded.');
                    return;
                }

                // Define elements
                var area_basic_element = document.getElementById('overview_chart');

                if (area_basic_element) {

                    var area_basic = echarts.init(area_basic_element);

                    area_basic.setOption({

                        // Define colors
                        color: ['#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80'],

                        // Global text styles
                        textStyle: {
                            fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                            fontSize: 13
                        },

                        // Chart animation duration
                        animationDuration: 750,

                        // Setup grid
                        grid: {
                            left: 0,
                            right: 40,
                            top: 35,
                            bottom: 0,
                            containLabel: true
                        },

                        // Add legend
                        legend: {
                            data: ['Expense', 'Incoming'],
                            itemHeight: 8,
                            itemGap: 20
                        },

                        // Add tooltip
                        tooltip: {
                            trigger: 'axis',
                            backgroundColor: 'rgba(0,0,0,0.75)',
                            padding: [10, 15],
                            textStyle: {
                                fontSize: 13,
                                fontFamily: 'Roboto, sans-serif'
                            }
                        },

                        // Horizontal axis
                        xAxis: [{
                            type: 'category',
                            boundaryGap: false,
                            data: {!! json_encode($key_array) !!},
                            axisLabel: {
                                color: '#333'
                            },
                            axisLine: {
                                lineStyle: {
                                    color: '#999'
                                }
                            },
                            splitLine: {
                                show: true,
                                lineStyle: {
                                    color: '#eee',
                                    type: 'dashed'
                                }
                            }
                        }],

                        // Vertical axis
                        yAxis: [{
                            type: 'value',
                            axisLabel: {
                                color: '#333'
                            },
                            axisLine: {
                                lineStyle: {
                                    color: '#999'
                                }
                            },
                            splitLine: {
                                lineStyle: {
                                    color: '#eee'
                                }
                            },
                            splitArea: {
                                show: true,
                                areaStyle: {
                                    color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                                }
                            }
                        }],

                        // Add series
                        series: [
                            {
                                name: 'Expense',
                                type: 'line',
                                data: {!! json_encode($expense_array) !!},
                                areaStyle: {
                                    normal: {
                                        opacity: 0.25
                                    }
                                },
                                smooth: true,
                                symbolSize: 7,
                                itemStyle: {
                                    normal: {
                                        borderWidth: 2
                                    }
                                }
                            },
                            {
                                name: 'Incoming',
                                type: 'line',
                                smooth: true,
                                symbolSize: 7,
                                itemStyle: {
                                    normal: {
                                        borderWidth: 2
                                    }
                                },
                                areaStyle: {
                                    normal: {
                                        opacity: 0.25
                                    }
                                },
                                data: {!! json_encode($incoming_array) !!}
                            }
                        ]
                    });
                }

                // Resize function
                var triggerChartResize = function() {
                    area_basic_element && area_basic.resize();
                };

                // On sidebar width change
                $(document).on('click', '.sidebar-control', function() {
                    setTimeout(function () {
                        triggerChartResize();
                    }, 0);
                });

                // On window resize
                var resizeCharts;
                window.onresize = function () {
                    clearTimeout(resizeCharts);
                    resizeCharts = setTimeout(function () {
                        triggerChartResize();
                    }, 200);
                };
            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    dashboard_chart();
                }
            }
        }();


            // Initialize module
            // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            EchartsAreas.init();
        });

    </script>
    <script>
        $(document).ready(function(){
            $(".period").dateRangePicker();
        });
    </script>
@endsection
