@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('tuning_types.index') }}"> Tuning types</a>
</li>
<li class='breadcrumb-item active'>{{ $tuning_type->label }}</li>
<li class='breadcrumb-item active'>Tuning options</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Tuning options
                 <a href="{{ route('tuning_types.tuning_options.create', [$tuning_type->id]) }}" class="float-right"><i class="fa fa-plus-square"></i> New</a> 
                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered data-table " style="width:100%">
                            <thead class="thead-light">
                            <tr id="">
                                <th>Label</th>
                                <th>Credits</th>
                            <th>Tooltip</th>
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
    ajax: "{{ route('tuning_types.tuning_options.index', [$tuning_type->id]) }}",
    columns: [
    {data: 'label', name: 'label'},
    {data: 'credits', name: 'credits'},
    {data: 'tooltip.', name: 'tooltip.'},
    {data: 'tooltip.', name: 'tooltip', orderable: false, searchable: false},
    ],
    "columnDefs": [ 
        {
            "targets": 3,
            "data": "Action",
            "render": function (data, type, full, meta){
                return "<a href="+document.URL+'/'+ full.id +'/edit'+" class='btn btn-success' data-id='full->id'><i class='fa fa-btn fa-edit'></i> </a> <meta name='csrf-token' content='$csrf_token'> <a id='delete-tuning-options' data-id=" +full.id + " class='btn btn-danger delete-tuning-options'><i class='fa fa-btn fa-trash'></i></a>";
            }
            }]
    });   
    

    });

        $('body').on('click', '#delete-tuning-options', function () {
            var tuning_option_id = $(this).data("id");
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
                                url: "/tuning_types/"+ {{ $tuning_type->id }} +"/tuning_options/"+tuning_option_id,
                                data: {
                                "id": tuning_option_id,
                                "_token": token,
                                },
                                success: function (data) {
                                var table = $('.data-table').DataTable();
                        
                                table.ajax.reload();           },
                                error: function (data) {
                                }
                                });
                        }
                    }
                }
            });
        });
    </script>
@stop