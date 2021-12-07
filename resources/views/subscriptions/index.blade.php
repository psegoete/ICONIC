@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Subscription</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="clearfix">
            <div class="card">
                <div class="card-header">
                    <strong>Subscription</strong> 
                    <span class="center"> </span>
                </div>
                <div>@include('layouts.partials.alerts._alerts')</div>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <div class="card-body">
                        <form action="{{ route('subscriptions.store') }}" method="POST">
                            {!! csrf_field() !!}
                            @if($status == 'true')
                            <div class="form-group">
                                You are currently subscribed. The current billing cycle will end {{ Carbon\Carbon::parse($subscription[0]->ends_at)->format('d M Y') }}. The next billing date is {{ Carbon\Carbon::parse($subscription[0]->ends_at)->addDays(1)->format('d M Y') }} for R {{ $subscription[0]->subscription_ammount }}.
                            </div>
                            @else
                            <div class="form-group">
                                You are currently not subscribed.
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    Subscribe
                                </button>
                            </div>
                            @endif
                    </form>
                    </p>
                </div>
                {{-- <div class="card-footer">
                    <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
                </div> --}}
                
            </div>
        </div>
    </div>
</div>
@endsection
