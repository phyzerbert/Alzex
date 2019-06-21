@extends('layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">{{__('page.home')}}</span> - {{__('page.profile')}}</h4>
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
                        <a href="{{url('/')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> {{__('page.home')}}</a>
                        <span class="breadcrumb-item active">{{__('page.profile')}}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content">
			<div class="d-md-flex align-items-md-start">
            <!-- Left sidebar component -->
                <div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-left wmin-300 border-0 shadow-0 sidebar-expand-md">
                    <!-- Sidebar content -->
                    <div class="sidebar-content">    
                        <!-- Navigation -->
                        <div class="card">
                            <div class="card-body bg-indigo-400 text-center card-img-top" style="background-image: url({{asset('master/global_assets/images/backgrounds/panel_bg.png')}}); background-size: contain;">
                                <div class="card-img-actions d-inline-block mb-3">
                                    <img class="img-fluid rounded-circle" src="@if (isset(Auth::user()->picture)){{asset(Auth::user()->picture)}} @else {{asset('images/avatar128.png')}} @endif" width="170" height="170" alt="">
                                    <div class="card-img-actions-overlay rounded-circle">
                                        <a href="user_pages_profile_tabbed.html#" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round">
                                            <i class="icon-plus3"></i>
                                        </a>
                                        <a href="user_pages_profile.html" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
                                            <i class="icon-link"></i>
                                        </a>
                                    </div>
                                </div>

                                <h6 class="font-weight-semibold mb-0">{{Auth::user()->name}}</h6>
                                <span class="d-block opacity-75">{{Auth::user()->role->name}}</span>
                            </div>

                            <div class="card-body p-0">
                                <ul class="nav nav-sidebar mb-2">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link active" data-toggle="tab">
                                            <i class="icon-user"></i>
                                            {{__('page.my_profile')}}
                                        </a>
                                    </li>
                                    <li class="nav-item-divider"></li>
                                    <li class="nav-item">
                                        <a href="{{ route('logout') }}" class="nav-link" data-toggle="tab"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            <i class="icon-switch2"></i>
                                            {{__('page.logout')}}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /navigation -->
                    </div>
                    <!-- /sidebar content -->
                </div>
                <!-- /left sidebar component -->
                <div class="tab-content w-100 overflow-auto">
                    <div class="tab-pane fade active show" id="profile">
                        <div class="card">
                            <div class="card-header header-elements-inline">
                                <h5 class="card-title">{{__('page.profile')}}</h5>
                                <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                        <a class="list-icons-item" data-action="reload"></a>
                                        <a class="list-icons-item" data-action="remove"></a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <form action="{{route('updateuser')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label>{{__('page.username')}}</label>
                                        <input type="text" name="name" value="{{$user->name}}" class="form-control">
                                        @error('name')
                                            <span class="form-text text-success">{{$message}}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>{{__('page.phone_number')}}</label>
                                        <input type="text" name="phone_number" value="{{$user->phone_number}}" class="form-control">
                                        @error('phone_number')
                                            <span class="form-text text-success">{{$message}}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>{{__('page.profile_picture')}}</label>
                                        <input type="file" name="picture" class="form-input-styled" accept="image/*" data-fouc>
                                        <span class="form-text text-muted">{{__('page.accepted_formats_image')}}</span>
                                    </div>

                                    <div class="form-group">
                                        <label>{{__('page.new_password')}}</label>
                                        <input type="password" name="password" placeholder="{{__('page.new_password')}}" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>{{__('page.confirm_password')}}</label>
                                        <input type="password" name="password_conform" placeholder="{{__('page.confirm_password')}}" class="form-control">
                                    </div>

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">{{__('page.save_changes')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
        </div>                
    </div>

@endsection

@section('script')
<script src="{{asset('master/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.form-input-styled').uniform({
            fileButtonClass: 'action btn bg-pink-400'
        });
    });
</script>
@endsection
