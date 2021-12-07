@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item active'>Dashboard</li>
@endsection

@section('content')

{{--  <div class="row">
    <div class="col-md-4">
        <div class="card" onclick="event.preventDefault(); document.getElementById('open').submit()">
            <div class="card-body">
              <h5 class="card-title">OPEN FILE SERVICE</h5>
              <a  class="card-link">{{ $open }}</a>
              <a href="#" class="card-link float-right"><i class="fa fa-arrow-circle-right"></i></a>
              <form method="get" action="{{ route('file_services.index') }}" class="form-inline float-right" id="open">
                {{ csrf_field() }}
                <input type="hidden" name="status" id="" value="open">
            </form>
            </div>
          </div>
    </div>

    <div class="col-md-4">
        <div class="card" onclick="event.preventDefault(); document.getElementById('waiting').submit()">
            <div class="card-body">
              <h5 class="card-title">WAITING FILE SERVICE</h5>
              <a  class="card-link">{{ $waiting }}</a>
              <a href="#" class="card-link float-right"><i class="fa fa-arrow-circle-right"></i></a>
              <form id="waiting" action="{{ route('file_services.index') }}"
                    method="POST" style="display: none;">
                @csrf
                @method('GET')
                <input type="hidden" name="status" id="" value="waiting">
            </form>
            </div>
          </div>
    </div>

    <div class="col-md-4" >
        <div class="card" onclick="event.preventDefault(); document.getElementById('completed').submit()">
            <div class="card-body">
              <h5 class="card-title">COMPLETED FILE SERVICE</h5>
              <a  class="card-link">{{ $completed }}</a>
              <a href="#" class="card-link float-right"><i class="fa fa-arrow-circle-right"></i></a>
              <form id="completed" action="{{ route('file_services.index') }}"
                    method="POST" style="display: none;">
                @csrf
                @method('GET')
                <input type="hidden" name="status" id="" value="completed">
            </form>
            </div>
          </div>
    </div>
</div>  --}}

{{--  <div class="row">
    <div class="col-md-12">
        <div class="card" onclick="event.preventDefault(); document.getElementById('complete').submit()">
            <div class="card-body">
              <h5 class="card-title">AVAILABLE CREDITS</h5>
              <a  class="card-link">{{ round(currentCredits(),0) }}</a>
              <a href="#" class="card-link float-right"><i class="fa fa-arrow-circle-right"></i></a>
              <form id="complete" action="{{ route('credits') }}"
                    method="POST" style="display: none;">
                @csrf
                @method('GET')
                <input type="hidden" name="status" id="" value="open">
            </form>
            </div>
        </div>
    </div>
</div>  --}}




<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
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
                            <a href="{{ url('tenants') }}" class="text-nowrap font-weight-600">See details</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-gradient-danger border-0">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0 ">Companies</h5>
                                <span class="h2 font-weight-600 mb-0 ">{{ $company->count() }}</span>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-cart-arrow-down"></i>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                            <a href="{{ route('companies.index') }}" class="text-nowrap font-weight-600">See details</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <div class="col-md-12">
    <div class="card bg-gradient-danger border-0">
        <!-- Card body -->
        <div class="card-body">
            <div id="container"></div>
        </div>
    </div>
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
        text: 'Monthly Company Credits'
    },
    xAxis: {
        categories: category,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Credits'
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
        name: 'Credits',
        data: <?php echo json_encode($data) ?>

    }]
});

</script>
@stop