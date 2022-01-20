{{--  @extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class='breadcrumb-item '>File services</li>
@endsection
@section('content')

<div class="clearfix">
    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> File services
                <a href="{{ route('file_services.create') }}" class="float-right"><i class="fa fa-plus-square"></i> New file service</a>
                
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <form method="get" action="{{ route('file_services.index') }}" class="form-inline float-right">
                            {{ csrf_field() }}
                                    <div class="form-group mb-2">
                                        <input type="text" placeholder="Search.." name="search" class="form-control">
                                
                                    </div>
    
                                    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i></button>
                        
                        </form>
                    </div>
                    
                </div>
                    
                  
        
                <table class="table table-responsive-sm table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Car</th>
                            <th>VIN</th>
                            <th>Created</th>
                            <th>Status</th>
                            <th>Dynograph</th>
                            <th>Modified</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($file_services as $file_service)
                        <tr>
                            <td>{{ $file_service->id }}</td>
                            <td>{{ $file_service->make }}  {{ $file_service->model }}  {{ $file_service->engine }}</td>
                            <td>{{ $file_service->vin }}</td>
                            <td>{{ \Carbon\Carbon::parse($file_service->created_at)->diffForHumans() }}</td>
                            <td>{{ $file_service->status }}</td>
                            <td>
                                @if ($file_service->dynograph)
                                    <a class="nav-item nav-link" href="{{ URL::to('download_dynograph/' . $file_service->id) }}" title="Download the original file for this file service">Add dynograph
                                @endif
                            </a></td>
                            <td>
                                @if ($file_service->modified)
                                    <a class="nav-item nav-link" href="{{ URL::to('download_modified/' . $file_service->id) }}" title="Download the original file for this file service">Download modified file
                                @endif
                            </a></td>
                            <td>
                                <nav class="nav" role="navigation" aria-label="Role options">
                                    @if ($file_service->status == 'Completed')
                                        <a class="nav-item nav-link" href="#" title="This file can not be edited. Only open file services can be edited.">
                                            <i class="fa fa-edit "></i>
                                        </a>
                                    @else
                                        <a class="nav-item nav-link" href="{{ URL::to('file_services/' . $file_service->id . '/edit') }}" title="Edit your file service">
                                            <i class="fa fa-edit "></i>
                                        </a>
                                    @endif
                                    <a class="nav-item nav-link" href="{{ URL::to('file_services/' . $file_service->id) }}" title="Show file service">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @if (ticketsExist($file_service->id))
                                    <a class="nav-item nav-link" href="{{ URL::to('file_services/' . $file_service->id . '/tickets') }}" title="View your ticket">
                                        <i class="fa fa-comment"></i>
                                    </a> 
                                    @else
                                    <a class="nav-item nav-link" href="{{ URL::to('/file_services/' . $file_service->id . '/createtickets') }}" title="View your ticket">
                                        <i class="fa fa-comment"></i>
                                    </a> 
                                    @endif
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
</div>
@endsection
  --}}

  @extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class='breadcrumb-item '>File services</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">

        @foreach($data as $file_service)

        @if($file_service->viewed_by_customer === 0)
        <div class = "modal fade bd-example-modal-sm" tabindex = "-1" 
           role = "dialog" aria-labelledby = "mySmallModalLabel" aria-hidden = "true">
           <div class = "modal-dialog modal-sm">
              <div class = "modal-content">
                 
                 <div class = "modal-header">
                    <h5 class = "modal-title" id = "exampleModalLabel">Message from tuner</h5>
                    <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                    <span aria-hidden = "true">×</span>
                    </button>
                 </div>
                 
                 <div class = "modal-body">
                    {{$file_service->note_to_customer}}
                    <a href="{{ url('file_services/'.$file_service->id) }}" class="text-nowrap font-weight-600">See details</a>
                 </div>
                 
                 <div class = "modal-footer">
                    <button type = "button" class = "btn btn-danger" 
                       data-dismiss = "modal">Close</button>
                    <!-- <button type = "button" class = "btn btn-success">Save</button> -->
                 </div>
                 
              </div>
           </div>
        </div>
     </div>
        @endif
         
        @endforeach
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="row">
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
                            <a href="{{ url('file_services?'.'search=Open') }}" class="text-nowrap font-weight-600">See details</a>
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
                            <a href="{{ url('file_services?'.'search=Waiting') }}" class="text-nowrap font-weight-600 waiting">See details</a>
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
                                <h5 class="card-title text-uppercase text-muted mb-0 ">Completed file services</h5>
                                <span class="h2 font-weight-600 mb-0 ">{{ $completed }}</span>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-file"></i>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                            <a href="{{ url('file_services?'.'search=Completed') }}" class="text-nowrap font-weight-600 all">See details</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> File services   
                <a href="{{ route('file_services.create') }}" class="float-right"><i class="fa fa-plus-square"></i> New</a>
             
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered data-table table-striped" >
                            <thead class="thead-light">
                            <tr id="">
                            <th>Car</th>
                            <th>VIN</th>
                            <th>Timeframe</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Dynograph</th>
                            <th>Modified</th>
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
@section('scripts')
<script type="text/javascript">

    
    $(document).ready(function () {
    
        var table = $('.data-table').DataTable({
        processing: true,
        responsive: true,
        ajax: document.URL,
        columns: [
            {data: 'make', name: 'make'},
            {data: 'vin', name: 'vin'},
            {data: 'timeframe', name: 'timeframe'},
            {data: 'created_at', name: 'created_at'},
            {data: 'status', name: 'status'},
            {data: 'dynograph', name: 'dynograph'},
            {data: 'modified', name: 'modified'},
            {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
            ],
            "columnDefs": [ 
                {
                    "targets": 7,
                    "data": "Action",
                    "render": function (data, type, full, meta){
                        var link = "<a href="+document.URL+'/'+ full.id+" class='btn btn-info' data-id='full->id' title='View your file service'><i class='fa fa-btn fa-search'></i> </a>";
                        var link2= '';
                        var link4= '';

                        if(full.file_service_id){
                            link2 = "<a href="+window.location.origin+'/file_services/'+ full.id+'/tickets'+" class='btn btn-info' data-id='full->id' title='View a ticket for this file service'><i class='fa fa-comment'></i> </a>";
                        }else{ 
                            link2 = "<a href="+window.location.origin+'/file_services/'+ full.id+'/tickets/create'+" class='btn btn-info' data-id='full->id' title='Open the ticket for this file service'><i class='fa fa-comment'></i> </a>";
                        }
                        if(full.status == 'Open'){
                        link4 = "<a href="+window.location.origin+'/file_services/'+ full.id+'/edit'+" class='btn btn-info' data-id='full->id' title='Edit'><i class='fa fa-edit'></i> </a>";
                        }else{
                            link4 = "<a href='' class='btn btn-info' data-id='full->id' title=Edit'><i class='fa fa-edit'></i> </a>";
                        }

                    //     if(full.viewed_by_customer == 0){
                    //         window.confirm = function() { return false; };
                    //   $.confirm({
                    // title: 'Confirm!',
                    // content: 'Are you sure want to delete and refund credits!'+full.viewed_by_customer,
                    // buttons: {
                    //     no: function () {
                        
                    //     },
                    //     yes: {
                    //         text: 'yes',
                    //         btnClass: 'btn-red',
                    //         keys: ['enter', 'shift'],
                    //         action: function(){
                    //             // $.ajax({
                    //             //     type: "GET",
                    //             //     url: "/refund/"+file_service_id,
                    //             //     data: {
                    //             //     "id": file_service_id,
                    //             //     "_token": token,
                    //             //     },
                    //             //     success: function (data) {
                    //             //         location.reload(true);
                    //             //     var table = $('.data-table').DataTable();
                            
                    //             //     table.ajax.reload();           },
                    //             //     error: function (data) {
                    //             //     }
                    //             //     });
                    //         }
                    //     }
                    //     }
                    // });
                    //     }

                        return link4 +' '+link+' '+link2;
                    },
                },
                {
                    "targets": 0,
                    "data": "make",
                    "render": function (data, type, full, meta){
                        return ""+full.make+' '+full.model+' '+full.engine+"";
                    },
                },
                {
                    "targets": 5,
                    "data": "make",
                    "render": function (data, type, full, meta){
                        if(data){
                            return "<a href="+window.location.origin+'/download_dynograph/'+ full.id+" data-id='full->id'> Dynograph</a>";
                        }else{
                            return '';
                        }

                    },
                },
                {
                    "targets": 6,
                    "data": "make",
                    "render": function (data, type, full, meta){
                        if(data){
                            return "<a href="+window.location.origin+'/download_modified/'+ full.id+" data-id='full->id'> 	Download modified file</a>";
                        }else{
                            return '';
                        }
                    },
                }]
        });
        
        });

        $('body').on('click', '#delete-file_service', function () {
            var user_id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var x = confirm("Are You sure want to delete !");

            
            });

            $(window).on('load', function() {
                $('.bd-example-modal-sm').modal('show');
            });
    </script>
@stop
@endsection

