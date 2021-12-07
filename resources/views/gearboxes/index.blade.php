@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Gearboxes</li>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Gearboxes
                 <a href="{{ route('gearboxes.create') }}" class="float-right"><i class="fa fa-plus-square"></i> New</a> 
                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered data-table " style="width:100%">
                            <thead class="thead-light">
                            <tr id="">
                            <th>Name</th>
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
    <script type="text/javascript">

        $(document).ready(function () {
        
        var table = $('.data-table').DataTable({
        processing: true,
        {{-- serverSide: true, --}}
        responsive: true,
        ajax: "{{ route('gearboxes.index') }}",
        columns: [
        {data: 'gbName', name: 'gbName'},
        {data: 'updated_at', name: 'updated_at'},
        {data: 'updated_at', name: 'updated_at'},
        ],
        "columnDefs": [ 
            {
                "targets": 2,
                "data": "Action",
                "render": function (data, type, full, meta){
                    return "<a href="+document.URL+'/'+ full.id +'/edit'+" class='btn btn-success' data-id='full->id'><i class='fa fa-btn fa-edit'></i> </a> <meta name='csrf-token' content='$csrf_token'> <a id='delete-gearbox' data-id=" +full.id + " class='btn btn-danger delete-gearbox'><i class='fa fa-btn fa-trash'></i></a>";
                }
                }]
        });
        
        });

        $('body').on('click', '#delete-gearbox', function () {
            var gerabox_id = $(this).data("id");
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
                                url: "/gearboxes/"+gerabox_id,
                                data: {
                                "id": gerabox_id,
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