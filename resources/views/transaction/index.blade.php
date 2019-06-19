@extends('layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('master/global_assets/js/plugins/daterangepicker/daterangepicker.css')}}">
@endsection
@section('content')
    @php
        $role = Auth::user()->role->slug;
    @endphp
    <div class="content-wrapper">
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Transaction</h4>
                    <a href="index.html#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    <div class="d-flex justify-content-center">
                    </div>
                </div>
            </div>

            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="{{url('/')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                        <span class="breadcrumb-item active">Transaction</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content">
            <div class="card">
                <div class="card-header">
                    @include('transaction.filter')
                    <a href="{{route('transaction.create')}}" class="btn btn-primary btn-sm float-right" id="btn-add"><i class="icon-plus-circle2 mr-2"></i> Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-blue">
                                    <th style="width:30px;">#</th>
                                    <th>Type</th>
                                    <th>User</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Withdraw From</th>
                                    <th>Target Account</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    @if($role == 'admin')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="type">
                                            @php
                                                $types = array('Expense', 'Incoming', 'Transfer');
                                            @endphp
                                            {{$types[$item->type-1]}}
                                        </td>
                                        <td class="user">{{$item->user->name}}</td>
                                        <td class="category">{{$item->category->name}}</td>
                                        <td class="amount">{{$item->amount}}</td>
                                        <td class="from">@isset($item->account->name){{$item->account->name}}@endisset</td>
                                        <td class="to">@isset($item->target->name){{$item->target->name}}@endisset</td>
                                        <td class="date">{{ date('Y-m-d', strtotime($item->timestamp))}}</td>
                                        <td class="description">
                                            {{$item->description}}
                                            @if ($item->attachment != "")
                                                <a href="#" class="btn-attach" data-value="{{$item->attachment}}"><i class="icon-attachment"></i></a>
                                            @endif
                                        </td>
                                        @if($role == 'admin')
                                            <td class="py-1" style="min-width:130px;">
                                                <a href="#" class="btn bg-blue btn-icon rounded-round btn-edit" data-id="{{$item->id}}"  data-popup="tooltip" title="Edit" data-placement="top"><i class="icon-pencil7"></i></a>
                                                <a href="{{route('transaction.delete', $item->id)}}" class="btn bg-danger text-pink-800 btn-icon rounded-round ml-2" data-popup="tooltip" title="Delete" data-placement="top" onclick="return window.confirm('Are you sure?')"><i class="icon-trash"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="text-danger text-center">
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td colspan="3">Expenses : {{$expenses}}</td>
                                    <td colspan="3">Incomes : {{$incomes}}</td>
                                    <td colspan="2">Profit : {{$incomes - $expenses}}</td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="clearfix mt-1">
                            <div class="float-left" style="margin: 0;">
                                <p>Total <strong style="color: red">{{ $data->total() }}</strong> Items</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data->appends(['user' => $user, 'category' => $category, 'type' => $type, 'account' => $account, ''])->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                
    </div>

    <div class="modal fade" id="attachModal">
        <div class="modal-dialog" style="margin-top:17vh">
            <div class="modal-content">
                <img src="" id="attachment" width="100%" height="600" alt="">
            </div>
        </div>
    </div>

@endsection

@section('script')
<script src="{{asset('master/global_assets/js/plugins/daterangepicker/jquery.daterangepicker.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $("#period").dateRangePicker({
            autoClose: false,
        });
        $(".btn-attach").click(function(e){
            e.preventDefault();
            let path = '{{asset("/")}}' + $(this).data('value');
            $("#attachment").attr('src', path);
            $("#attachModal").modal();
        });
        $("#btn-reset").click(function(){
            $("#search_user").val('');
            $("#search_category").val('');
            $("#search_account").val('');
            $("#search_type").val('');
            $("#period").val('');
        });
    });
</script>
@endsection