@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item active'>Customers</li>
@endsection

{{--  @section('content')  --}}
{{-- <div class="clearfix">
    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Customers
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form method="get" action="{{ route('customers.index') }}" class="form-inline float-right">
                            {{ csrf_field() }}
                            <div class="form-group mb-2">
                                <input type="text" placeholder="Search.." name="search" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    
                </div>
                    
                  
        
                <table class="table table-responsive-sm table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Activated</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $customer)
                        <tr>
                            <td>{{ $customer->first_name }}</td>
                            <td>{{ $customer->last_name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->activated }}</td>
                            <td>
                                <nav class="nav" role="navigation" aria-label="Customer options">
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="" class="nav-item nav-link" data-original-title="Edit"><i class="fa fa-ban "></i></a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="" class="nav-item nav-link" data-original-title="Edit"><i class="fa fa-edit "></i></a>

                                    <a href="{{url('customers/' .$customer->id. '/file_services')}}" data-toggle="tooltip" data-placement="top" title="Show the file services for this customer" class="nav-item nav-link" data-original-title="file services"><i class="fa fa-file "></i></a>
                                    <a href="{{url('transactions/' .$customer->id)}}" data-toggle="tooltip" data-placement="top" title="Show the transactions for this customer" class="nav-item nav-link" data-original-title="transactions"><i class="fa fa-btn fa-money"></i></a>

                                    <a href="#" class="nav-item nav-link" title="Log in as this customer"
                                           onclick="event.preventDefault(); document.getElementById('impersonate-customer-form-{{ $customer->id }}').submit()">
                                           <i class="fa fa-btn fa-user"></i>
                                        </a>
                                        <form id="impersonate-customer-form-{{ $customer->id }}"
                                              action="{{ route('users.impersonate.store')}}"
                                              method="POST" style="display: none;">
                                            @csrf
                                            <input id="email" type="hidden" name="email" value="{{ old('email', $customer->email) }}">
                                        </form>
                                        

                                    <a href="#" class="nav-item nav-link" title="Remove this customer"
                                           onclick="event.preventDefault(); document.getElementById('delete-customer-form-{{ $customer->id }}').submit()">
                                           <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="delete-customer-form-{{ $customer->id }}"
                                              action="{{ route('customers.destroy', $customer->id) }}"
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
                            {{ $users->links() }}
                        </div>
                    </div>
                 
                </div>
            </div>
        </div>
    </div>
</div> --}}

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Customers                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div>@include('layouts.partials.alerts._alerts')</div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered data-table " style="width:100%">
                            <thead class="thead-light">
                            <tr id="">
                            <th>First Name</th>
                            <th>Active</th>
                            <th>Tuning credits</th>
                            <th>File services</th>
                            <th>email</th>
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
        {{-- serverSide: true, --}}
        responsive: true,
        ajax: "{{ route('customers.index') }}",
        columns: [
        {data: 'first_name', name: 'first_name'},
        {data: 'activated', name: 'activated'},
        {data: 'credits', name: 'credits'},
        {data: 'total_files', name: 'total_files'},
        {data: 'email', name: 'email'},
        {data: 'updated_at', name: 'updated_at'},
        {data: 'updated_at', name: 'updated_at', orderable: false, searchable: false},
        ],
        "columnDefs": [ 
            {
                "targets": 6,
                "data": "Action",
                "render": function (data, type, full, meta){
                    var link = "<a href="+window.location.origin+'/edit-user/'+ full.id +" class='btn btn-info' data-id='full->id' title='Unblock this customer' ><i class='fa fa-edit'></i></a>";
                    if(full.blocked == 1){
                        link += " <a href="+window.location.origin+'/blockOrUnblock/'+ full.id +" class='btn btn-danger' data-id='full->id' title='Unblock this customer' ><i class='fa fa-ban'></i></a>";
                        var blockLink = "<a id='impersonate-customer1' data-id=" +full.id + " data-email=" +full.email + " class='btn btn-primary impersonate-customer1' title='Impersonate this customer'><i class='fa fa-btn fa-user'></i></a>";
                    }else{
                        link += " <a href="+window.location.origin+'/blockOrUnblock/'+ full.id +" class='btn btn-success' data-id='full->id' title='Block this customer' ><i class='fa fa-ban'></i></a>";
                        var blockLink = "<a id='impersonate-customer' data-id=" +full.id + " data-email=" +full.email + " class='btn btn-primary impersonate-customer' title='Impersonate this customer'><i class='fa fa-btn fa-user'></i></a>";
                    }

                    return link +' ' + "<a href="+window.location.origin+'/customers/'+ full.id +'/file_services'+" class='btn btn-success' data-id='full->id' title='View the file services for this customer' ><i class='fa fa-file'></i></a> <a href="+window.location.origin+'/transactions/'+ full.id +" class='btn btn-success' data-id='full->id' title='View the transactions for this customer'><i class='fa fa-btn fa-money'></i> </a> <meta name='csrf-token' content='$csrf_token'>" + blockLink + " <a id='delete-customer' data-id=" +full.id + " data-email=" +full.email + " class='btn btn-danger delete-customer' title='Remove this customer'><i class='fa fa-btn fa-trash'></i></a>";
                }
            },
            {
                "targets": 1,
                "data": "Action",
                "render": function (data, type, full, meta){
                    if(data == 1){
                        return 'Activated';

                    }else{
                        return "<meta name='csrf-token' content='$csrf_token'> <a href="+window.location.origin+'/customers/'+ full.id +'/edit'+" id='activate-customer' data-id=" +full.id + " class='btn btn-primary activate-customer'>Activate</a>";
                    }
                }
            },
            {
                "targets": 0,
                "data": "Action",
                "render": function (data, type, full, meta){
                    return full.first_name +' '+ full.last_name;
                }
            }]
        });
        
        });

        $('body').on('click', '#impersonate-customer', function () {
            var email = $(this).data("email");
            var token = $("meta[name='csrf-token']").attr("content");
            $.confirm({
                title: 'Confirm!',
                content: 'Are You sure want to impersonate this customer!',
                buttons: {
                    no: function () {
                    
                    },
                    yes: {
                        text: 'yes',
                        btnClass: 'btn-primary',
                        keys: ['enter', 'shift'],
                        action: function(){
                            $.ajax({
                                type: "POST",
                                url: "{{ route('users.impersonate.store')}}",
                                data: {
                                "email": email,
                                "_token": token,
                                },
                                success: function (data) {
                                window.location = '/';
                            },
                                error: function (data) {
                                console.log('Error:', data);
                                }
                                });
                        }
                    }
                }
            });
        });


        $('body').on('click', '#delete-customer', function () {
            var user_id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            $.confirm({
                title: 'Confirm!',
                content: 'Are You sure want to delete!',
                buttons: {
                    no: function () {
                    
                    },
                    yes: {
                        text: 'yes',
                        btnClass: 'btn-red',
                        keys: ['enter', 'shift'],
                        action: function(){
                            
                            $.ajax({
                                type: "DELETE",
                                url: "/customers/"+user_id,
                                data: {
                                "id": user_id,
                                "_token": token,
                                },
                                success: function (data) {
                                    {{--  console.log('data');  --}}
                                var table = $('.data-table').DataTable();
                        
                                table.ajax.reload();           },
                                error: function (data) {
                                    {{--  console.log('data');  --}}
                                }
                                });
                        }
                    }
                }
            });
        });

        $('body').on('click', '#activate-customer1', function () {
            var user_id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            $.confirm({
                title: 'Confirm!',
                content: 'Are You sure want to activate this customer?',
                buttons: {
                    no: function () {
                    
                    },
                    yes: {
                        text: 'yes',
                        btnClass: 'btn-primary',
                        keys: ['enter', 'shift'],
                        action: function(){
                            
                            $.ajax({
                                type: "GET",
                                url: "/customers/"+user_id+'/edit',
                                data: {
                                "id": user_id,
                                "_token": token,
                                },
                                success: function (data) {
                                var table = $('.data-table').DataTable();
                        
                                table.ajax.reload();           },
                                error: function (data) {
                                    console.log(data);
                                }
                                });
                        }
                    }
                }
            });
        });
           
            
        
        </script>
@stop