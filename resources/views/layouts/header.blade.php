<div class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-brand">
        <a href="{{route('home')}}" class="d-inline-block">
            <img src="{{asset('master/global_assets/images/logo_light.png')}}" alt="">
        </a>
    </div>

    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav" style="margin-left:-68px;">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>
        </ul>

        <span class="badge bg-success ml-md-3 mr-md-auto">{{__('page.online')}}</span>

        <ul class="navbar-nav">
            <li class="nav-item dropdown dropdown-user">
                @php $locale = session()->get('locale'); @endphp
                <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" style="margin-top:8px;" data-toggle="dropdown">                    
                    @switch($locale)
                        @case('en')
                            <img src="{{asset('images/lang/en.png')}}" width="30px">&nbsp;&nbsp;English
                            @break
                        @case('es')
                            <img src="{{asset('images/lang/es.png')}}" width="30px">&nbsp;&nbsp;Spanish
                            @break
                        @default
                            <img src="{{asset('images/lang/en.png')}}" width="30px">&nbsp;&nbsp;English
                    @endswitch
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{route('lang', 'en')}}"><img src="{{asset('images/lang/en.png')}}" width="30" height="30"> English</a>
                    <a class="dropdown-item" href="{{route('lang', 'es')}}"><img src="{{asset('images/lang/es.png')}}" width="30" height="30"> Spanish</a>
                </div>
            </li>

            <li class="nav-item dropdown dropdown-user">
                <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                    <img src="@if (isset(Auth::user()->picture)){{asset(Auth::user()->picture)}} @else {{asset('images/avatar128.png')}} @endif" class="rounded-circle mr-2" height="34" alt="">
                    <span>{{Auth::user()->name}}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{route('profile')}}" class="dropdown-item"><i class="icon-user-plus"></i> {{__('page.my_profile')}}</a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" class="dropdown-item">
                    <i class="icon-switch2"></i> {{__('page.logout')}}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>