
@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class='breadcrumb-item '>File services for {{ $customer->name }}</li>
@endsection
@section('content')
{{--  <div class="clearfix">
    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> File services
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <form method="get" action="{{ route('file_services.index') }}" class="form-inline float-right">
                            {{ csrf_field() }}
                                    <div class="form-group mb-2">
                                        <input type="text" placeholder="Search.." id="search" name="search" class="form-control">
                                
                                    </div>
    
                                    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i></button>
                        
                        </form>
                    </div>
                    
                </div>
                    
                  
        
                <table class="table table-responsive-sm table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Car</th>
                            <th>ECU</th>
                            <th>Timeframe</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($file_services as $file_service)
                        <tr>
                            <td>{{ $file_service->id }}</td>
                            <td>{{ $file_service->make }}  {{ $file_service->model }}  {{ $file_service->engine }}</td>
                            <td>{{ $file_service->ecu }}</td>
                            <td>{{ $file_service->timeframe }}</td>
                            <td>{{ \Carbon\Carbon::parse($file_service->created_at)->diffForHumans() }}</td>
                            <td>
                                <nav class="nav" role="navigation" aria-label="Role options">
                                    <a class="nav-item nav-link" href="{{ URL::to('file_services/' . $file_service->id . '/edit') }}" title="Edit your file service">
                                        <i class="fa fa-edit "></i>
                                    </a>
                                    @if ($file_service->status == 'Completed' || $file_service->status == 'Waiting' || $file_service->status == 'Open')
                                        <a class="nav-item nav-link" href="{{ URL::to('files/' . $file_service->id) }}" title="Download the original file for this file service">
                                            <i class="fa fa-file"></i>
                                        </a>
                                    @endif
                                    @if ($file_service->status == 'Completed')
                                        <a class="nav-item nav-link" href="{{ URL::to('download_modified/' . $file_service->id) }}" title="Download the modified file for this file service">
                                            <i class="fa fa-file"></i>
                                        </a>
                                    @endif


                                    @if (ticketsExist($file_service->id))
                                    <a class="nav-item nav-link" href="{{ URL::to('file_services/' . $file_service->id . '/tickets') }}" title="Open the ticket for this file service">
                                        <i class="fa fa-comment"></i>
                                    </a> 
                                    @else
                                    <a class="nav-item nav-link" href="{{ URL::to('/file_services/' . $file_service->id . '/tickets/create') }}" title="Open a ticket for this file service">
                                        <i class="fa fa-comment"></i>
                                    </a> 
                                    @endif

                                    <a href="#" class="nav-item nav-link"
                                           onclick="event.preventDefault(); document.getElementById('delete-project-form-{{ $file_service->id }}').submit()">
                                           <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="delete-project-form-{{ $file_service->id }}"
                                              action="{{ route('file_services.destroy', $file_service->id) }}"
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    
                                </nav>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                    
                </table>
                <div class="row">
                    <div class="col-12">
                        <div class="float-right" >
                            {{ $file_services->links() }}
                        </div>
                    </div>
                 
                </div>
            </div>
        </div>
    </div>
</div>  --}}

<div class="clearfix">
    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> File services for {{ $customer->name }}                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered data-table " style="width:100%">
                            <thead class="thead-light">
                            <tr id="">
                            <th>Car</th>
                            <th>ECU</th>
                            <th>Timeframe</th>
                            <th>Date</th>
                            <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
{{-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> --}}
{{-- <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.responsive.min.js') }}"></script> --}}

<script type="text/javascript">

    
    $(document).ready(function () {
    
        var table = $('.data-table').DataTable({
        processing: true,
        responsive: true,
        ajax: "{{ url('/customers/'.$id.'/file_services') }}",
        columns: [
            {data: 'make', name: 'make'},
            {data: 'ecu', name: 'ecu'},
            {data: 'timeframe', name: 'timeframe'},
            {data: 'created_at', name: 'created_at'},
            {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
            ],
            "columnDefs": [ 
                {
                    "targets": 4,
                    "data": "Action",
                    "render": function (data, type, full, meta){
                        var link = "<a href="+window.location.origin+'/file_services/'+ full.id+'/edit'+" class='btn btn-info' data-id='full->id' title='Edit your file service'><i class='fa fa-btn fa-edit'></i> </a>";
                        
                        var link3 = "<a href="+window.location.origin+'/files/'+ full.id+" class='btn btn-info' data-id='full->id' title='Download the original file for this file service'><i class='fa fa-btn fa-file'></i> </a>";
                        var link2= '';
                        var link4= '';

                        if(full.file_service_id){
                            link2 = "<a href="+window.location.origin+'/file_services/'+ full.id+'/tickets'+" class='btn btn-info' data-id='full->id' title='View a ticket for this file service'><i class='fa fa-comment'></i> </a>";
                        }else{ 
                            link2 = "<a href="+window.location.origin+'/file_services/'+ full.id+'/tickets/create'+" class='btn btn-info' data-id='full->id' title='Open the ticket for this file service'><i class='fa fa-comment'></i> </a>";
                        }

                        if(full.status == 'Completed'){
                        link4 = "<a href="+window.location.origin+'/download_modified/'+ full.id+" class='btn btn-info' data-id='full->id' title='Download the modified file for this file service'><i class='fa fa-file'></i> </a>";
                        }

                        var link5 = "<meta name='csrf-token' content='$csrf_token'> <a id='delete-file_service' data-id="+full.id + " class='btn btn-danger delete-file_service'><i class='fa fa-trash'></i></a>";

                        return link+' '+link2+' '+link3 +' '+ link4+' '+ link5;
                    },
                },
                {
                    "targets": 0,
                    "data": "make",
                    "render": function (data, type, full, meta){
                        return ""+full.make+' '+full.model+' '+full.engine+"";
                    },
                }]
        });
        
        });

        $('body').on('click', '#delete-file_service', function () {
            var user_id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var x = confirm("Are You sure want to delete !");

            if(x){
                $.ajax({
                    type: "DELETE",
                    url: "/file_services/"+user_id,
                    data: {
                    "id": user_id,
                    "_token": token,
                    },
                    success: function (data) {
                    var table = $('.data-table').DataTable();
            
                    table.ajax.reload();           },
                    error: function (data) {
                    console.log('Error:', data);
                    }
                    });
            }else{
                
            }
            
            
            });
    </script>
@stop