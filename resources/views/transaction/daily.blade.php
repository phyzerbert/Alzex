@extends('layouts.master')
@section('style')
    {{-- <link rel="stylesheet" href="{{asset('master/global_assets/js/plugins/daterangepicker/daterangepicker.css')}}"> --}}
@endsection
@section('content')
    @php
        $role = Auth::user()->role->slug;
    @endphp
    <div class="content-wrapper">
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">{{__('page.home')}}</span> - {{__('page.transaction')}}</h4>
                    <a href="index.html#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>
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
                        <span class="breadcrumb-item active">{{__('page.transaction')}}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content">
            <div class="card">
                <div class="card-header">
                    <form class="form-inline ml-3 float-left" action="{{route('set_pagesize')}}" method="post" id="pagesize_form">
                        @csrf
                        <label for="pagesize" class="control-label">{{__('page.show')}} :</label>
                        <select class="form-control form-control-sm mx-2" name="pagesize" id="pagesize">
                            <option value="" @if($pagesize == '') selected @endif>{{__('page.all')}}</option>
                            <option value="25" @if($pagesize == '25') selected @endif>25</option>
                            <option value="50" @if($pagesize == '50') selected @endif>50</option>
                            <option value="100" @if($pagesize == '100') selected @endif>100</option>
                        </select>
                    </form>
                    @include('transaction.daily_filter')
                    <a href="{{route('transaction.create')}}" class="btn btn-primary btn-sm float-right" id="btn-add"><i class="icon-plus-circle2 mr-2"></i> {{__('page.add_new')}}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-blue">
                                    <th style="width:30px;">#</th>
                                    <th>{{__('page.date')}}</th>
                                    <th>{{__('page.category')}}</th>
                                    <th>{{__('page.description')}}</th>
                                    <th>{{__('page.amount')}}</th>
                                    <th>{{__('page.withdraw_from')}}</th>
                                    <th>{{__('page.target_account')}}</th>
                                    <th>{{__('page.user')}}</th>
                                    <th>{{__('page.type')}}</th>
                                    @if($role == 'admin')
                                        <th>{{__('page.action')}}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="date">{{ date('Y-m-d', strtotime($item->timestamp))}}</td>
                                        <td class="category">{{$item->category->name}}</td>
                                        <td class="description">
                                            {{$item->description}}
                                            @if ($item->attachment != "")
                                                <a href="#" class="btn-attach" data-value="{{$item->attachment}}"><i class="icon-attachment"></i></a>
                                            @endif
                                        </td>
                                        <td class="amount">
                                            @if ($item->type == 1)
                                                <span style="color:red">-{{ number_format($item->amount) }}</span>
                                            @elseif($item->type == 2)
                                                <span style="color:green">{{ number_format($item->amount) }}</span>
                                            @else
                                                {{ number_format($item->amount) }}
                                            @endif
                                        </td>
                                        <td class="from">@isset($item->account->name){{$item->account->name}}@endisset</td>
                                        <td class="to">@isset($item->target->name){{$item->target->name}}@endisset</td>
                                        <td class="user">{{$item->user->name}}</td>
                                        <td class="type">
                                            @php
                                                $types = array(__('page.expense'), __('page.incoming'), __('page.transfer'));
                                            @endphp
                                            {{$types[$item->type-1]}}
                                        </td>
                                        @if($role == 'admin')
                                            <td class="py-1" style="min-width:130px;">
                                                <a href="{{route('transaction.edit', $item->id)}}" class="btn bg-blue btn-icon rounded-round btn-edit" data-id="{{$item->id}}"  data-popup="tooltip" title="{{__('page.edit')}}" data-placement="top"><i class="icon-pencil7"></i></a>
                                                <a href="{{route('transaction.delete', $item->id)}}" class="btn bg-danger text-pink-800 btn-icon rounded-round ml-2" data-popup="tooltip" title="{{__('page.delete')}}" data-placement="top" onclick="return window.confirm('{{__('page.are_you_sure')}}')"><i class="icon-trash"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="text-danger text-center">
                                <tr>
                                    <td colspan="2">{{__('page.total')}}</td>
                                    <td colspan="3">{{__('page.expenses')}} : -{{number_format($expenses)}}</td>
                                    <td colspan="3">{{__('page.incomes')}} : {{number_format($incomes)}}</td>
                                    <td colspan="2">{{__('page.profit')}} : {{number_format($incomes - $expenses)}}</td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="clearfix mt-1">
                            <div class="float-left" style="margin: 0;">
                                <p>{{__('page.total')}} <strong style="color: red">{{ $data->total() }}</strong> {{__('page.items')}}</p>
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
{{-- <script src="{{asset('master/global_assets/js/plugins/daterangepicker/jquery.daterangepicker.min.js')}}"></script> --}}
<script src="{{asset('master/global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
<script src="{{asset('master/global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#search_period').daterangepicker({ 
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
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

        $("#pagesize").change(function(){
            $("#pagesize_form").submit();
        })
    });
</script>
@endsection
