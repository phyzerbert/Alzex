@php
    $page = config('site.page');
@endphp
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">
    <div class="sidebar-mobile-toggler text-center">
        <a href="form_checkboxes_radios.html#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="form_checkboxes_radios.html#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>

    <div class="sidebar-content">
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        <a href="#"><img src="@if (isset(Auth::user()->picture)){{asset(Auth::user()->picture)}} @else {{asset('images/avatar128.png')}} @endif" width="38" height="38" class="rounded-circle" alt=""></a>
                    </div>
                    <div class="media-body">
                        <div class="media-title font-weight-semibold">{{ Auth::user()->name }}</div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-user font-size-sm"></i> &nbsp;{{ Auth::user()->role->name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li class="nav-item"><a href="{{route('home')}}" class="nav-link @if($page == 'home') active @endif"><i class="icon-home4"></i><span>{{__('page.dashboard')}}</span></a></li>
                <li class="nav-item"><a href="{{route('transaction.index')}}" class="nav-link @if($page == 'transaction') active @endif"><i class="icon-cash3"></i><span>{{__('page.transaction')}}</span></a></li>
                <li class="nav-item"><a href="{{route('transaction.daily')}}" class="nav-link @if($page == 'transaction_daily') active @endif"><i class="icon-cash3"></i><span>{{__('page.daily_transaction')}}</span></a></li>
                <li class="nav-item"><a href="{{route('account.index')}}" class="nav-link @if($page == 'account') active @endif"><i class="icon-credit-card"></i><span>{{__('page.account')}}</span></a></li>
                <li class="nav-item"><a href="{{route('category.index')}}" class="nav-link @if($page == 'category') active @endif"><i class="icon-tree7"></i><span>{{__('page.category')}}</span></a></li>
                <li class="nav-item"><a href="{{route('users.index')}}" class="nav-link @if($page == 'user') active @endif"><i class="icon-users2"></i><span>{{__('page.user')}}</span></a></li>
            </ul>
        </div>
    </div>    
</div>