@extends('admin.layouts.default')
@section('title', 'My Tickets')
@section('admin.breadcrumb')
<li class='breadcrumb-item '>Tickets</li>
@endsection
@section('content')



<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-gradient-danger border-0">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0 ">Open tickets</h5>
                                <span class="h2 font-weight-600 mb-0 ">{{ $openTickets }}</span>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-ticket"></i>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                            <a href="{{ url('tickets?'.'search=Open') }}" class="text-nowrap font-weight-600">See details</a>
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
                                <h5 class="card-title text-uppercase text-muted mb-0 ">Closed tickets</h5>
                                <span class="h2 font-weight-600 mb-0 ">{{ $closedTickets }}</span>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-ticket"></i>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                            <a href="{{ url('tickets?'.'search=Closed') }}" class="text-nowrap font-weight-600 waiting">See details</a>
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
                                <h5 class="card-title text-uppercase text-muted mb-0 ">All tickets</h5>
                                <span class="h2 font-weight-600 mb-0 ">{{ $allTickets }}</span>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-ticket"></i>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                            <a href="{{ url('tickets') }}" class="text-nowrap font-weight-600 all">See details</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Tickets
                 {{-- <a href="{{ route('tickets.create') }}" class="float-right"><i class="fa fa-plus-square"></i> New</a>  --}}
                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered data-table " style="width:100%">
                            <thead class="thead-light">
                            <tr id="">
                            <th>Status</th>
                            <th>Category</th>
                            <th>Subject</th>
                            <th>Customer</th>
                            <th>Created At</th>
                            <th>Updated At</th>
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
<script type="text/javascript">
        $(document).ready(function () {
        
            var table = $('.data-table').DataTable({
            processing: true,
            {{-- serverSide: true, --}}
            responsive: true,
            "order": [[0,'asc']],
            ajax: document.URL,
            columns: [
            {data: 'status', name: 'status'},
            {data: 'name', name: 'name'},
            {data: 'subject', name: 'subject'},
            {data: 'last_name', name: 'last_name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'updated_at', name: 'updated_at', orderable: false, searchable: false},
            ],
            "columnDefs": [ 
                {
                    "targets": 6,
                    "data": "Action",
                    "render": function (data, type, full, meta){
                        return "<a href="+window.location.origin+'/tickets/'+ full.ticket_id+" class='btn btn-info' data-id='full->id'><i class='fa fa-btn fa-search'></i> </a>";
                    },
                },
                {
                    "targets": 3,
                    "data": "Action",
                    "render": function (data, type, full, meta){
                        return ""+full.first_name+' '+full.last_name+"";
                    },
                }]
            });
            
            });
    
            $('body').on('click', '#delete-user', function () {
                var user_id = $(this).data("id");
                var token = $("meta[name='csrf-token']").attr("content");
                var x = confirm("Are You sure want to delete !");
    
                if(x){
                    $.ajax({
                        type: "DELETE",
                        url: "/tuning-credits/"+user_id,
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