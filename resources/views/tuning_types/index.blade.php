@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Tuning types</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Tuning types
                 <a href="{{ route('tuning_types.create') }}" class="float-right"><i class="fa fa-plus-square"></i> New</a> 
                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered data-table " style="width:100%">
                            <thead class="thead-light">
                            <tr id="">
                            <th >Label</th>
                            <th >Credits</th>
                            <th >Tuning options</th>
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
    <script type="text/javascript">

        $(document).ready(function () {
        var t = $('.data-table').DataTable({
             processing: true, 
        {{--  serverSide: true,  --}}
        responsive: true,
        ajax: "{{ url('get-tuning-types') }}",
        columns: [
        {data: 'label', name: 'label'},
        {data: 'credits', name: 'credits'},
        {data: 'total', name: 'total'},
        {data: 'total', name: 'total'},
        ],
        "columnDefs": [ {
            "targets": 2,
            "data": "download_link",
            "render": function (data, type, full, meta){
                return " "+data+ ' ' +"  Tuning options<a href="+document.URL+'/'+ full.id +'/tuning_options'+" class='btn'> <i class='fa fa-btn fa-search'></i></a>";
            }
            },
            {
                "targets": 3,
                "data": "Action",
                "render": function (data, type, full, meta){
                    return "<a href="+document.URL+'/'+ full.id +'/edit'+" class='btn btn-success' data-id="+full.id+"><i class='fa fa-btn fa-edit'></i> </a> <meta name='csrf-token' content='$csrf_token'> <a id='delete_tuning_type' data-id=" +full.id + " class='btn btn-danger delete_tuning_type'><i class='fa fa-btn fa-trash'></i></a>";
                }
                }]
        });
        }); 

            $('body').on('click', '#delete_tuning_type', function () {
                var tuning_type_id = $(this).data("id");
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
                                    url: "/tuning_types/"+tuning_type_id,
                                    data: {
                                    "id": tuning_type_id,
                                    "_token": token,
                                    },
                                    success: function (data) {
                                        console.log('data');
                                    var table = $('.data-table').DataTable();
                            
                                    table.ajax.reload();           },
                                    error: function (data) {
                                        console.log('data');
                                    }
                                    });
                            }
                        }
                    }
                });
            });
        
        </script>
@stop