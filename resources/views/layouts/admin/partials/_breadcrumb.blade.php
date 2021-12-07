<!-- Breadcrumb -->
<ol class="breadcrumb">
    @if (auth()->user()->role == 'customer')
    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i></a></li>
    @endif
    @if (auth()->user()->role == 'admin')
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i></a></li>
    @endif
    {{--  <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Admin</a>
    </li>  --}}
    @yield('breadcrumb')

    <!-- Breadcrumb Menu-->
    <li class="breadcrumb-menu d-md-down-none">
        <div class="btn-group" role="group" aria-label="Button group">
            @if(auth()->user()->role == 'customer')
                <a class="btn" href="{{ route('buy-credits') }}">
                    <i class="fa fa-database"></i> &nbsp;Tuning credits {{ currentCredits() }}
                    <i class="fa fa-angle-right"></i>
                </a>
            @endif
            
            @if(auth()->user()->role == 'admin')
                @if(currentCredits() == 'Ultimate plan') 
                    {{ currentCredits() }}
                @else
                    <a class="btn" href="{{ route('credits') }}">
                        <i class="fa fa-database"></i>Tuning credits {{ currentCredits() }}
                        
                        <i class="fa fa-angle-right"></i> 
                        
                    </a>
                @endif   
            @endif
            @yield('breadcrumb-menu')
        </div>
    </li>
</ol>
