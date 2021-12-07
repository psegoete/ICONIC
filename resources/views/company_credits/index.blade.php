@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Sharing credits</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Sharing credits
                 <a href="{{ route('company-credits.create') }}" class="float-right"><i class="fa fa-plus-square"></i> New</a> 
                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered data-table " style="width:100%">
                            <thead class="thead-light">
                            <tr id="">
                            <th >Description</th>
                            <th >From</th>
                            <th >For</th>
                            <th >Action</th>
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
            "order": [],
            ajax: "{{ route('company-credits.index') }}",
            columns: [
            {data: 'description', name: 'description'},
            {data: 'from', name: 'from'},
            {data: 'for', name: 'for'},
            {data: 'for', name: 'for', orderable: false, searchable: false},
            ],
            "columnDefs": [ 
                {
                    "targets": 3,
                    "data": "Action",
                    "render": function (data, type, full, meta){
                        return "<a href="+document.URL+'/'+ full.id +'/edit'+" class='btn btn-success' data-id='full->id'><i class='fa fa-btn fa-edit'></i> </a> <meta name='csrf-token' content='$csrf_token'> <a id='delete-company-credits' data-id=" +full.id + " class='btn btn-danger delete-company-credits'><i class='fa fa-btn fa-trash'></i></a>";
                    }
                    },
                    {
                    "targets": 1,
                    "data": "Action",
                    "render": function (data, type, full, meta){
                        return "R " + data;
                    }
                    },
                    {
                    "targets": 2,
                    "data": "Action",
                    "render": function (data, type, full, meta){
                        return "R " + data;
                    }
                    },
                    {
                    "targets": 0,
                    "data": "Action",
                    "render": function (data, type, full, meta){
                        return data + ' credits';
                    }
                    }]
            });
            
            });


            $('body').on('click', '#delete-company-credits', function () {
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
                                    url: "/company-credits/"+company_id,
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