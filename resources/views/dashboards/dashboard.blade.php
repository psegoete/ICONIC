@extends('admin.layouts.default')

@section('admin.breadcrumb')

@endsection

@section('admin.content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-gradient-danger border-0">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0 ">Customers</h5>
                                <span class="h2 font-weight-600 mb-0 ">{{ $total_customers }}</span>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                            <a href="{{ route('customers.index') }}" class="text-nowrap font-weight-600">See details</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-gradient-danger border-0">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0 ">Open file services</h5>
                                <span class="h2 font-weight-600 mb-0 ">{{ $open }}</span>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-file"></i>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                            <a href="{{ route('file_services.index') }}" class="text-nowrap font-weight-600">See details</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-gradient-danger border-0">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0 ">Waiting file services</h5>
                                <span class="h2 font-weight-600 mb-0 ">{{ $waiting }}</span>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-file"></i>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                            <a href="{{ route('file_services.index') }}" class="text-nowrap font-weight-600">See details</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <div class="col-md-8">
    <div class="card bg-gradient-danger border-0">
        <!-- Card body -->
        <div class="card-body">
            <div id="container"></div>
        </div>
    </div>
 </div>
 <div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <strong>Export report</strong> 
            <span class="center"> </span>
        </div>
        {{--  <div class="container">  --}}

            <div class="card-body">
                <form method="POST" action="{{ route('export') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('start') ? ' has-error' : '' }} ">
                        <label class="col-form-label" for="start">Start</label>
                            <input type="date" id="start" name="start" class="form-control{{ $errors->has('start') ? ' is-invalid' : '' }} " required
                                value="{{ old('start') }}">
    
                                @if ($errors->has('start'))
                                    <span class="text-danger">{{ $errors->first('start') }}</span>
                                @endif
                    </div>

                    <div class="form-group{{ $errors->has('end') ? ' has-error' : '' }} ">
                        <label class="col-form-label" for="end">End</label>
                            <input type="date" id="end" name="end" class="form-control{{ $errors->has('credits') ? ' is-invalid' : '' }} "
                                required
                                value="{{ old('credits') }}">
    
                                @if ($errors->has('credits'))
                                    <span class="text-danger">{{ $errors->first('credits') }}</span>
                                @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">
                            Export
                        </button>
                    </div>
                </form>
            </div>
    </div>
</div>

</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Pending support tickets
                <a href="{{ URL::to('tickets')  }}" class="float-right"> View all support tickets</a>
                
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Category</th>
                            <th>Subject</th>
                            <th>Customer</th>
                            <th>Last update</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                        <tr>
                            <td>{{ CreatyDev\Domain\Ticket\Models\Category::where('id', $ticket->category_id)->firstOrFail()->name }}</td>
                            <td>{{ $ticket->subject }}</td>
                            <td>{{ CreatyDev\Domain\Users\Models\User::where('id', $ticket->user_id)->firstOrFail()->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($ticket->updated_at)->diffForHumans() }}</td>
                            <td>
                                @if($ticket->file_service_id)
                                <nav class="nav" role="navigation" aria-label="Role options">
                                    <a href="{{ URL::to('file_services/'  . $ticket->file_service_id . '/tickets') }}"class="nav-item nav-link"  title="View ticket" class=""> <i class="fa fa-comment "></i></a>
                                </nav>
                                @else
                                <nav class="nav" role="navigation" aria-label="Role options">
                                    <a href="{{ URL::to('tickets/'  . $ticket->ticket_id) }}"class="nav-item nav-link"  title="View ticket" class=""> <i class="fa fa-comment "></i></a>
                                </nav>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Recent orders
                <a href="{{ URL::to('orders')  }}" class="float-right"> View all orders</a>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Order no.</th>
                            <th>Date</th>
                            <th>Customer</th> 
                            <th>Amount</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_no }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ CreatyDev\Domain\Users\Models\User::where('id', $order->user_id)->firstOrFail()->name }}</td>
                            <td>{{ $order->amount }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                <nav class="nav" role="navigation" aria-label="Role options">
                                    <a href="{{ URL::to('orders/' . $order->id . '/edit') }}" title="Edit order" class="nav-item nav-link"><i class="fa fa-edit "></i></a> 
                                </nav>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                    
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="container"></div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
{{-- <script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script> --}}
<script type="text/javascript">
    var category =  <?php echo json_encode($category) ?>;
    var data =  <?php echo json_encode($data) ?>;
  Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly Completed File Services'
    },
    xAxis: {
        categories: category,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Number of File Services'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    credits: {
      enabled: false
    },
    series: [{
        name: 'File services',
        data: <?php echo json_encode($data) ?>

    }]
});

</script>
@stop