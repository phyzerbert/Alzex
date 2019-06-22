@extends('layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('master/global_assets/js/plugins/daterangepicker/daterangepicker.css')}}">
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">{{__('page.home')}}</span> - {{__('page.dashboard')}}</h4>
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
                        <a href="{{url('/')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> {{__('page.home')}}</a>
                        <span class="breadcrumb-item active">{{__('page.dashboard')}}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">{{__('page.overview')}}</h5>
                    <div class="form-search">
                        <form action="" class="form-inline" method="post">
                            @csrf
                            <input type="text" name="period" id="overview-period" class="form-control form-control-sm period" value="{{$period}}" placeholder="{{__('page.timestamp')}}" autocomplete="off" style="min-width:200px;">
                            <button type="submit" class="btn btn-primary btn-sm ml-2"><i class="icon-search4"></i> {{__('page.search')}}</button>
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
            {{-- User Chart --}}
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">{{__('page.user_overview')}}</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                            <a class="list-icons-item" data-action="remove"></a>
                        </div>
                    </div>
                </div>
                @php
                    $user_key_array = $user_expense_array = $user_incoming_array = array();
                    for ($i=0; $i < count($search_users); $i++) { 
                        $item = \App\User::find($search_users[$i]);
                        array_push($user_key_array, $item->name);
                        $user_expense = $item->transactions()->where('type', 1)->whereBetween('timestamp', [$from, $to])->sum('amount');
                        $user_incoming = $item->transactions()->where('type', 2)->whereBetween('timestamp', [$from, $to])->sum('amount');
                        array_push($user_expense_array, $user_expense);
                        array_push($user_incoming_array, $user_incoming);
                    }
                @endphp

                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart has-fixed-height" id="user_chart"></div>
                    </div>
                </div>
            </div>
            {{-- Category Chart --}}
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">{{__('page.category_overview')}}</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                            <a class="list-icons-item" data-action="remove"></a>
                        </div>
                    </div>
                </div>
                @php
                    $category_key_array = $category_expense_array = $category_incoming_array = array();
                    for ($i=0; $i < count($search_categories); $i++) { 
                        $item = \App\Models\Category::find($search_categories[$i]);
                        array_push($category_key_array, $item->name);
                        $category_expense = $item->transactions()->where('type', 1)->whereBetween('timestamp', [$from, $to])->sum('amount');
                        $category_incoming = $item->transactions()->where('type', 2)->whereBetween('timestamp', [$from, $to])->sum('amount');
                        array_push($category_expense_array, $category_expense);
                        array_push($category_incoming_array, $category_incoming);
                    }
                @endphp

                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart has-fixed-height" id="category_chart"></div>
                    </div>
                </div>
            </div>

            {{-- Account Chart --}}
            <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">{{__('page.account_overview')}}</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                                <a class="list-icons-item" data-action="reload"></a>
                                <a class="list-icons-item" data-action="remove"></a>
                            </div>
                        </div>
                    </div>
                    @php
                        $account_key_array = $account_expense_array = $account_incoming_array = array();
                        for ($i=0; $i < count($search_accounts); $i++) { 
                            $item = \App\Models\Account::find($search_accounts[$i]);
                            array_push($account_key_array, $item->name);
                            $account_expense = $item->expenses()->whereBetween('timestamp', [$from, $to])->sum('amount');
                            $account_incoming = $item->incomings()->whereBetween('timestamp', [$from, $to])->sum('amount');
                            array_push($account_expense_array, $account_expense);
                            array_push($account_incoming_array, $account_incoming);
                        }
                    @endphp
    
                    <div class="card-body">
                        <div class="chart-container">
                            <div class="chart has-fixed-height" id="account_chart"></div>
                        </div>
                    </div>
                </div>
        </div>                
    </div>                
@endsection

@section('script')
<script src="{{asset('master/global_assets/js/plugins/daterangepicker/jquery.daterangepicker.min.js')}}"></script>
    <script src="{{asset('master/global_assets/js/plugins/visualization/echarts/echarts.min.js')}}"></script>
    <script>
        var Chart_overview = function() {

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

            return {
                init: function() {
                    dashboard_chart();
                }
            }
        }();

        var Chart_user = function() {

            var _columnsWaterfallsExamples = function() {
                if (typeof echarts == 'undefined') {
                    console.warn('Warning - echarts.min.js is not loaded.');
                    return;
                }

                // Define elements
                var columns_basic_element = document.getElementById('user_chart');

                // Basic columns chart
                if (columns_basic_element) {

                    // Initialize chart
                    var columns_basic = echarts.init(columns_basic_element);

                    // Options
                    columns_basic.setOption({

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
                            itemGap: 20,
                            textStyle: {
                                padding: [0, 5]
                            }
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
                            data: {!! json_encode($user_key_array) !!},
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
                                    color: ['#eee']
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
                                type: 'bar',
                                data: {!! json_encode($user_expense_array) !!},
                                itemStyle: {
                                    normal: {
                                        label: {
                                            show: true,
                                            position: 'top',
                                            textStyle: {
                                                fontWeight: 500
                                            }
                                        }
                                    }
                                },
                                markLine: {
                                    data: [{type: 'average', name: 'Average'}]
                                }
                            },
                            {
                                name: 'Incoming',
                                type: 'bar',
                                data: {!! json_encode($user_incoming_array) !!},
                                itemStyle: {
                                    normal: {
                                        label: {
                                            show: true,
                                            position: 'top',
                                            textStyle: {
                                                fontWeight: 500
                                            }
                                        }
                                    }
                                },
                                markLine: {
                                    data: [{type: 'average', name: 'Average'}]
                                }
                            }
                        ]
                    });
                }

                var triggerChartResize = function() {
                    columns_basic_element && columns_basic.resize();
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

            return {
                init: function() {
                    _columnsWaterfallsExamples();
                }
            }
        }();

        var Chart_category = function() {

            var category_chart = function() {
                if (typeof echarts == 'undefined') {
                    console.warn('Warning - echarts.min.js is not loaded.');
                    return;
                }

                // Define elements
                var category_element = document.getElementById('category_chart');

                // Basic columns chart
                if (category_element) {

                    // Initialize chart
                    var columns_category = echarts.init(category_element);

                    // Options
                    columns_category.setOption({

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
                            itemGap: 20,
                            textStyle: {
                                padding: [0, 5]
                            }
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
                            data: {!! json_encode($category_key_array) !!},
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
                                    color: ['#eee']
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
                                type: 'bar',
                                data: {!! json_encode($category_expense_array) !!},
                                itemStyle: {
                                    normal: {
                                        label: {
                                            show: true,
                                            position: 'top',
                                            textStyle: {
                                                fontWeight: 500
                                            }
                                        }
                                    }
                                },
                                markLine: {
                                    data: [{type: 'average', name: 'Average'}]
                                }
                            },
                            {
                                name: 'Incoming',
                                type: 'bar',
                                data: {!! json_encode($category_incoming_array) !!},
                                itemStyle: {
                                    normal: {
                                        label: {
                                            show: true,
                                            position: 'top',
                                            textStyle: {
                                                fontWeight: 500
                                            }
                                        }
                                    }
                                },
                                markLine: {
                                    data: [{type: 'average', name: 'Average'}]
                                }
                            }
                        ]
                    });
                }

                var triggerChartResize = function() {
                    category_element && columns_category.resize();
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

            return {
                init: function() {
                    category_chart();
                }
            }
        }();

        var Chart_account = function() {

            var account_chart = function() {
                if (typeof echarts == 'undefined') {
                    console.warn('Warning - echarts.min.js is not loaded.');
                    return;
                }

                // Define elements
                var account_element = document.getElementById('account_chart');

                // Basic columns chart
                if (account_element) {

                    // Initialize chart
                    var columns_account = echarts.init(account_element);

                    // Options
                    columns_account.setOption({

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
                            itemGap: 20,
                            textStyle: {
                                padding: [0, 5]
                            }
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
                            data: {!! json_encode($account_key_array) !!},
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
                                    color: ['#eee']
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
                                type: 'bar',
                                data: {!! json_encode($account_expense_array) !!},
                                itemStyle: {
                                    normal: {
                                        label: {
                                            show: true,
                                            position: 'top',
                                            textStyle: {
                                                fontWeight: 500
                                            }
                                        }
                                    }
                                },
                                markLine: {
                                    data: [{type: 'average', name: 'Average'}]
                                }
                            },
                            {
                                name: 'Incoming',
                                type: 'bar',
                                data: {!! json_encode($account_incoming_array) !!},
                                itemStyle: {
                                    normal: {
                                        label: {
                                            show: true,
                                            position: 'top',
                                            textStyle: {
                                                fontWeight: 500
                                            }
                                        }
                                    }
                                },
                                markLine: {
                                    data: [{type: 'average', name: 'Average'}]
                                }
                            }
                        ]
                    });
                }

                var triggerChartResize = function() {
                    account_element && columns_account.resize();
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

            return {
                init: function() {
                    account_chart();
                }
            }
        }();



        

        document.addEventListener('DOMContentLoaded', function() {
            Chart_overview.init();
            Chart_user.init();
            Chart_category.init();
            Chart_account.init();
        });

    </script>
    <script>
        $(document).ready(function(){
            $(".period").dateRangePicker();
        });
    </script>
@endsection
