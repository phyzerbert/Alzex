@extends('layouts.master')
@section('style')
    
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">{{__('page.home')}}</span> - {{__('page.transaction')}}</h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    <div class="d-flex justify-content-center">
                    </div>
                </div>
            </div>

            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="{{url('/')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> {{__('page.home')}}</a>
                        <a href="{{route('transaction.index')}}" class="breadcrumb-item">{{__('page.transaction')}}</a>
                        <span class="breadcrumb-item active">{{__('page.edit')}}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container content">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-info">
                        @if ($item->type == 1)
                            {{__('page.expense')}}
                        @elseif ($item->type == 2)
                            {{__('page.incoming')}}
                        @elseif ($item->type == 3)
                            {{__('page.transfer')}}
                        @endif
                    </h4>
                </div>
                @if ($item->type == 1)
                    <div class="card-body" id="expense">                            
                        <form action="{{route('transaction.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <div class="form-group">
                                <label>{{__('page.user')}}:</label>
                                <select data-placeholder="Select user" name="user" class="form-control form-control-select2" data-fouc>
                                    @foreach ($users as $user)
                                        <option value={{$user->id}} @if($item->user_id == $user->id) selected @endif>{{$user->name}}</option>
                                    @endforeach
                                </select>
                                @error('user')
                                    <span class="form-text text-success">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{__('page.category')}}:</label>
                                <select data-placeholder="Select category" name="category" class="form-control form-control-select2" data-fouc>
                                    @foreach ($categories as $category)
                                        <option value={{$category->id}} @if($item->category_id == $category->id) selected @endif>{{$category->name}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <span class="form-text text-success">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{__('page.withdraw_from')}}:</label>
                                <select data-placeholder="{{__('page.withdraw_from')}}" name="account" class="form-control form-control-select2-icons" data-fouc>
                                    @foreach ($accountgroups as $accountgroup)
                                        <optgroup label="{{$accountgroup->name}}">
                                            @foreach ($accountgroup->accounts as $account)
                                                <option value="{{$account->id}}" @if($item->from == $account->id) selected @endif data-icon="wallet">{{$account->name}}</option>                                            
                                            @endforeach
                                        </optgroup>
                                    @endforeach                                
                                </select>
                                @error('account')
                                    <span class="form-text text-success">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{__('page.date')}}:</label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar"></i></span>
                                    </span>
                                <input type="text" name="timestamp" class="form-control pickadate" value="{{date('Y-m-d', strtotime($item->timestamp))}}" placeholder="{{__('page.date')}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>{{__('page.amount')}}:</label>
                                <input type="number" name="amount" class="form-control" value="{{$item->amount}}" placeholder="{{__('page.amount')}}">
                                @error('amount')
                                    <span class="form-text text-success">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{__('page.attachment')}}:</label>
                                <input type="file" name="attachment" class="form-input-styled" accept="image/*" data-fouc>
                                <span class="form-text text-muted">{{__('page.accepted_formats_image')}}</span>
                            </div>

                            <div class="form-group">
                                <label>{{__('page.description')}}:</label>
                                <input type="text" name="description" class="form-control" value="{{$item->description}}" placeholder="{{__('page.description')}}">
                            </div>

                            <div class="text-right">
                                <a href="{{route('transaction.index')}}" class="btn btn-secondary">{{__('page.back')}} <i class="icon-undo2 ml-2"></i></a>
                                <button type="submit" class="btn btn-primary">{{__('page.save')}} <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                @elseif ($item->type == 2)
                    <div class="card-body" id="incoming">
                        <form action="{{route('transaction.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <div class="form-group">
                                <label>{{__('page.user')}}:</label>
                                <select data-placeholder="Select user" name="user" class="form-control form-control-select2" data-fouc>
                                    @foreach ($users as $user)
                                        <option value={{$user->id}} @if($item->user_id == $user->id) selected @endif>{{$user->name}}</option>
                                    @endforeach
                                </select>
                                @error('user')
                                    <span class="form-text text-success">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{__('page.category')}}:</label>
                                <select data-placeholder="Select category" name="category" class="form-control form-control-select2" data-fouc>
                                    @foreach ($categories as $category)
                                        <option value={{$category->id}} @if($item->user_id == $user->id) selected @endif>{{$category->name}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <span class="form-text text-success">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{__('page.target_account')}}:</label>
                                <select data-placeholder="Target From" name="account" class="form-control form-control-select2-icons" data-fouc>
                                    @foreach ($accountgroups as $accountgroup)
                                        <optgroup label="{{$accountgroup->name}}">
                                            @foreach ($accountgroup->accounts as $account)
                                                <option value="{{$account->id}}" @if($item->to == $account->id) selected @endif data-icon="wallet">{{$account->name}}</option>                                            
                                            @endforeach
                                        </optgroup>
                                    @endforeach                                
                                </select>
                                @error('account')
                                    <span class="form-text text-success">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{__('page.date')}}:</label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar"></i></span>
                                    </span>
                                    <input type="text" name="timestamp" class="form-control pickadate" value="{{date('Y-m-d', strtotime($item->timestamp))}}" placeholder="{{__('page.date')}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>{{__('page.amount')}}:</label>
                                <input type="number" name="amount" class="form-control" value="{{$item->amount}}" placeholder="{{__('page.amount')}}">
                            </div>

                            <div class="form-group">
                                <label>{{__('page.attachment')}}:</label>
                                <input type="file" name="attachment" class="form-input-styled" accept="image/*" data-fouc>
                                <span class="form-text text-muted">{{__('page.accepted_formats_image')}}</span>
                            </div>

                            <div class="form-group">
                                <label>{{__('page.description')}}:</label>
                                <input type="text" name="description" class="form-control" value="{{$item->description}}" placeholder="{{__('page.description')}}">
                            </div>

                            <div class="text-right">
                                <a href="{{route('transaction.index')}}" class="btn btn-secondary">{{__('page.back')}} <i class="icon-undo2 ml-2"></i></a>
                                <button type="submit" class="btn btn-primary">{{__('page.save')}} <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                @elseif ($item->type == 3)
                    <div class="card-body" id="transfer">                            
                        <form action="{{route('transaction.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <input type="hidden" name="type" value="1">
                            <div class="form-group">
                                <label>{{__('page.user')}}:</label>
                                <select data-placeholder="Select user" name="user" class="form-control form-control-select2" data-fouc>
                                    @foreach ($users as $user)
                                        <option value={{$user->id}} @if($item->user_id == $user->id) selected @endif>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('user')
                                <span class="form-text text-success">{{ $message }}</span>
                            @enderror

                            <div class="form-group">
                                <label>{{__('page.category')}}:</label>
                                <select data-placeholder="Select category" name="category" class="form-control form-control-select2" data-fouc>
                                    @foreach ($categories as $category)
                                        <option value={{$category->id}} @if($item->category_id == $category->id) selected @endif>{{$category->name}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <span class="form-text text-success">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{__('page.withdraw_from')}}:</label>
                                <select data-placeholder="{{__('page.withdraw_from')}}" name="account" class="form-control form-control-select2-icons" data-fouc>
                                    @foreach ($accountgroups as $accountgroup)
                                        <optgroup label="{{$accountgroup->name}}">
                                            @foreach ($accountgroup->accounts as $account)
                                                <option value="{{$account->id}}" @if($item->from == $account->id) selected @endif data-icon="wallet">{{$account->name}}</option>                                            
                                            @endforeach
                                        </optgroup>
                                    @endforeach                                
                                </select>
                                @error('account')
                                    <span class="form-text text-success">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{__('page.target_account')}}:</label>
                                <select data-placeholder="{{__('page.target_account')}}" name="target" class="form-control form-control-select2-icons" data-fouc>
                                    @foreach ($accountgroups as $accountgroup)
                                        <optgroup label="{{$accountgroup->name}}">
                                            @foreach ($accountgroup->accounts as $account)
                                                <option value="{{$account->id}}" @if($item->to == $account->id) selected @endif data-icon="wallet">{{$account->name}}</option>                                            
                                            @endforeach
                                        </optgroup>
                                    @endforeach                                
                                </select>
                                @error('target')
                                    <span class="form-text text-success">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{__('page.date')}}:</label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar"></i></span>
                                    </span>
                                    <input type="text" name="timestamp" class="form-control pickadate" value="{{date('Y-m-d', strtotime($item->timestamp))}}" placeholder="{{__('page.date')}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>{{__('page.amount')}}:</label>
                                <input type="number" name="amount" class="form-control" value="{{$item->amount}}" placeholder="{{__('page.amount')}}">
                                @error('amount')
                                    <span class="form-text text-success">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{__('page.attachment')}}:</label>
                                <input type="file" name="attachment" class="form-input-styled" accept="image/*" data-fouc>
                                <span class="form-text text-muted">{{__('page.accepted_formats_image')}}</span>
                            </div>

                            <div class="form-group">
                                <label>{{__('page.description')}}:</label>
                                <input type="text" name="description" class="form-control" value="{{$item->description}}" placeholder="{{__('page.description')}}">
                            </div>

                            <div class="text-right">
                                <a href="{{route('transaction.index')}}" class="btn btn-secondary">{{__('page.back')}} <i class="icon-undo2 ml-2"></i></a>
                                <button type="submit" class="btn btn-primary">{{__('page.save')}} <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>                
    </div>
