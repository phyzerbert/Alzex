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

        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li class="nav-item"><a href="/" class="nav-link @if($page == 'home') active @endif"><i class="icon-home4"></i><span>Dashboard</span></a></li>
                <li class="nav-item"><a href="/" class="nav-link @if($page == 'transaction') active @endif"><i class="icon-cash3"></i><span>Transaction</span></a></li>
                <li class="nav-item"><a href="/" class="nav-link @if($page == 'account') active @endif"><i class="icon-credit-card"></i><span>Account</span></a></li>
                <li class="nav-item"><a href="/" class="nav-link @if($page == 'category') active @endif"><i class="icon-tree7"></i><span>Category</span></a></li>
                <li class="nav-item"><a href="{{route('users.index')}}" class="nav-link @if($page == 'user') active @endif"><i class="icon-users2"></i><span>User</span></a></li>
                {{-- <li class="nav-item nav-item-submenu">
                    <a href="form_checkboxes_radios.html#" class="nav-link"><i class="icon-copy"></i> <span>Layouts</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        <li class="nav-item"><a href="index.html" class="nav-link active">Default layout</a></li>
                        <li class="nav-item"><a href="../../../../layout_2/LTR/default/full/index.html" class="nav-link">Layout 2</a></li>
                        <li class="nav-item"><a href="../../../../layout_3/LTR/default/full/index.html" class="nav-link">Layout 3</a></li>
                        <li class="nav-item"><a href="../../../../layout_4/LTR/default/full/index.html" class="nav-link">Layout 4</a></li>
                        <li class="nav-item"><a href="../../../../layout_5/LTR/default/full/index.html" class="nav-link">Layout 5</a></li>
                        <li class="nav-item"><a href="http://demo.interface.club/limitless/demo/bs4/Template/layout_6/LTR/default/full/index.html" class="nav-link disabled">Layout 6 <span class="badge bg-transparent align-self-center ml-auto">Coming soon</span></a></li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </div>    
</div>