@extends('admin.layouts.default')

@section('content')
{{-- <div class="clearfix">
    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Orders                
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <form method="get" action="{{ route('orders.index') }}" class="form-inline float-right">
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
                            <th>Order Date</th>
                            <th>Invoice no.</th>
                            <th>Order Status</th>
                            <th>Amount</th>
                            <th>Customer</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{  \Carbon\Carbon::parse($order->created_at)->format('d-m-yy')}}</td>
                            <td>{{ CreatyDev\Domain\Invoice::where('id', $order->invoice_id)->firstOrFail()->invoice_no }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->amount }}</td>
                            <td>{{ CreatyDev\Domain\Users\Models\User::where('id', $order->user_id)->firstOrFail()->first_name }} {{ CreatyDev\Domain\Users\Models\User::where('id', $order->user_id)->firstOrFail()->last_name }}</td>
                            <td>
                                <nav class="nav" role="navigation" aria-label="Role options">
                                    <a href="{{ URL::to('/download/invoices/'. $order->id) }}" title="download" class="nav-item nav-link" data-original-title="Edit"><i class="fa fa-download "></i></a>
                                    <a href="{{ URL::to('/download/invoices/'. $order->id) }}" title="download" class="nav-item nav-link" data-original-title="Edit"><i class="fa fa-download "></i></a>
                                </nav>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                    
                </table>
                <div class="row">
                    <div class="col-12">
                        <div class="float-right" >
                            {{ $orders->links() }}
                        </div>
                    </div>
                 
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="clearfix">
    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Orders
                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered data-table table-striped" >
                            <thead class="thead-light">
                            <tr id="">
                            <th>Order no.</th>
                            <th>Order Date</th>
                            <th>Order Status</th>
                            <th>Amount</th>
                            <th>Description</th>
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
        ajax: "{{ route('orders.index') }}",
        columns: [
        {data: 'order_no', name: 'order_no'},
        {data: 'created_at', name: 'created_at'},
        {data: 'status', name: 'status'},
        {data: 'amount', name: 'amount'},
        {data: 'description', name: 'description'},
        {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
        ],
        "columnDefs": [ 
            {
                "targets": 5,
                "data": "Action",
                "render": function (data, type, full, meta){
                    return "<a href="+window.location.origin+'/download/invoices/'+ full.id+" class='btn btn-info' data-id='full->id'><i class='fa fa-btn fa-download'></i>  </a>";
                }
            }]
        });
        
        });

        $('body').on('click', '#delete-payment', function () {
            var payment_id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var x = confirm("Are You sure want to delete !");

            if(x){
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
                    console.log('Error:', data);
                    }
                    });
            }else{
                
            }
            
            
            });
        
        </script>
@stop