@extends('admin.layouts.default')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Companies              
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered data-table" style="width:100%" style="overflow: x-scroll">
                            <thead class="thead-light">
                            <tr id="">
                                <th>Name</th>
                                <th>Address1</th>
                                <th>Address2</th>
                                <th>Zipcode</th>
                                <th>City</th>
                                <th>Domain Name</th>
                                <th>Country</th>
                                <th>Company Email</th>
                                <th>Tenant</th>
                                <th>Updated At</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach($companies as $key => $company)
                                <tr>
                                    <td>
                                        {{$company->company_name}}
                                    </td>
                                    <td>
                                        {{$company->address1}}
                                    </td>
                                    <td>
                                        {{$company->address2}}
                                    </td>
                                    <td>
                                        {{$company->zipcode}}
                                    </td>
                                    <td>
                                        {{$company->city}}
                                    </td>
                                    <td>
                                        {{$company->domain_name}}
                                    </td>
                                    <td>
                                        {{$company->country}}
                                    </td>
                                    <td>
                                        {{$company->company_email}}
                                    </td>
                                    <td>
                                        <a href="{{url('/tenants')}}" title='Tenants'>{{ \CreatyDev\Domain\Users\Models\User::where([['company_id', '=', $company->id], ['role', '=','admin']])->first()->name }}</a>
                                    </td>
                                    <td>
                                        {{$company->updated_at}}
                                    </td>
                                    <td>
                                        {{$company->created_at}}
                                    </td>
                                    <td>
                                        <nav class="nav" role="navigation" aria-label="Role options">
                                            @if ($company->blocked == 1)
                                            <div class="pr-1 pl-1 pt-1 pb-1">
                                                <a href="{{url('/companies/block/'.$company->id)}}" class='btn btn-danger' title='Unblock this company'><i class="fa fa-btn fa-ban"></i> </a>
                                            </div>
                                            @else 
                                            <div class="pr-1 pl-1 pt-1 pb-1">
                                                <a href="{{url('/companies/block/'.$company->id)}}" class='btn btn-primary' title='block this company'><i class="fa fa-btn fa-ban"></i> </a>
                                            </div>
                                            @endif
                                            <div class="pr-1 pl-1 pt-1 pb-1">
                                                <a href="{{url('companies/'.$company->id.'/edit')}}" class='btn btn-success' title='Edit'><i class="fa fa-btn fa-edit"></i> </a>
                                            </div>
                                            <div class="pr-1 pl-1 pt-1 pb-1">
                                                <meta name='csrf-token' content='$csrf_token'>
                                                <a href="#" id='delete-company' data-id="$company->id" class='btn btn-danger delete-company'><i class='fa fa-btn fa-trash'></i></a>
                                            </div>
                                        </nav>
                                    </td>
                                </tr>
                                @endforeach --}}
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
            // table = $('.data-table111').DataTable();
        var table = $('.data-table').DataTable({
        processing: true,
        {{-- serverSide: true, --}}
        responsive: true,
        ajax: "{{ route('companies.index') }}",
        columns: [
        {data: 'company_name', name: 'company_name'},
        {data: 'address1', name: 'address1'},
        {data: 'address2', name: 'address2'},
        {data: 'zipcode', name: 'zipcode'},
        {data: 'city', name: 'city'},
        {data: 'domain_name', name: 'domain_name'},
        {data: 'country', name: 'country'},
        {data: 'company_email', name: 'company_email'},
        {data: 'company_phone', name: 'company_phone'},
        {data: 'updated_at', name: 'updated_at'},
        {data: 'created_at', name: 'created_at'},
        {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
        ],
        "columnDefs": [ 
            {
                "targets": 11,
                "data": "Action",
                "render": function (data, type, full, meta){
                    if(full.blocked == '1'){
                        var link = "<a href="+window.location.origin+'/companies/block/'+ full.id +" class='btn btn-danger' data-id='full->id'><i class='fa fa-btn fa-ban' title='Unblock this company'></i> </a>";
                    }else{
                        var link = "<a href="+window.location.origin+'/companies/block/'+ full.id +" class='btn btn-primary' data-id='full->id'><i class='fa fa-btn fa-ban' title='Block this company'></i> </a>";
                    }
                    return link +" <a href="+document.URL+'/'+ full.id +'/edit'+" class='btn btn-success' data-id='full->id'><i class='fa fa-btn fa-edit'></i> </a> <meta name='csrf-token' content='$csrf_token'> <a id='delete-company' data-id=" +full.id + " class='btn btn-danger delete-company'><i class='fa fa-btn fa-trash'></i></a>";
                }
                },
            {
                "targets": 8,
                "data": "Action",
                "render": function (data, type, full, meta){
                        return "<a href="+window.location.origin+'/tenants'+"  data-id='full->id'>"+full.first_name+ ' '+full.last_name+"</a>";

                }
                }
                ]
        });
        
        });

        $('body').on('click', '#delete-company', function () {
            var company_id = $(this).data("id");
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
                                url: "/companies/"+company_id,
                                data: {
                                "id": company_id,
                                "_token": token,
                                },
                                success: function (data) {
                                var table = $('.data-table').DataTable();
                        
                                table.ajax.reload();           },
                                error: function (data) {
                                console.log('Error:', data);
                                }
                                });
                        }
                    }
                }
            });
        });
        
        </script>
@stop