@extends('admin.layouts.default')

@section('content')
{{--  <div class="clearfix">
    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Invoices                
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <form method="get" action="{{ route('invoices.index') }}" class="form-inline float-right">
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
                            <th>Invoice No.</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_no }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d M yy')}}</td>
                            <td>{{ $invoice->amount }}</td>
                            <td>{{ $invoice->description }}</td>
                            <td>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-12">
                        <div class="float-right" >
                            {{ $invoices->links() }}
                        </div>
                    </div>
                 
                </div>
            </div>
        </div>
    </div>
</div>  --}}

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Invoices 
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered data-table " style="width:100%" >
                            <thead class="thead-light">
                            <tr id="">
                            {{-- <th width="5%">No</th> --}}
                            <th>Invoice No.</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Description</th>
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
        ajax: "{{ route('invoices.index') }}",
        columns: [
        {data: 'invoice_no', name: 'invoice_no'},
        {data: 'created_at', name: 'created_at'},
        {data: 'amount', name: 'amount'},
        {data: 'description', name: 'description'},
        ]
        });
        
        });
        
        </script>
@stop