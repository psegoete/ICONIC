<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

    @if (Auth::user()->role == 'super-admin')

    <a class="navbar-brand" href="{{ url('/') }}" style="background-image: url({{ asset('saas/img/ICD_Logo_PNG_1000px.png')}})"></a>
    {{--  <!--<img src="{{ asset('saas/img/ICD_Logo_PNG_1000px.png')}}" alt="" class="navbar-brand" style="    object-fit: cover;">-->  --}}
        {{--  <div class="navbar-brand" style="background-image: url('saas/img/ICD_Logo_PNG_1000px.png');background-size: 55px;" ></div>  --}}
    @else
    {{-- <a class="navbar-brand" href="{{ url('/') }}" style="background-image: url({{  asset('logos/'.comapnyLogo())}})"></a> --}}
    <!--<img src="{{  asset('logos/'.comapnyLogo())}}" alt="" class="navbar-brand" style="    object-fit: cover;">-->
    @if(checkEagleEyePortal())
    <div class="navbar-brand" style="background-image: url({{  asset('logos/'.comapnyLogo())}});background-size: 120px;" ></div>
    @else
    <div class="navbar-brand" style="background-image: url({{  asset('logos/'.comapnyLogo())}});background-size: 120px;background-color: rgb(255 255 255 / 90%);    " ></div>
    @endif
    @endif

    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
            {{--  <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>  --}}
        </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item px-3 d-md-down-none">
            {{--  <a class="nav-link" href="{{ url('/') }}">Main Site</a>  --}}
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button"
               aria-haspopup="true" aria-expanded="false">
                <img src="{{  asset('img/'.auth()->user()->profile_image())}}" class="img-avatar" alt="{{ auth()->user()->name }}">
                {{--  <img data-src= "{{Storage::get(auth()->user()->profile_image) }}" alt="Card image cap">  --}}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                @if(session('impersonate'))
                    <form action="{{ route('users.impersonate.destroy')}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="dropdown-item" type="submit"><i class="fa fa-user"></i> Back to my account</button>
                    </form>
                @endif
                @if(auth()->user()->role == 'super-admin')
                <a class="dropdown-item" href="{{ url('profile') }}">
                    <i class="fa fa-user"></i> Account
                </a>
                @else
                <a class="dropdown-item" href="{{ url('edit-user/'.auth()->user()->id) }}">
                    <i class="fa fa-user"></i> Account
                </a>
                @endif
                <div class="divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i> Logout
                </a>
                @include('layouts.partials.forms._logout')
            </div>
        </li>
    </ul>
    <button class="navbar-toggler aside-menu-toggler" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

</header>
