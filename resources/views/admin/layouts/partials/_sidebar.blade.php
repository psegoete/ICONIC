@section('sidebar')

{{--  Customer dashboard  --}}
@if(auth()->user()->role == 'customer')
    <li class="nav-item nav-dropdown">
        @if (Route::currentRouteName() == 'dashboard' )
            
        <a class="nav-link active" href="{{ route('dashboard') }}">
            <i class="icon-speedometer"></i> Dashboard
        </a>
        @else
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="icon-speedometer"></i> Dashboard
        </a>
        @endif
    </li>
@endif
@if(auth()->user()->role == 'super-admin')
    <li class="nav-item nav-dropdown">
        @if (Route::currentRouteName() == 'super-admin/dashboard' )
            
        <a class="nav-link active" href="{{ url('super-admin/dashboard') }}">
            <i class="icon-speedometer"></i> Dashboard
        </a>
        @else
        <a class="nav-link" href="{{ url('super-admin/dashboard') }}">
            <i class="icon-speedometer"></i> Dashboard
        </a>
        @endif
    </li>
@endif
    @if(auth()->user()->role == 'customer')
    <!-- file service -->
    <li class="nav-item nav-dropdown">
        @if (Route::currentRouteName() == 'file_services.create' )
        <a class="nav-link active" href="{{ route('file_services.create') }}">
            <i class="icon-lock"></i> New file service
        </a>
        @else
        <a class="nav-link" href="{{ route('file_services.create') }}">
            <i class="icon-lock"></i> New file service
        </a>
        @endif
    </li>
    @endif

    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'customer')
    <!-- file service -->
    <li class="nav-item nav-dropdown">
        @if (Route::currentRouteName() == 'file_services.index' )
        <a class="nav-link active" href="{{ route('file_services.index') }}">
            <i class="icon-lock"></i> File services @if(openFileService())<span class="badge badge-danger">{{ openFileService() }}</span>@endif
        </a>
        @else
        <a class="nav-link" href="{{ route('file_services.index') }}">
            <i class="icon-lock"></i> File services @if(openFileService())<span class="badge badge-danger">{{ openFileService() }}</span>@endif
        </a>
        @endif
    </li>
    @endif

    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'customer')
    <!-- Tickets -->
    <li class="nav-item nav-dropdown">

        @if (Route::currentRouteName() == 'tickets.index' || Route::currentRouteName() == 'tickets.create' || 
        Route::currentRouteAction() == 'CreatyDev\Http\TicketsController@customerFileserviceTickets' ||
        Route::currentRouteAction() == 'CreatyDev\Http\TicketsController@fileserviceCreateTicket' ||
        Route::currentRouteAction() == 'CreatyDev\Http\TicketsController@fileserviceTicketCreate')
        <a class="nav-link active" href="{{ route('tickets.index') }}">
            <i class="icon-lock"></i>Tickets @if(openTickets())<span class="badge badge-danger" style="border-radius: 10px;">{{ openTickets() }}</span>@endif
        </a>
        @else
        <a class="nav-link" href="{{ route('tickets.index') }}">
            <i class="icon-lock"></i>Tickets @if(openTickets())<span class="badge badge-danger" style="border-radius: 10px;">{{ openTickets() }}</span>@endif
        </a>
        @endif

    </li>
    @endif

    @if(auth()->user()->role == 'customer')
    <!-- Buy tuning credits -->

    <li class="nav-item">
        <a class="nav-link{{ return_if(on_page('buy-credits'), ' active') }}"
            href="{{ route('buy-credits') }}">
            <i class="fa fa-tags"></i>Buy tuning credits
        </a>
    </li>
    @endif
    
    {{--  Customers  --}}

    @if(auth()->user()->role == 'admin')
    <!-- Permissions -->
    <li class="nav-item nav-dropdown">
        @if (Route::currentRouteName() == 'customers.index' )
        <a class="nav-link active" href="{{ route('customers.index') }}">
            <i class="icon-flag"></i> Customers
        </a>
        @else
        <a class="nav-link" href="{{ route('customers.index') }}">
            <i class="icon-flag"></i> Customers
        </a>
        @endif
    </li>
    @endif

    @if(auth()->user()->role == 'super-admin')
    <!-- Permissions -->
    <li class="nav-item nav-dropdown">
        @if (Route::currentRouteName() == 'customers.tenants' )
        <a class="nav-link active" href="{{ url('tenants') }}">
            <i class="icon-flag"></i> Customers
        </a>
        @else
        <a class="nav-link" href="{{ url('tenants') }}">
            <i class="icon-flag"></i> Customers
        </a>
        @endif
    </li>
    @endif

    @if(auth()->user()->role == 'admin')
    <!-- Permissions -->
    <li class="nav-item nav-dropdown">
        @if (Route::currentRouteName() == 'news.index' || Route::currentRouteName() == 'news.create' || Route::currentRouteName() == 'news.edit' || Route::currentRouteName() == 'news.show')
        <a class="nav-link active" href="{{ route('news.index') }}">
            <i class="icon-flag"></i> Internal news
        </a>
        @else
        <a class="nav-link" href="{{ route('news.index') }}">
            <i class="icon-flag"></i> Internal news
        </a>
        @endif
    </li>
    @endif
    
    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'customer')
    <!-- Orders -->
    <li class="nav-item nav-dropdown">

        @if (Route::currentRouteName() == 'orders.index' || Route::currentRouteName() == 'orders.create' || Route::currentRouteName() == 'orders.edit')
        <a class="nav-link active" href="{{ route('orders.index') }}">
            <i class="fa fa-cart-arrow-down"></i> Orders
        </a>
        @else
        <a class="nav-link" href="{{ route('orders.index') }}">
            <i class="fa fa-cart-arrow-down"></i> Orders
        </a>
        @endif
    </li>
    @endif
    {{--  @if(auth()->user()->role == 'admin')
    <!-- Orders -->
    <li class="nav-item nav-dropdown">

        @if (Route::currentRouteName() == 'mail' || Route::currentRouteName() == 'mailEdit')
        <a class="nav-link active" href="{{ url('mail-templates') }}">
            <i class="fa fa-envelope"></i> Mail templates
        </a>
        @else
        <a class="nav-link" href="{{ url('mail-templates') }}">
            <i class="fa fa-envelope"></i> Mail templates
        </a>
        @endif
    </li>
    @endif  --}}

    @if(auth()->user()->role == 'admin')
    <!-- tuning credits -->
    @if (Route::currentRouteName() == 'mail' || Route::currentRouteName() == 'mailEdit' || Route::currentRouteName() == 'sent-mails.index')
    <li class="nav-item nav-dropdown open">
    @else
    <li class="nav-item nav-dropdown ">
    @endif
        <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="fa fa-tags"></i> Mail
        </a>
        <ul class="nav-dropdown-items">
            @if (Route::currentRouteName() == 'mail' || Route::currentRouteName() == 'mailEdit')
            <li class="nav-item">
                <a class="nav-link active"
                    href="{{ url('mail-templates') }}">
                    <i class="fa fa-envelope"></i>Mail templates 
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link"
                    href="{{ url('mail-templates') }}">
                    <i class="fa fa-envelope"></i>Mail templates
                </a>
            </li>
            @endif

            @if (Route::currentRouteName() == 'sent-mails.index')
            <li class="nav-item">
                <a class="nav-link active"
                    href="{{ url('sent-mails') }}">
                    <i class="fa fa-envelope-open"></i>Sent mails
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link"
                    href="{{ url('sent-mails') }}"> 
                    <i class="fa fa-envelope-open"></i>Sent mails
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if(auth()->user()->role == 'customer')
    <!-- Transactions -->
    <li class="nav-item nav-dropdown">

        @if (Route::currentRouteName() == 'transactions.index' || Route::currentRouteName() == 'transactions.create' || Route::currentRouteName() == 'transactions.edit')
        <a class="nav-link active" href="{{ route('transactions.index') }}">
            <i class="fa fa-money"></i> Transactions
        </a>
        @else
        <a class="nav-link" href="{{ route('transactions.index') }}">
            <i class="fa fa-money"></i> Transactions
        </a>
        @endif
    </li>
    @endif

    @if(auth()->user()->role == 'admin')
    <!-- Invoices -->
    <li class="nav-item nav-dropdown">
        @if (Route::currentRouteName() == 'invoices.index' || Route::currentRouteName() == 'invoices.create' || Route::currentRouteName() == 'invoices.edit')
        <a class="nav-link active" href="{{ route('invoices.index') }}">
            <i class="icon-flag"></i> Invoices
        </a>
        @else
        <a class="nav-link" href="{{ route('invoices.index') }}">
            <i class="icon-flag"></i> Invoices
        </a>
        @endif
    </li>
    @endif

    @if(auth()->user()->role == 'admin' && currentCredits() != 'Ultimate plan')
    <!-- Invoices -->
    <li class="nav-item nav-dropdown">
        @if (Route::currentRouteName() == 'credits')
        <a class="nav-link active" href="{{ route('credits') }}">
            <i class="icon-flag"></i> Buy sharing credits
        </a>
        @else
        <a class="nav-link" href="{{ route('credits') }}">
            <i class="icon-flag"></i> Buy sharing credits
        </a>
        @endif
    </li>
    @endif

    {{--  @if(auth()->user()->role == 'admin')
    <!-- Sharing credits -->
        @if(companyPlan() != 'enterprice')
        <li class="nav-item nav-dropdown">
            @if (Route::currentRouteName() == 'file-sharing.index')
            <a class="nav-link active" href="{{ route('file-sharing.index') }}">
                <i class="icon-flag"></i> Sharing credits {{ companyPlan() }}
            </a>
            @else
            <a class="nav-link" href="{{ route('file-sharing.index') }}">
                <i class="icon-flag"></i> Sharing credits
            </a><div class=""></div>
            @endif
        </li>
        @endif
    @endif  --}}

    @if(auth()->user()->role == 'admin')
    <!-- Subscription -->
    <li class="nav-item nav-dropdown">
        @if (Route::currentRouteName() == 'subscriptions.index')
        <a class="nav-link active" href="{{ route('subscriptions.index') }}">
            <i class="icon-flag"></i> Subscription
        </a>
        @else
        <a class="nav-link" href="{{ route('subscriptions.index') }}">
            <i class="icon-flag"></i> Subscription
        </a>
        @endif
    </li>
    @endif

    @if(auth()->user()->role == 'admin')
    <!-- tuning credits -->
    @if (Route::currentRouteName() == 'tuning-credits.edit' || Route::currentRouteName() == 'tuning-credits.index' ||
    Route::currentRouteName() == 'tuning-credits.create' )
    <li class="nav-item nav-dropdown open">
    @else
    <li class="nav-item nav-dropdown ">
    @endif
        <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="fa fa-tags"></i> Credit prices
        </a>
        <ul class="nav-dropdown-items">
            @if (Route::currentRouteName() == 'tuning-credits.edit' || Route::currentRouteName() == 'tuning-credits.index' 
            || Route::currentRouteName() == 'tuning-credits.create')
            <li class="nav-item">
                <a class="nav-link active"
                    href="{{ route('tuning-credits.index') }}">
                    <i class="fa fa-file"></i>Tuning credit prices
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link"
                    href="{{ route('tuning-credits.index') }}">
                    <i class="fa fa-file"></i>Tuning credit prices
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if(auth()->user()->role == 'super-admin')
    <!-- company credits -->
    @if (Route::currentRouteName() == 'company-credits.edit' || Route::currentRouteName() == 'company-credits.index' ||
    Route::currentRouteName() == 'company-credits.create' )
    <li class="nav-item nav-dropdown open">
    @else
    <li class="nav-item nav-dropdown ">
    @endif
        <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="fa fa-tags"></i> Credit prices
        </a>
        <ul class="nav-dropdown-items">
            @if (Route::currentRouteName() == 'company-credits.edit' || Route::currentRouteName() == 'company-credits.index' 
            || Route::currentRouteName() == 'company-credits.create')
            <li class="nav-item">
                <a class="nav-link active"
                    href="{{ route('company-credits.index') }}">
                    <i class="fa fa-file"></i>company credits
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link"
                    href="{{ route('company-credits.index') }}">
                    <i class="fa fa-file"></i>company credits
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if(auth()->user()->role == 'super-admin')
    <!-- Payments -->
    <li class="nav-item nav-dropdown">
        @if (Route::currentRouteName() == 'admin-payments.index' || Route::currentRouteName() == 'admin-payments.create' || Route::currentRouteName() == 'admin-payments.edit')
        <a class="nav-link active" href="{{ url('admin-payments') }}">
            <i class="icon-flag"></i> Payments
        </a>
        @else
        <a class="nav-link" href="{{ url('admin-payments') }}">
            <i class="icon-flag"></i> Payments
        </a>
        @endif
    </li>
    @endif
    


    @if(auth()->user()->role == 'admin')
    @if (Route::currentRouteName() == 'tuning_types.edit' || Route::currentRouteName() == 'tuning_types.index' ||
    Route::currentRouteName() == 'tuning_types.create'  || Route::currentRouteName() == 'companyInfo' || 
    Route::currentRouteName() == 'readmethods.edit' || Route::currentRouteName() == 'readmethods.index' || 
    Route::currentRouteName() == 'readmethods.create' || Route::currentRouteName() == 'gearboxes.edit' ||
     Route::currentRouteName() == 'gearboxes.index' || Route::currentRouteName() == 'gearboxes.create' ||
     Route::currentRouteName() == 'payments.edit' || Route::currentRouteName() == 'payments.index' || 
     Route::currentRouteName() == 'payments.create' || Route::currentRouteName() == 'tuning_types.tuning_options.edit' || 
     Route::currentRouteName() == 'tuning_types.tuning_options.index' || Route::currentRouteName() == 'tuning_types.tuning_options.create'
     || Route::currentRouteName() == 'deliveryTime')
    <li class="nav-item nav-dropdown open">
    @else
    <li class="nav-item nav-dropdown ">
    @endif
        <a class="nav-link nav-dropdown-toggle">
            <i class="fa fa-cog"></i> Settings
        </a>
        <ul class="nav-dropdown-items" style="padding-left: 10px">
            @if (Route::currentRouteName() == 'companyInfo' )
            <li class="nav-item">
                <a class="nav-link active"
                    href="{{ route('companyInfo') }}">
                    <i class="fa fa-cog"></i>Company Configuration
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link"
                    href="{{ route('companyInfo') }}">
                    <i class="fa fa-cog"></i>Company Configuration
                </a>
            </li>
            @endif

            @if (Route::currentRouteName() == 'deliveryTime' )
            <li class="nav-item">
                <a class="nav-link active"
                    href="{{ url('delivery-times') }}">
                    <i class="fa fa-cog"></i>Delivery times
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link"
                    href="{{ url('delivery-times') }}">
                    <i class="fa fa-cog"></i>Delivery times
                </a>
            </li>
            @endif

            {{--  Tuning types  --}}
            @if (Route::currentRouteName() == 'tuning_types.edit' || Route::currentRouteName() == 'tuning_types.index' 
            || Route::currentRouteName() == 'tuning_types.create' || Route::currentRouteName() == 'tuning_types.tuning_options.edit' || 
            Route::currentRouteName() == 'tuning_types.tuning_options.index' || Route::currentRouteName() == 'tuning_types.tuning_options.create')
            <li class="nav-item">
                <a class="nav-link active"
                    href="{{ route('tuning_types.index') }}">
                    <i class="fa fa-file"></i>Tuning types
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link"
                    href="{{ route('tuning_types.index') }}">
                    <i class="fa fa-file"></i>Tuning types
                </a>
            </li>
            @endif

            {{--  Read methods  --}}
            @if (Route::currentRouteName() == 'readmethods.edit' || Route::currentRouteName() == 'readmethods.index' 
            || Route::currentRouteName() == 'readmethods.create')
            <li class="nav-item">
                <a class="nav-link active"
                    href="{{ route('readmethods.index') }}">
                    <i class="fa fa-file"></i>Read methods
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link"
                    href="{{ route('readmethods.index') }}">
                    <i class="fa fa-file"></i>Read methods
                </a>
            </li>
            @endif

            {{--  Gearboxes  --}}
            @if (Route::currentRouteName() == 'gearboxes.edit' || Route::currentRouteName() == 'gearboxes.index' 
            || Route::currentRouteName() == 'gearboxes.create')
            <li class="nav-item">
                <a class="nav-link active"
                    href="{{ route('gearboxes.index') }}">
                    <i class="fa fa-file"></i>Gearboxes
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link"
                    href="{{ route('gearboxes.index') }}">
                    <i class="fa fa-file"></i>Gearboxes
                </a>
            </li>
            @endif

             {{--  Payment getaway  --}}
             @if (Route::currentRouteName() == 'payments.edit' || Route::currentRouteName() == 'payments.index' 
             || Route::currentRouteName() == 'payments.create')
             <li class="nav-item">
                 <a class="nav-link active"
                     href="{{ route('payments.index') }}">
                     <i class="fa fa-file"></i>Payment getaway
                 </a>
             </li>
             @else
             <li class="nav-item">
                 <a class="nav-link"
                     href="{{ route('payments.index') }}">
                     <i class="fa fa-file"></i>Payment getaway
                 </a>
             </li>
             @endif
        </ul>
    </li>
    @endif

    @if(auth()->user()->role == 'super-admin')
    <!-- Companies -->
    <li class="nav-item nav-dropdown">
        @if (Route::currentRouteName() == 'companies.index' ||  Route::currentRouteName() == 'companies.edit')
        <a class="nav-link active" href="{{ route('companies.index') }}">
            <i class="icon-flag"></i> Companies
        </a>
        @else
        <a class="nav-link" href="{{ route('companies.index') }}">
            <i class="icon-flag"></i> Companies
        </a>
        @endif
    </li>
    @endif

    <!-- Help -->
    {{-- <li class="nav-item nav-dropdown">
        @if (Route::currentRouteName() == 'videoPlayer')
        <a class="nav-link active" href="{{ url('video') }}">
            <i class="fa fa-question-circle"></i> Help
        </a>
        @else
        <a class="nav-link" href="{{ url('video') }}">
            <i class="fa fa-question-circle"></i> Help
        </a>
        @endif
    </li> --}}

    
    {{--  <!-- Plans -->
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="fa fa-tags"></i> Manage Plans
        </a>
        <ul class="nav-dropdown-items">
            <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('admin.plans.index'), ' active') }}"
                    href="{{ route('admin.plans.index') }}">
                    <i class="fa fa-tags"></i>All Plan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('admin.plans.create'), ' active') }}"
                    href="{{ route('admin.plans.create') }}">
                    <i class="icon-plus"></i> Add Plan
                </a>
            </li>
        </ul>
    </li>
    <!-- Coupons -->
    <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="fa fa-tags"></i> Manage Coupons
            </a>
            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link{{ return_if(on_page('admin.coupons.index'), ' active') }}"
                        href="{{ route('admin.coupons.index') }}">
                        <i class="fa fa-tags"></i>All Coupons
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ return_if(on_page('admin.coupons.create'), ' active') }}"
                        href="{{ route('admin.coupons.create') }}">
                        <i class="icon-plus"></i> Add Coupon
                    </a>
                </li>
            </ul>
        </li>
        <!-- Soupscriptions -->
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="fa fa-credit-card"></i> Subscription
        </a>
        <ul class="nav-dropdown-items">
            <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('admin.subscriptions.index'), ' active') }}"
                    href="{{ route('admin.subscriptions.index') }}">
                    <i class="fa fa-tags"></i>All subscription
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="fa fa-envelope"></i> Notification
        </a>
        <ul class="nav-dropdown-items">
            <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('admin.subscriptions.index'), ' active') }}"
                    href="{{ route('admin.annoucement.create') }}">
                    <i class="fa fa-comment"></i>Send Notification
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="fa fa-gear"></i> Statistics
        </a>
        <ul class="nav-dropdown-items">
            <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('admin.env.index'), ' active') }}"
                    href="{{ route('admin.visitlog') }}">
                    <i class="fa fa-gear"></i>Visitor log
                </a>
            </li>
        </ul>
    </li>
    //Disable this menu cause the Env editor package not yet compatible to Laravel 6
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="fa fa-gear"></i> Settings
        </a>
        <ul class="nav-dropdown-items">
            <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('admin.env.index'), ' active') }}"
                    href="{{ route('admin.env.index') }}">
                    <i class="fa fa-gear"></i>Env setting
                </a>
            </li>
        </ul>
    </li>  --}}
@endsection