@endsection

@section('script')
    <script src="{{asset('master/global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('master/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    	<!-- Theme JS files -->
	<script src="{{asset('master/global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
	<script src="{{asset('master/global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>
	<script src="{{asset('master/global_assets/js/plugins/pickers/anytime.min.js')}}"></script>
	<script src="{{asset('master/global_assets/js/plugins/pickers/pickadate/picker.js')}}"></script>
	<script src="{{asset('master/global_assets/js/plugins/pickers/pickadate/picker.date.js')}}"></script>
	<script src="{{asset('master/global_assets/js/plugins/pickers/pickadate/picker.time.js')}}"></script>
	<script src="{{asset('master/global_assets/js/plugins/pickers/pickadate/legacy.js')}}"></script>
	<script src="{{asset('master/global_assets/js/plugins/notifications/jgrowl.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("input.pickadate").pickadate({
                format: 'yyyy-mm-dd',
                today: false,
                clear: false,
                close: false,
            });
        });
    </script>
    
    <script>
        var FormLayouts = function() {

            var _componentSelect2 = function() {
                if (!$().select2) {
                    console.warn('Warning - select2.min.js is not loaded.');
                    return;
                };

                $('.form-control-select2').select2();

                function iconFormat(icon) {
                    var originalOption = icon.element;
                    if (!icon.id) { return icon.text; }
                    var $icon = "<i class='icon-" + $(icon.element).data('icon') + "'></i>" + icon.text;

                    return $icon;
                }

                $('.form-control-select2-icons').select2({
                    templateResult: iconFormat,
                    minimumResultsForSearch: Infinity,
                    templateSelection: iconFormat,
                    escapeMarkup: function(m) { return m; }
                });
            };

            var _componentUniform = function() {
                if (!$().uniform) {
                    console.warn('Warning - uniform.min.js is not loaded.');
                    return;
                }

                $('.form-input-styled').uniform({
                    fileButtonClass: 'action btn bg-pink-400'
                });
            };

            return {
                init: function() {
                    _componentSelect2();
                    _componentUniform();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function() {
            FormLayouts.init();
        }); 
    </script>
@endsection
