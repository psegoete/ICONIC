@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Payment getway</li>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Payment getaways
                 <a href="{{ route('payments.create') }}" class="float-right"><i class="fa fa-plus-square"></i> New</a> 
                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered data-table " style="width:100%" >
                            <thead class="thead-light">
                            <tr id="">
                            {{-- <th width="5%">No</th> --}}
                            <th>Payment</th>
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
        {{--  serverSide: true,  --}}
        responsive: true,
        ajax: "{{ route('payments.index') }}",
        columns: [
        {data: 'payment_name', name: 'payment_name'},
        {data: 'created_at', name: 'created_at'},
        {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
        ],
        "columnDefs": [ 
            {
                "targets": 2,
                "data": "Action",
                "render": function (data, type, full, meta){
                    return "<a href="+document.URL+'/'+ full.id +'/edit'+" class='btn btn-success' data-id='full->id'><i class='fa fa-btn fa-edit'></i> </a> <meta name='csrf-token' content='$csrf_token'> <a id='delete-payment' data-id=" +full.id + " class='btn btn-danger delete-payment'><i class='fa fa-btn fa-trash'></i></a>";
                }
            }]
        });
        
        });

        $('body').on('click', '#delete-payment', function () {
            var payment_id = $(this).data("id");
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
                                url: "/payments/"+payment_id,
                                data: {
                                "id": payment_id,
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