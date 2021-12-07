<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            @if(auth()->user()->role == 'admin')


            <li class="nav-item">

                @if (Route::currentRouteName() == 'admin/dashboard' )
                    <a class="nav-link active"
                    href="{{ route('admin/dashboard') }}">
                    <i class="icon-speedometer"></i> Dashboard
                    </a>
                    @else
                    <a class="nav-link"
                    href="{{ route('admin/dashboard') }}">
                        <i class="icon-speedometer"></i> Dashboard
                    </a>
                    @endif
                
            </li>
            @endif
            @yield('sidebar')
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>

