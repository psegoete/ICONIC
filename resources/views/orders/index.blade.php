@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Orders</li>
@endsection

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
                    <thead class="thead-light">
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
                                    <a href="{{ URL::to('orders/' . $order->id . '/edit')  }}" title="Edit" class="nav-item nav-link"><i class="fa fa-edit "></i></a>
                                    <a href="{{ URL::to('/download/invoices/'. $order->id) }}" title="Download" class="nav-item nav-link"><i class="fa fa-btn fa-download "></i></a>
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Orders
                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered data-table " style="width:100%">
                            <thead class="thead-light">
                            <tr id="">
                            <th>Order Date</th>
                            <th>Invoice no.</th>
                            <th>Order Status</th>
                            <th>Amount</th>
                            <th>Customer</th>
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
    <script type="text/javascript">

        $(document).ready(function () {
        var table = $('.data-table').DataTable({
        processing: true,
        {{-- serverSide: true, --}}
        responsive: true,
        ajax: "{{ route('orders.index') }}",
        columns: [
        {data: 'created_at', name: 'created_at'},
        {data: 'invoice_no', name: 'invoice_no'},
        {data: 'status', name: 'status'},
        {data: 'amount', name: 'amount'},
        {data: 'last_name', name: 'last_name'},
        {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
        ],
        "columnDefs": [ 
            {
                "targets": 5,
                "data": "Action",
                "render": function (data, type, full, meta){
                    return "<a href="+document.URL+'/'+ full.id +'/edit'+" class='btn btn-success' data-id='full->id'><i class='fa fa-btn fa-edit'></i> </a> <a href="+window.location.origin+'/download/invoices/'+ full.id+" class='btn btn-info' data-id='full->id'><i class='fa fa-btn fa-download'></i> </a>";
                }
            },
            {
                "targets": 4,
                "data": "Action",
                "render": function (data, type, full, meta){
                    return ""+full.first_name+' '+full.last_name+"";
                },
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