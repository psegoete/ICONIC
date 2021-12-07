@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item active'>Dashboard</li>
@endsection

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="company border-bottom">

          <h5 class="card-title text-uppercase" align="center">{{ $company->company_name }} INFORMATION @if($status == 'OPEN')<span style="color: green">({{ $status }})</span>@else <span style="color: red">({{ $status }})</span> @endif</h5>
        </div>

        <div class="row">
          <div class="col-md-6">
            <h5>Contact</h5>
            <div class="row">
              <div class="col-4" >
                Address 1
              </div>
              <div class="col-8" align='left'>
                {{ $company->address1 }}
              </div>
            </div>
            <div class="row">
              <div class="col-4" >
                Address 2
              </div>
              <div class="col-8" align='left'>
                {{ $company->address2 }}
              </div>
            </div>
            <div class="row">
              <div class="col-4" >
                City
              </div>
              <div class="col-8" align='left'>
                {{ $company->city }}
              </div>
            </div>
            <div class="row">
              <div class="col-4" >
                Province/State
              </div>
              <div class="col-8" align='left'>
                {{ $company->province }}
              </div>
            </div>
            <div class="row">
              <div class="col-4" >
                Company email
              </div>
              <div class="col-8" align='left'>
                <a href="mailto:{{ $company->company_email }}">{{ $company->company_email }}</a>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <h5>Note to customer</h5>
            <p>{!! $PlatformSetting->notes_to_customers !!}</p>
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
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <strong>Working hours @if($status == 'OPEN')<span style="color: green">({{ $status }})</span>@else <span style="color: red">({{ $status }})</span> @endif</strong> 
      </div>
      <div class="card-body">
        <table class="table table-borderless">
          <thead>
            <tr>
              @if ( $Availability->monday_status)
              <th>{{ $Availability->monday }}</th>
              <th>		<em>closed</em></th>
              @else
              <th>{{ $Availability->monday }}</th>
              <th>	{{ \Carbon\Carbon::parse($Availability->monday_opening_time)->format('H:i')}} -  {{ \Carbon\Carbon::parse($Availability->monday_closing_time)->format('H:i')}}</th>
              @endif
            </tr>
          </thead>
          <thead>
            <tr>
              @if ( $Availability->tuesday_status)
              <th>{{ $Availability->tuesday }}</th>
              <th>		<em>closed</em></th>
              @else
              <th>{{ $Availability->tuesday }}</th>
              <th>	{{ \Carbon\Carbon::parse($Availability->tuesday_opening_time)->format('H:i')}} -  {{ \Carbon\Carbon::parse($Availability->tuesday_closing_time)->format('H:i')}}</th>
              @endif
            </tr>
          </thead>
          <thead>
            <tr>
              @if ( $Availability->wednesday_status)
              <th>{{ $Availability->wednesday }}</th>
              <th>		<em>closed</em></th>
              @else
              <th>{{ $Availability->wednesday }}</th>
              <th>	{{ \Carbon\Carbon::parse($Availability->wednesday_opening_time)->format('H:i')}} -  {{ \Carbon\Carbon::parse($Availability->wednesday_closing_time)->format('H:i')}}</th>
              @endif
            </tr>
          </thead>
          <thead>
            <tr>
              @if ( $Availability->thursday_status)
              <th>{{ $Availability->thursday }}</th>
              <th>		<em>closed</em></th>
              @else
              <th>{{ $Availability->thursday }}</th>
              <th>	{{ \Carbon\Carbon::parse($Availability->thursday_opening_time)->format('H:i')}} -  {{ \Carbon\Carbon::parse($Availability->thursday_closing_time)->format('H:i')}}</th>
              @endif
            </tr>
          </thead>
          <thead>
            <tr>
              @if ( $Availability->friday_status)
              <th>{{ $Availability->friday }}</th>
              <th>		<em>closed</em></th>
              @else
              <th>{{ $Availability->friday }}</th>
              <th>	{{ \Carbon\Carbon::parse($Availability->friday_opening_time)->format('H:i')}} -  {{ \Carbon\Carbon::parse($Availability->friday_closing_time)->format('H:i')}}</th>
              @endif
            </tr>
          </thead>
          <thead>
            <tr>
              @if ( $Availability->saturday_status)
              <th>{{ $Availability->saturday }}</th>
              <th>		<em>closed</em></th>
              @else
              <th>{{ $Availability->saturday }}</th>
              <th>	{{ \Carbon\Carbon::parse($Availability->saturday_opening_time)->format('H:i')}} -  {{ \Carbon\Carbon::parse($Availability->saturday_closing_time)->format('H:i')}}</th>
              @endif
            </tr>
          </thead>
          <thead>
            <tr>
              @if ( $Availability->sunday_status)
              <th>{{ $Availability->sunday }}</th>
              <th>		<em>closed</em></th>
              @else
              <th>{{ $Availability->sunday }}</th>
              <th>	{{ \Carbon\Carbon::parse($Availability->sunday_opening_time)->format('H:i')}} -  {{ \Carbon\Carbon::parse($Availability->sunday_closing_time)->format('H:i')}}</th>
              @endif
            </tr>
          </thead>
          </table>
          
       </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <strong>Latest news</strong> 
      </div>
      <div class="card-body">
        <table class="table table-striped">
          <thead>
              <tr>
                  <th width="100">Date</th>
                  <th>Title</th> 
                  <th width="1">&nbsp;</th>
              </tr>
          </thead>
          <tbody>
            @foreach($news as $new)
            <tr>
              <td>{{ \Carbon\Carbon::parse($new->display_date)->format('yy-m-d')}}</td>
              <td style="white-space: normal;">{{ $new->title }}</td>
              <td >
                <a href="{{ URL::to('news/' . $new->id) }}" title="Read this article" class="">
                  <i class="fa fa-btn fa-search"></i>
                </a>
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
    <div class="card">
        <div class="card-body">
          <div class="row ">
            <div class="col-3" align="center">
              <a href="{{ $company->facebook }}" >
                <i class="fa fa-btn fa-facebook"></i></a>
            </div>
            <div class="col-3" align="center">
              <a href="{{ $company->instagram }}" >
                <i class="fa fa-btn fa-instagram"></i></a>
            </div>
            <div class="col-3" align="center">
              <a href="skype:{{ $company->skype_username }}?chat" >
                <i class="fa fa-btn fa-skype"></i></a>
            </div>
            <div class="col-3" align="center">
              <a href="{{ $company->youtube }}" >
                <i class="fa fa-btn fa-youtube"></i></a>
            </div>
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
